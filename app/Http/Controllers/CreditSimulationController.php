<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CreditTenor;
use App\Models\Group;
use App\Models\Variant;
use App\Services\CreditSimulationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreditSimulationController extends Controller
{
  public function __construct(private CreditSimulationService $service) {}

  public function index()
  {
    return view('credit-simulation.index', [
      'categories' => Category::orderBy('name')->get(['id', 'name']),
      'tenors' => CreditTenor::where('is_active', true)->orderBy('months')->get(['id', 'months']),
    ]);
  }

  // Kategori -> daftar tipe (tabel groups)
  public function types(Category $category): JsonResponse
  {
    return response()->json(
      $category->groups()
        ->where('is_active', true)
        ->orderBy('name')
        ->get(['id', 'name'])
    );
  }

  // Tipe (group) -> daftar variant beserta OTR
  public function variants(Group $group): JsonResponse
  {
    $variants = $group->variants()
      ->where('is_active', true)
      ->orderBy('name')
      ->get(['id', 'name', 'color_name', 'price'])
      ->map(function (Variant $v) {
        $otr = $this->service->parsePrice($v->price);

        return [
          'id' => $v->id,
          'name' => $v->color_name ? $v->name . ' - ' . $v->color_name : $v->name,
          'otr_price' => $otr,
          'min_dp' => $this->service->minDp($otr),
        ];
      })
      ->filter(fn(array $v) => $v['otr_price'] > 0)
      ->values();

    return response()->json($variants);
  }

  public function calculate(Request $request): JsonResponse
  {
    $data = $request->validate([
      'variant_id' => ['required', 'integer', 'exists:variants,id'],
      'tenor_id' => ['required', 'integer', 'exists:credit_tenors,id'],
      'dp' => ['required', 'integer', 'min:0'],
    ]);

    // OTR selalu diambil dari database, bukan dari input user
    $variant = Variant::where('is_active', true)->findOrFail($data['variant_id']);
    $tenor = CreditTenor::where('is_active', true)->findOrFail($data['tenor_id']);

    $otr = $this->service->parsePrice($variant->price);

    if ($otr <= 0) {
      return response()->json(['message' => 'Harga motor belum tersedia.'], 422);
    }

    $minDp = $this->service->minDp($otr);

    if ($data['dp'] < $minDp) {
      return response()->json([
        'message' => 'DP minimal Rp ' . number_format($minDp, 0, ',', '.'),
      ], 422);
    }

    if ($data['dp'] >= $otr) {
      return response()->json([
        'message' => 'DP tidak boleh sama dengan atau lebih besar dari harga OTR.',
      ], 422);
    }

    $result = $this->service->calculate($otr, (int) $data['dp'], $tenor);

    // Hanya data yang perlu ditampilkan ke customer
    return response()->json([
      'otr' => $result['otr'],
      'dp' => $result['dp'],
      'dp_percent' => $result['dp_percent'],
      'months' => $result['months'],
      'installment' => $result['installment'],
    ]);
  }
}
