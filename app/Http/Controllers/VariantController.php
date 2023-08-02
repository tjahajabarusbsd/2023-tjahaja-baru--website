<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Variant;

class VariantController extends Controller
{
    public function getDataVariant($uri, Request $request)
    {
        $group = Group::where('uri', $uri)->first();
        $sales = $request->query('sales');

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

            return view('product/detail', compact('group', 'groupUri', 'variantNames', 'data', 'sales'));
        } else {
            return view('errors/404');
        }
    }

    // public function getGroup($uri, $name)
    // {
    //     $group = Group::where('uri', $uri)->first();

    //     $groupUri = $group->uri;

    //     $variantNames = Variant::where('group_id', $group->id)
    //         ->distinct('name')
    //         ->pluck('name');

    //     $variantUnits = Variant::where('group_id', $group->id)->where('name', $name)->get();

    //     return view('product/detail2', compact('group', 'groupUri', 'variantNames', 'variantUnits'));
    // }

    public function getRandomProduct()
    {
        $products = Group::inRandomOrder()->limit(3)->get();

        return view('dealers', compact('products'));
    }

    public function getData(Request $request, $variant)
    {
        $variantUnits = Variant::where('name', $variant)->get();

        return response()->json($variantUnits);
    }
}
