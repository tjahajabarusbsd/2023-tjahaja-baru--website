<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Review;
use App\Models\GroupProductSpec;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function getDataVariant($uri, Request $request)
    {
        $cookieSales = $request->cookie('sales');
        $group = Group::where('uri', $uri)->first();
        $groupSpec = GroupProductSpec::where('group_id', $group->id )->first();

        if ($groupSpec) {
            // Mengelompokkan spesifikasi ke dalam kategori
            $specifications = [
                'mesin' => [
                    ['label' => 'Tipe Mesin', 'value' => $groupSpec->tipe_mesin],
                    ['label' => 'Jumlah/Posisi Silinder', 'value' => $groupSpec->jumlah_silinder],
                    ['label' => 'Volume Silinder', 'value' => $groupSpec->volume_silinder],
                    ['label' => 'Diameter x Langkah', 'value' => $groupSpec->diameter_x_langkah],
                    ['label' => 'Perbandingan Kompresi', 'value' => $groupSpec->perbandingan_kompresi],
                    ['label' => 'Daya Maksimum', 'value' => $groupSpec->daya_maksimum],
                    ['label' => 'Torsi Maksimum', 'value' => $groupSpec->torsi_maksimum],
                    ['label' => 'Sistem Starter', 'value' => $groupSpec->sistem_starter],
                    ['label' => 'Sistem Pelumasan', 'value' => $groupSpec->sistem_pelumasan],
                    ['label' => 'Kapasitas Oli Mesin', 'value' => $groupSpec->kapasitas_oli],
                    ['label' => 'Sistem Bahan Bakar', 'value' => $groupSpec->sistem_bahan_bakar],
                    ['label' => 'Tipe Kopling', 'value' => $groupSpec->tipe_kopling],
                    ['label' => 'Tipe Transmisi', 'value' => $groupSpec->tipe_transmisi],
                    ['label' => 'Pola Pengoperasian Transmisi', 'value' => $groupSpec->pola_transmisi],
                ],
                'rangka' => [
                    ['label' => 'Tipe Rangka', 'value' => $groupSpec->tipe_rangka],
                    ['label' => 'Suspensi Depan', 'value' => $groupSpec->suspensi_depan],
                    ['label' => 'Suspensi Belakang', 'value' => $groupSpec->suspensi_belakang],
                    ['label' => 'Tipe Ban', 'value' => $groupSpec->tipe_ban],
                    ['label' => 'Ban Depan', 'value' => $groupSpec->ban_depan],
                    ['label' => 'Ban Belakang', 'value' => $groupSpec->ban_belakang],
                    ['label' => 'Rem Depan', 'value' => $groupSpec->rem_depan],
                    ['label' => 'Rem Belakang', 'value' => $groupSpec->rem_belakang],
                ],
                'dimensi' => [
                    ['label' => 'P x L x T', 'value' => $groupSpec->p_l_t],
                    ['label' => 'Jarak Sumbu Roda', 'value' => $groupSpec->jarak_sumbu],
                    ['label' => 'Jarak Terendah Ke Tanah', 'value' => $groupSpec->jarak_terendah_ketanah],
                    ['label' => 'Tinggi Tempat Duduk', 'value' => $groupSpec->tinggi_tempat_duduk],
                    ['label' => 'Berat Isi', 'value' => $groupSpec->berat_isi],
                    ['label' => 'Kapasitas Tangki Bensin', 'value' => $groupSpec->kapasitas_tangki],
                ],
                'kelistrikan' => [
                    ['label' => 'Sistem pengapian', 'value' => $groupSpec->sistem_pengapian],
                    ['label' => 'Battery', 'value' => $groupSpec->battery],
                    ['label' => 'Tipe Busi', 'value' => $groupSpec->tipe_busi],
                ],
            ];
        } else {
            // Jika tidak ada spesifikasi ditemukan, buat array kosong
            $specifications = [];
        }
        
        if ( $group == null ) {
            return view('errors/404');
        } else {
            $reviews = Review::where('group_id', $group->id)->get();
        }        

        $xmlObject = simplexml_load_file(public_path('features.xml'));
        $features = $xmlObject->xpath("//feature[uri='{$uri}']");

        if ($group != null) {
            $groupUri = $group->uri;

            $variantNames = Variant::where('group_id', $group->id)
                ->distinct('name')
                ->pluck('name');

            if ($variantNames->isEmpty()) {
                return view('errors/404');
            }

            $data = Variant::where('group_id', $group->id)
                ->where('name', $variantNames[0])
                ->get();

            return view('product/detail', compact('group', 'groupUri', 'variantNames', 'data', 'cookieSales', 'features', 'reviews', 'specifications'));
        } else {
            return view('errors/404');
        }
    }

    public function getData(Request $request, $variant)
    {
        $variantUnits = Variant::where('name', $variant)->get();

        return response()->json($variantUnits);
    }
}
