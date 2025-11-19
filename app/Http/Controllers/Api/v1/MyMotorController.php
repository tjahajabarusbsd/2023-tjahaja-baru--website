<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MyMotorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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

        $url_services = env('GET_URL_SERIVCES');

        $registeredMotors = $getAllNomorRangka->map(function ($item) use ($url_services) {
            $apiUrl = $url_services . "?id=" . $item->nomor_rangka;
            $secret = env('SECRET_RIWAYAT_SERVICE');
            $now = date('Y_m_d');
            $token = md5($now . $secret);

            // Request ke API eksternal
            $response = Http::withoutVerifying()->withHeaders([
                'X-XSRF-TOKEN' => $token
            ])->get($apiUrl);
            $data = $response->json();

            // Ambil data dari respons API dan format ulang
            $riwayatServis = [];

            if (is_array($data)) {
                foreach ($data as $d) {
                    $riwayatServis[] = [
                        'service_id' => $d['id'] ?? '',
                        'tanggal_servis' => $d['event_walkin'] ?? '',
                    ];
                }
            }

            return [
                'motor_id' => (string) $item->id ?? '',
                'nama_model' => (string) $item->nama_model ?? '',
                'nomor_plat' => (string) $item->nomor_plat ?? '',
                'nomor_rangka' => (string) $item->nomor_rangka ?? '',
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

        $url_services = env('GET_URL_SERIVCES');
        $apiUrl = $url_services . "?id=" . $nomorRangka;
        $secret = env('SECRET_RIWAYAT_SERVICE');
        $now = date('Y_m_d');
        $token = md5($now . $secret);
        $response = Http::withoutVerifying()->withHeaders([
            'X-XSRF-TOKEN' => $token
        ])->get($apiUrl);
        $data = $response->json();

        if (!$data) {
            return ApiResponse::error('Riwayat servis tidak ditemukan.', 404);
        }

        foreach ($data as &$innerArray) {
            if (isset($innerArray['part_id'])) {
                $partIds = json_decode($innerArray['part_id'], true);

                $partNames = [];
                foreach ($partIds as $partId) {
                    $part = MasterPart::where('part_number', $partId)->first();
                    if ($part) {
                        $partNames[] = $part->part_name;
                    } else {
                        $partNames[] = 'UNNAME PART';
                    }
                }

                $innerArray['part_name'] = $partNames;
            } else {
                $innerArray['part_name'] = [];
            }
        }

        $filtered = collect($data)->firstWhere('id', $svsId);

        if (!$filtered) {
            return ApiResponse::error('Data servis tidak ditemukan', 404);
        }

        // Bersihkan data nested (karena svc_pac, svc_cost, dll dalam bentuk string JSON array)
        $paketList = json_decode($filtered['svc_pac'], true) ?? [];
        $hargaList = json_decode($filtered['svc_cost'], true) ?? [];
        $partNameList = $filtered['part_name'] ?? [];
        $partQtyList = json_decode($filtered['part_qty'], true) ?? [];
        $partHargaList = json_decode($filtered['part_cost'], true) ?? [];

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
        foreach ($partNameList as $index => $partName) {
            $partTerpakai[] = [
                'nama_part' => $partName,
                'jumlah' => (int) ($partQtyList[$index] ?? 0),
                'harga_total' => (int) (($partHargaList[$index] ?? 0) * ($partQtyList[$index] ?? 0)),
            ];
        }

        // Tanggal servis dari event_invoice
        $tanggalServis = Carbon::parse($filtered['event_invoice'])->translatedFormat('d F Y');

        return ApiResponse::success('Detail servis berhasil diambil', [
            'service_id' => $filtered['svc_id'],
            'tanggal_servis' => $tanggalServis,
            'nomor_invoice' => $filtered['invoice'],
            'tempat_servis' => $filtered['nama_dealer'],
            'kategori_servis' => $filtered['svc_cat'],
            'mekanik' => $filtered['mechanic_name'],
            'paket_servis' => $paketServis,
            'part_terpakai' => $partTerpakai,
            'total_biaya' => (int) $filtered['cost_total'],
            // 'review' => [
            //     'rating' => 5, // default rating
            //     'nama_pengguna' => $filtered['kons_nama'],
            //     'ulasan' => $filtered['cust_respon'],
            // ],
        ]);
    }
}
