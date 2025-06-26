<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Group;
use App\Models\Variant;
use App\Models\GroupProductSpec;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $defaultCategory = Category::where('name', 'like', '%maxi%')->first();

        $categories = Category::with(['groups' => function ($query) {
            $query->where('is_active', 1);
        }])->get();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Produk berhasil diambil',
            'data' => [
                'default_category' => $defaultCategory ? strtolower($defaultCategory->name) : null,
                'categories' => $categories->map(function ($category) {
                    return [
                        'id' => strtolower($category->id),
                        'category' => $category->name,
                        'products' => ProductResource::collection($category->groups)->resolve()
                    ];
                })->values()
            ]
        ]);
    }

    public function show($id, Request $request)
    {
        $group = Group::where('id', $id)->where('is_active', true)->first();

        if (!$group) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Produk tidak ditemukan',
                'data' => []
            ], 404);
        }

        $groupSpec = GroupProductSpec::where('group_id', $group->id)->first();

        // Ambil data spesifikasi
        $specifications = [];
        if ($groupSpec) {
            $specifications = [
                [
                    'title' => 'Mesin',
                    'data' => [
                        'Tipe Mesin' => $groupSpec->tipe_mesin,
                        'Jumlah/Posisi Silinder' => $groupSpec->jumlah_silinder,
                        'Volume Silinder' => $groupSpec->volume_silinder,
                        'Diameter x Langkah' => $groupSpec->diameter_x_langkah,
                        'Perbandingan Kompresi' => $groupSpec->perbandingan_kompresi,
                        'Daya Maksimum' => $groupSpec->daya_maksimum,
                        'Torsi Maksimum' => $groupSpec->torsi_maksimum,
                        'Sistem Starter' => $groupSpec->sistem_starter,
                        'Sistem Pelumasan' => $groupSpec->sistem_pelumasan,
                        'Kapasitas Oli Mesin' => $groupSpec->kapasitas_oli,
                        'Sistem Bahan Bakar' => $groupSpec->sistem_bahan_bakar,
                        'Tipe Kopling' => $groupSpec->tipe_kopling,
                        'Tipe Transmisi' => $groupSpec->tipe_transmisi,
                        'Pola Pengoperasian Transmisi' => $groupSpec->pola_transmisi,
                    ],
                ],
                [
                    'title' => 'Rangka',
                    'data' => [
                        'Tipe Rangka' => $groupSpec->tipe_rangka,
                        'Suspensi Depan' => $groupSpec->suspensi_depan,
                        'Suspensi Belakang' => $groupSpec->suspensi_belakang,
                        'Tipe Ban' => $groupSpec->tipe_ban,
                        'Ban Depan' => $groupSpec->ban_depan,
                        'Ban Belakang' => $groupSpec->ban_belakang,
                        'Rem Depan' => $groupSpec->rem_depan,
                        'Rem Belakang' => $groupSpec->rem_belakang,
                    ],
                ],
                [
                    'title' => 'Dimensi',
                    'data' => [
                        'P x L x T' => $groupSpec->p_l_t,
                        'Jarak Sumbu Roda' => $groupSpec->jarak_sumbu,
                        'Jarak Terendah Ke Tanah' => $groupSpec->jarak_terendah_ketanah,
                        'Tinggi Tempat Duduk' => $groupSpec->tinggi_tempat_duduk,
                        'Berat Isi' => $groupSpec->berat_isi,
                        'Kapasitas Tangki Bensin' => $groupSpec->kapasitas_tangki,
                    ],
                ],
                [
                    'title' => 'Kelistrikan',
                    'data' => [
                        'Sistem Pengapian' => $groupSpec->sistem_pengapian,
                        'Tipe Baterai' => $groupSpec->battery,
                        'Tipe Busi' => $groupSpec->tipe_busi,
                    ],
                ],
            ];
        }

        // Ambil fitur dari XML
        $xmlObject = simplexml_load_file(public_path('features.xml'));
        $featuresXml = $xmlObject->xpath("//feature[uri='{$group->uri}']");
        $features = collect($featuresXml)->map(function ($item) {
            return [
                'image' => (string) $item->image,
                'title' => (string) $item->title,
                'description' => (string) $item->body,
            ];
        });

        // Ambil review
        // $reviews = Review::where('group_id', $group->id)->get()->map(function ($item) {
        //     return [
        //         'rating' => (int) $item->rating,
        //         'rating_display' => number_format($item->rating, 1) . '/5.0',
        //         'title' => $item->title,
        //         'content' => $item->content,
        //         'author' => $item->author ?? 'Anonymous'
        //     ];
        // });

        // Ambil semua varian aktif untuk group ini
        $variants = Variant::where('group_id', $group->id)
        ->where('is_active', true)
        ->get();

        // Kelompokkan berdasarkan nama varian
        $groupedVariants = $variants->groupBy('name')->map(function ($items, $variantName) {
            $products = $items->map(function ($item) {
                return [
                    'variant_id' => $item->id,
                    'image' => asset($item->image),
                    'color_code' => $item->color,
                    'color_name' => $item->color_name,
                    'price' => $item->price,
                ];
            });

            return [
                'variant_name' => $variantName,
                'products' => $products
            ];
        })->values(); // buang key (biar array indexed numerik)

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Produk detail berhasil diambil',
            'data' => [
                'group_id' => $group->id,
                'group_name' => $group->name,
                'variants' => $groupedVariants,
                'features' => $features,
                'specification' => $specifications,
            ]
        ]);

        // Contoh hardcode promo / special offer
        // $specialOffers = [
        //     [
        //         'image' => 'https://duckdumber.com/bannerMotor.png',
        //         'title' => 'Gratis Service',
        //         'description' => 'Service gratis hingga 12 bulan'
        //     ]
        // ];

        // return response()->json([
        //     'status' => 'success',
        //     'code' => 200,
        //     'message' => 'Produk berhasil diambil',
        //     'data' => [
        //         [
        //             'id' => $group->id,
        //             'category' => $group->category ?? 'Kategori Default',
        //             'variant' => $variantNames[0],
        //             'produk' => $variantData,
        //             'special_offers' => $specialOffers,
        //             'features' => $features,
        //             'specification' => $specifications,
        //             // 'ulasan' => $reviews
        //         ]
        //     ]
        // ], 200);
    }
}
