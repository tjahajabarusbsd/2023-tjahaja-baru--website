<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MyMotorRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use App\Models\NomorRangka;
use App\Models\MasterPart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class MyMotorController extends Controller
{
    public function register(MyMotorRequest $request)
    {
        $user = Auth::user();

        $existingMotor = NomorRangka::where('nomor_rangka', $request->nomor_rangka)
            ->where('status_verifikasi', '!=', 'rejected')
            ->first();

        if ($existingMotor) {
            return ApiResponse::error('Motor dengan nomor rangka ini sudah terdaftar.', 409);
        }

        $ktpBase64 = 'data:' . $request->file('ktp')->getMimeType() . ';base64,' . base64_encode(file_get_contents($request->file('ktp')));
        $kkBase64 = 'data:' . $request->file('kk')->getMimeType() . ';base64,' . base64_encode(file_get_contents($request->file('kk')));

        $nomorRangka = NomorRangka::create([
            'nomor_rangka' => strtoupper(preg_replace('/\s+/', '', $request->nomor_rangka)),
            'phone_number' => $request->phone_number,
            'user_public_id' => $user->id,
            'ktp' => $ktpBase64,
            'kk' => $kkBase64,
            'status_verifikasi' => 'pending',
        ]);

        if (!$nomorRangka) {
            return ApiResponse::error('Gagal mendaftarkan motor. Silakan coba lagi.', 500);
        }

        return ApiResponse::success('Motor berhasil didaftarkan', [
            'motor_id' => (string) $nomorRangka->id,
            'nomor_rangka' => (string) $request->nomor_rangka,
            'status_verifikasi' => 'pending',
        ]);
    }

    /**
     * Ambil data mentah riwayat servis dari API database penjualan untuk
     * satu nomor rangka.
     *
     * Return null kalau gagal dengan cara APAPUN (koneksi putus, timeout,
     * response bukan sukses, atau bentuk data tidak sesuai ekspektasi) --
     * caller WAJIB menganggap null sebagai "riwayat tidak tersedia saat
     * ini", bukan "riwayat kosong secara permanen".
     *
     * Disatukan di sini supaya list() dan getRiwayatServis() tidak
     * duplikasi logic membangun token & memanggil API eksternal yang
     * sama persis.
     */
    private function _fetchRiwayatServisMentah(string $nomorRangka): ?array
    {
        $urlServices = env('GET_URL_SERIVCES');
        $apiUrl = $urlServices . '?id=' . $nomorRangka;
        $secret = env('SECRET_RIWAYAT_SERVICE');
        $now = date('Y_m_d');
        $token = md5($now . $secret);

        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->withHeaders(['X-XSRF-TOKEN' => $token])
                ->get($apiUrl);
        } catch (ConnectionException $e) {
            Log::warning('Gagal konek ke API database penjualan', [
                'nomor_rangka' => $nomorRangka,
                'message' => $e->getMessage(),
            ]);
            return null;
        }

        if (!$response->successful()) {
            Log::warning('API database penjualan membalas status gagal', [
                'nomor_rangka' => $nomorRangka,
                'status' => $response->status(),
            ]);
            return null;
        }

        $data = $response->json();

        // Data servis yang valid harus berbentuk list (array numerik).
        // Kalau API eksternal membalas object error (mis. nomor rangka
        // tidak ditemukan), json_decode tetap menghasilkan array asosiatif
        // di PHP -- array_is_list() yang membedakan keduanya.
        if (!is_array($data) || !array_is_list($data)) {
            Log::warning('Bentuk response API database penjualan tidak sesuai ekspektasi', [
                'nomor_rangka' => $nomorRangka,
                'response' => $data,
            ]);
            return null;
        }

        return $data;
    }

    /**
     * Konversi tanggal dari API eksternal ke format Indonesia dengan aman.
     * Mengembalikan null (bukan melempar exception) kalau formatnya tidak
     * bisa di-parse, supaya satu tanggal rusak tidak menjatuhkan seluruh
     * response.
     */
    private function _formatTanggalAman(?string $tanggal): ?string
    {
        if (empty($tanggal)) {
            return null;
        }

        try {
            return Carbon::parse($tanggal)->translatedFormat('d F Y');
        } catch (\Throwable $e) {
            Log::warning('Gagal parse tanggal dari API database penjualan', [
                'tanggal' => $tanggal,
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Ubah daftar part_id (JSON string) jadi daftar nama part, dengan
     * fallback aman kalau part_id kosong/rusak atau part tidak ditemukan
     * di MasterPart.
     */
    private function _resolvePartNames(?string $partIdJson): array
    {
        if (empty($partIdJson)) {
            return [];
        }

        $partIds = json_decode($partIdJson, true);
        if (!is_array($partIds)) {
            Log::warning('part_id dari API database penjualan bukan JSON array yang valid', [
                'part_id_raw' => $partIdJson,
            ]);
            return [];
        }

        return array_map(function ($partId) {
            $part = MasterPart::where('part_number', $partId)->first();
            return $part?->part_name ?? 'UNNAME PART';
        }, $partIds);
    }

    public function list()
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $getAllNomorRangka = NomorRangka::where('user_public_id', $user->id)->get();

        if ($getAllNomorRangka->isEmpty()) {
            return ApiResponse::error('Tidak ada motor terdaftar pada akun ini.', 404);
        }

        $registeredMotors = $getAllNomorRangka->map(function ($item) {
            $dataMentah = $this->_fetchRiwayatServisMentah($item->nomor_rangka);

            // Gagal mengambil riwayat servis (API down/timeout/berubah)
            // TIDAK menggagalkan seluruh response -- motor tetap
            // ditampilkan, riwayat servisnya saja yang kosong untuk saat
            // ini. Ini beda kondisi dengan "memang belum pernah servis",
            // tapi dari sisi Flutter keduanya aman ditampilkan sebagai
            // "Belum ada riwayat servis" tanpa app perlu tahu bedanya.
            $riwayatServis = [];
            if ($dataMentah !== null) {
                foreach ($dataMentah as $d) {
                    $riwayatServis[] = [
                        'service_id' => $d['id'] ?? '',
                        'tanggal_servis' => $d['event_walkin'] ?? '',
                    ];
                }
            }

            return [
                'motor_id' => (string) $item->id,
                'nama_model' => (string) $item->nama_model,
                'nomor_plat' => (string) $item->nomor_plat,
                'nomor_rangka' => (string) $item->nomor_rangka,
                'status_verifikasi' => $item->status_verifikasi,
                'riwayat_servis' => $riwayatServis,
            ];
        });

        return ApiResponse::success(
            'Daftar motor berhasil diambil',
            $registeredMotors
        );
    }

    public function getRiwayatServis($nomorRangka, $svsId)
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $motor = NomorRangka::where('nomor_rangka', $nomorRangka)
            ->where('user_public_id', $user->id)
            ->first();

        if (!$motor) {
            return ApiResponse::error('Motor tidak ditemukan atau tidak terdaftar pada akun ini.', 404);
        }

        $dataMentah = $this->_fetchRiwayatServisMentah($nomorRangka);

        if ($dataMentah === null) {
            // Beda pesan dengan "data servis tidak ditemukan" di bawah --
            // ini kegagalan mengambil data (API down/error), bukan memang
            // datanya tidak ada. 503 lebih tepat daripada 404 di sini.
            return ApiResponse::error(
                'Tidak dapat mengambil riwayat servis saat ini. Silakan coba lagi.',
                503
            );
        }

        $filtered = collect($dataMentah)->firstWhere('id', $svsId);

        if (!$filtered) {
            return ApiResponse::error('Data servis tidak ditemukan', 404);
        }

        $partNames = $this->_resolvePartNames($filtered['part_id'] ?? null);

        // Bersihkan data nested (karena svc_pac, svc_cost, dll dalam bentuk string JSON array)
        $paketList = json_decode($filtered['svc_pac'] ?? '', true) ?? [];
        $hargaList = json_decode($filtered['svc_cost'] ?? '', true) ?? [];
        $partQtyList = json_decode($filtered['part_qty'] ?? '', true) ?? [];
        $partHargaList = json_decode($filtered['part_cost'] ?? '', true) ?? [];

        // Format paket_servis
        $paketServis = [];
        foreach ($paketList as $index => $namaPaket) {
            $paketServis[] = [
                'nama_paket' => $namaPaket,
                'harga' => (int) ($hargaList[$index] ?? 0),
            ];
        }

        // Format part_terpakai
        $partTerpakai = [];
        foreach ($partNames as $index => $partName) {
            $partTerpakai[] = [
                'nama_part' => $partName,
                'jumlah' => (int) ($partQtyList[$index] ?? 0),
                'harga_total' => (int) (($partHargaList[$index] ?? 0) * ($partQtyList[$index] ?? 0)),
            ];
        }

        $tanggalServis = $this->_formatTanggalAman($filtered['event_invoice'] ?? null);

        return ApiResponse::success('Detail servis berhasil diambil', [
            'service_id' => $filtered['svc_id'] ?? '',
            'tanggal_servis' => $tanggalServis ?? '-',
            'nomor_invoice' => $filtered['invoice'] ?? '',
            'tempat_servis' => $filtered['nama_dealer'] ?? '',
            'kategori_servis' => $filtered['svc_cat'] ?? '',
            'mekanik' => $filtered['mechanic_name'] ?? '',
            'paket_servis' => $paketServis,
            'part_terpakai' => $partTerpakai,
            'total_biaya' => (int) ($filtered['cost_total'] ?? 0),
        ]);
    }
}
