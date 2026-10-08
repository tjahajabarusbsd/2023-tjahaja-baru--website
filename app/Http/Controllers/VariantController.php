<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Review;
use App\Models\GroupProductSpec;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VariantController extends Controller
{
    public function getDataVariant(string $uri, Request $request)
    {

        $group = Cache::remember(
            "group_uri_$uri",
            300,
            fn() =>
            Group::where('uri', $uri)->where('is_active', 1)->first()
        );
        abort_if(! $group, 404);

        $variantsByName = Variant::where('group_id', $group->id)
            ->where('is_active', true)
            ->get()
            ->groupBy('name');
        abort_if($variantsByName->isEmpty(), 404);

        $variantNames = $variantsByName->keys();

        $isNmaxTurbo = str_contains($group->uri, 'nmax-turbo');
        $variantLabels = $variantNames->mapWithKeys(fn($name) => [
            $name => $isNmaxTurbo ? (explode(' ', $name, 2)[1] ?? '') : $name,
        ]);

        $data = $variantsByName->first();

        $groupSpec = GroupProductSpec::where('group_id', $group->id)->first();
        $specifications = $groupSpec
            ? collect(config('product_specs'))->map(
                fn($fields) =>
                collect($fields)->map(fn($label, $column) => [
                    'label' => $label,
                    'value' => $groupSpec->{$column},
                ])->values()->all()
            )->all()
            : [];

        $reviews = Review::where('group_id', $group->id)->get();

        $xmlObject = simplexml_load_file(public_path('features.xml'));
        $features = $xmlObject->xpath("//feature[uri='{$uri}']");

        $cookieSales = $request->cookie('sales');

        return view('product/detail', compact(
            'group',
            'variantNames',
            'variantLabels',
            'variantsByName',
            'data',
            'cookieSales',
            'features',
            'reviews',
            'specifications'
        ));
    }

    public function getData(Request $request, $variant)
    {
        $variantUnits = Variant::where('name', $variant)->where('is_active', true)->get();

        return response()->json($variantUnits);
    }
}
