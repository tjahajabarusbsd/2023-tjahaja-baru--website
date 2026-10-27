<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Spec;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class ComparisonController extends Controller
{
    public function specComparison()
    {
        return view('compare', [
            'specList' => Spec::select('id', 'name')->orderBy('name')->get(),
            'products' => Group::inRandomOrder()->limit(3)->get(),
            'specRows' => config('compare.specs'),
        ]);
    }

    public function getSpecDetails(Spec $spec): JsonResponse
    {
        return response()->json([
            'name'      => $spec->name,
            'thumbnail' => $spec->thumbnail ? url($spec->thumbnail) : null,
            'specs'     => Arr::only($spec->toArray(), array_keys(config('compare.specs'))),
        ]);
    }
}
