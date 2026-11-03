<?php

namespace App\Console\Commands;

use App\Models\Dealer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDealersFromKml extends Command
{
  protected $signature = 'dealers:import-kml
                            {file : Path file KML, contoh: storage/app/imports/Dealer_Yamaha_Tjahaja_Baru.kml}
                            {--dry-run : Tampilkan hasilnya saja, tanpa menyimpan ke database}
                            {--overwrite : Timpa latitude/longitude yang sudah terisi}';

  protected $description = 'Import nama dan koordinat dealer dari file KML Google My Maps';

  private const KML_NS = 'http://www.opengis.net/kml/2.2';

  public function handle(): int
  {
    $path = $this->argument('file');
    if (!is_file($path)) {
      $path = base_path($path);
    }

    if (!is_file($path)) {
      $this->error('File tidak ditemukan: ' . $this->argument('file'));
      return self::FAILURE;
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($path);

    if ($xml === false) {
      $this->error('File KML tidak bisa dibaca (format XML tidak valid).');
      return self::FAILURE;
    }

    $xml->registerXPathNamespace('k', self::KML_NS);
    $placemarks = $xml->xpath('//k:Placemark') ?: [];

    $dryRun    = (bool) $this->option('dry-run');
    $overwrite = (bool) $this->option('overwrite');

    // Dealer yang sudah ada di database, dikunci dengan nama yang sudah dinormalisasi
    $existing = Dealer::all()->keyBy(fn($d) => $this->normalize($d->name_dealer));

    $rows    = [];
    $created = $updated = $skipped = $invalid = 0;

    DB::beginTransaction();

    try {
      foreach ($placemarks as $placemark) {
        $kml  = $placemark->children(self::KML_NS);
        $name = trim((string) $kml->name);
        $raw  = trim((string) ($kml->Point->coordinates ?? ''));

        // Format KML: longitude,latitude,altitude (kebalikan dari Google Maps)
        $parts = array_map('trim', explode(',', $raw));
        $lng   = $parts[0] ?? null;
        $lat   = $parts[1] ?? null;

        if (
          $name === '' || !is_numeric($lat) || !is_numeric($lng)
          || abs((float) $lat) > 90 || abs((float) $lng) > 180
        ) {
          $invalid++;
          $rows[] = ['Dilewati (tidak valid)', $name ?: '(tanpa nama)', $lat, $lng];
          continue;
        }

        $dealer = $existing->get($this->normalize($name));

        if (!$dealer) {
          if (!$dryRun) {
            Dealer::create([
              'name_dealer' => $name,
              'latitude'    => $lat,
              'longitude'   => $lng,
            ]);
          }
          $created++;
          $rows[] = ['Baru', $name, $lat, $lng];
          continue;
        }

        $hasCoords = is_numeric($dealer->latitude) && is_numeric($dealer->longitude);

        if ($hasCoords && !$overwrite) {
          $skipped++;
          $rows[] = ['Dilewati (koordinat sudah ada)', $dealer->name_dealer, $dealer->latitude, $dealer->longitude];
          continue;
        }

        if (!$dryRun) {
          $dealer->update(['latitude' => $lat, 'longitude' => $lng]);
        }
        $updated++;
        $rows[] = ['Koordinat diisi', $dealer->name_dealer, $lat, $lng];
      }

      $dryRun ? DB::rollBack() : DB::commit();
    } catch (\Throwable $e) {
      DB::rollBack();
      $this->error('Import dibatalkan: ' . $e->getMessage());
      return self::FAILURE;
    }

    $this->table(['Aksi', 'Nama', 'Latitude', 'Longitude'], $rows);
    $this->newLine();
    $this->info(sprintf(
      '%s: %d baru, %d koordinat diisi, %d dilewati, %d tidak valid (total %d placemark).',
      $dryRun ? 'DRY RUN (tidak ada yang disimpan)' : 'Selesai',
      $created,
      $updated,
      $skipped,
      $invalid,
      count($placemarks)
    ));

    return self::SUCCESS;
  }

  private function normalize(?string $name): string
  {
    return preg_replace('/\s+/u', ' ', trim(mb_strtolower((string) $name)));
  }
}
