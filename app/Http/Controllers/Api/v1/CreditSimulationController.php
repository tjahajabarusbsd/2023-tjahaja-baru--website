<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CreditTenor;
use App\Models\Group;
use App\Models\Variant;
use App\Services\CreditSimulationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreditSimulationController extends Controller
{
  public function __construct(private CreditSimulationService $service) {}

  /**
   * GET /api/v1/credit-simulation/categories
   */
  public function categories(): JsonResponse
  {
    $categories = Category::orderBy('name')->get(['id', 'name']);

    return $this->ok($categories);
  }

  /**
   * GET /api/v1/credit-simulation/categories/{id}/groups
   * Kategori -> daftar tipe motor (tabel groups)
   */
  public function groups(int $id): JsonResponse
  {
    $category = Category::find($id);

    if (!$category) {
      return $this->fail('Kategori tidak ditemukan.', 404);
    }

    $groups = $category->groups()
      ->where('is_active', true)
      ->orderBy('name')
      ->get(['id', 'name']);

    return $this->ok($groups);
  }

  /**
   * GET /api/v1/credit-simulation/groups/{id}/variants
   * Tipe motor -> daftar variant beserta OTR
   */
  public function variantsByGroup(int $id): JsonResponse
  {
    $group = Group::find($id);

    if (!$group) {
      return $this->fail('Tipe motor tidak ditemukan.', 404);
    }

    $variants = $group->variants()
      ->where('is_active', true)
      ->orderBy('name')
      ->get(['id', 'name', 'color_name', 'price'])
      ->map(fn(Variant $v) => $this->formatVariant($v))
      ->filter(fn(array $v) => $v['otr_price'] > 0)
      ->values();

    return $this->ok($variants);
  }

  /**
   * GET /api/v1/credit-simulation/variants/{id}
   * Satu variant (untuk tombol simulasi dari halaman detail produk)
   */
  public function variantDetail(int $id): JsonResponse
  {
    $variant = Variant::with('group:id,name')
      ->where('is_active', true)
      ->find($id);

    if (!$variant) {
      return $this->fail('Variant tidak ditemukan.', 404);
    }

    $data = $this->formatVariant($variant);

    if ($data['otr_price'] <= 0) {
      return $this->fail('Harga motor belum tersedia.', 422);
    }

    $data['group'] = $variant->group
      ? ['id' => $variant->group->id, 'name' => $variant->group->name]
      : null;

    return $this->ok($data);
  }

  /**
   * GET /api/v1/credit-simulation/tenors
   */
  public function tenors(): JsonResponse
  {
    $tenors = CreditTenor::where('is_active', true)
      ->orderBy('months')
      ->get(['id', 'months'])
      ->map(fn(CreditTenor $t) => [
        'id' => $t->id,
        'months' => $t->months,
        'label' => $t->months . ' Bulan',
      ]);

    return $this->ok($tenors);
  }

  /**
   * POST /api/v1/credit-simulation/calculate
   * body: { "variant_id": 1, "tenor_id": 2, "dp": 10000000 }
   */
  public function calculate(Request $request): JsonResponse
  {
    $validator = Validator::make($request->all(), [
      'variant_id' => ['required', 'integer'],
      'tenor_id' => ['required', 'integer'],
      'dp' => ['required', 'integer', 'min:0'],
    ]);

    if ($validator->fails()) {
      return $this->fail('Data tidak valid.', 422, $validator->errors());
    }

    $data = $validator->validated();

    // OTR selalu diambil dari database, bukan dari input user
    $variant = Variant::where('is_active', true)->find($data['variant_id']);

    if (!$variant) {
      return $this->fail('Variant tidak ditemukan.', 404);
    }

    $tenor = CreditTenor::where('is_active', true)->find($data['tenor_id']);

    if (!$tenor) {
      return $this->fail('Tenor tidak ditemukan.', 404);
    }

    $otr = $this->service->parsePrice($variant->price);

    if ($otr <= 0) {
      return $this->fail('Harga motor belum tersedia.', 422);
    }

    $dp = (int) $data['dp'];
    $minDp = $this->service->minDp($otr);

    if ($dp < $minDp) {
      return $this->fail(
        'DP minimal Rp ' . number_format($minDp, 0, ',', '.'),
        422,
        ['dp' => ['DP minimal Rp ' . number_format($minDp, 0, ',', '.')]]
      );
    }

    if ($dp >= $otr) {
      return $this->fail(
        'DP tidak boleh sama dengan atau lebih besar dari harga OTR.',
        422,
        ['dp' => ['DP tidak boleh sama dengan atau lebih besar dari harga OTR.']]
      );
    }

    $result = $this->service->calculate($otr, $dp, $tenor);

    // Hanya data yang perlu ditampilkan ke customer
    return $this->ok([
      'variant_id' => $variant->id,
      'variant_name' => $variant->color_name
        ? $variant->name . ' - ' . $variant->color_name
        : $variant->name,
      'otr' => $result['otr'],
      'dp' => $result['dp'],
      'dp_percent' => $result['dp_percent'],
      'months' => $result['months'],
      'installment' => $result['installment'],
      'is_estimate' => true,
      'disclaimer' => 'Hasil simulasi hanya perkiraan. Angka final mengikuti perhitungan resmi dari leasing saat pengajuan.',
    ]);
  }

  private function formatVariant(Variant $v): array
  {
    $otr = $this->service->parsePrice($v->price);

    return [
      'id' => $v->id,
      'name' => $v->name,
      'color_name' => $v->color_name,
      'label' => $v->color_name ? $v->name . ' - ' . $v->color_name : $v->name,
      'otr_price' => $otr,
      'min_dp' => $this->service->minDp($otr),
    ];
  }

  private function ok($data, string $message = 'Success'): JsonResponse
  {
    return response()->json([
      'success' => true,
      'message' => $message,
      'data' => $data,
    ]);
  }

  private function fail(string $message, int $status = 422, $errors = null): JsonResponse
  {
    $body = [
      'success' => false,
      'message' => $message,
    ];

    if ($errors !== null) {
      $body['errors'] = $errors;
    }

    return response()->json($body, $status);
  }
}
