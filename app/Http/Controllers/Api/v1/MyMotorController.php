<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\NomorRangka;
use App\Models\MasterPart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class MyMotorController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rangka' => [
                'required',
                'string',
            ],
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
            'ktp' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
            'kk' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nomor_rangka.required' => 'Nomor rangka wajib diisi.',
            'nomor_rangka.string' => 'Nomor rangka harus berupa teks.',
        
            'phone_number.required' => 'Nomor handphone wajib diisi.',
            'phone_number.string' => 'Nomor handphone harus berupa teks.',
            'phone_number.regex' => 'Format nomor handphone tidak valid.',
        
            'ktp.required' => 'Foto KTP wajib diunggah.',
            'ktp.file' => 'KTP harus berupa file.',
            'ktp.image' => 'File KTP harus berupa gambar.',
            'ktp.mimes' => 'KTP harus berformat JPG, JPEG, atau PNG.',
            'ktp.max' => 'Ukuran file KTP maksimal 2MB.',
        
            'kk.required' => 'Foto KK wajib diunggah.',
            'kk.file' => 'KK harus berupa file.',
            'kk.image' => 'File KK harus berupa gambar.',
            'kk.mimes' => 'KK harus berformat JPG, JPEG, atau PNG.',
            'kk.max' => 'Ukuran file KK maksimal 2MB.',
        ]);

        $ktpPath = $request->file('ktp')->store('uploads/ktp', 'public');
        $kkPath = $request->file('kk')->store('uploads/kk', 'public');

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();

            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => $firstError,
                'data' => null,
            ], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Unauthorized',
                'data' => null,
            ], 401);
        }

        $nomorRangka = NomorRangka::create([
            'nomor_rangka' => $request->nomor_rangka,
            'phone_number' => $request->phone_number,
            'user_id' => $user->id,
            'ktp' => $ktpPath,
            'kk' => $kkPath,
            'status_verifikasi' => 'pending',
        ]);

        if (!$nomorRangka) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Gagal mendaftarkan motor. Silakan coba lagi.',
                'data' => null,
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Motor berhasil didaftarkan',
            'data' => [
                'motor_id' => $nomorRangka->id,
                'nomor_rangka' => (string) $request->nomor_rangka,
                'status_verifikasi' => 'pending',
            ]
        ], 200);
    }

    public function list()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Unauthorized',
                'data' => null,
            ], 401);
        }

        $getAllNomorRangka = NomorRangka::where('user_id', $user->id)
            ->where('status_verifikasi', 'verified')
            ->get();

        if ($getAllNomorRangka->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Tidak ada motor terdaftar',
                'data' => null,
            ], 404);
        }

        $registeredMotors = $getAllNomorRangka->map(function ($item) {
            return [
                'nama_model'   => $item->nama_model,
                'nomor_plat'    => $item->nomor_plat,
                'nomor_rangka'  => $item->nomor_rangka,
            ];
        });

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Daftar motor berhasil diambil',
            'data' => $registeredMotors,
        ], 200);
    }

    public function getRiwayatServis($nomorRangka, $svsId)
    {
        $url_services = env('GET_URL_SERIVCES');
        $apiUrl = $url_services . "?id=" . $nomorRangka;
        $response = Http::withoutVerifying()->get($apiUrl);
        $data = $response->json();

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Riwayat servis tidak ditemukan.',
                'data' => null,
            ], 404);
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
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Data servis tidak ditemukan',
                'data' => null,
            ], 404);
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
                'harga_satuan' => (int) ($partHargaList[$index] ?? 0),
            ];
        }
    
        // Tanggal servis dari event_invoice
        $tanggalServis = Carbon::parse($filtered['event_invoice'])->translatedFormat('d F Y');
    
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Detail servis berhasil diambil',
            'data' => [
                'service_id' => $filtered['svc_id'],
                'tanggal_servis' => $tanggalServis,
                'nomor_invoice' => $filtered['invoice'],
                'tempat_servis' => $filtered['nama_dealer'],
                'kategori_servis' => $filtered['svc_cat'],
                'mekanik' => $filtered['mechanic_name'],
                'paket_servis' => $paketServis,
                'part_terpakai' => $partTerpakai,
                'total_biaya' => (int) $filtered['cost_total'],
                'review' => [
                    'rating' => 5, // default rating
                    'nama_pengguna' => $filtered['kons_nama'],
                    'ulasan' => $filtered['cust_respon'],
                ],
            ],
        ]);
    }
}
