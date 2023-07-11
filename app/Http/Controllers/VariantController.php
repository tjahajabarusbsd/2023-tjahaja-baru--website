<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Variant;

class VariantController extends Controller
{
    public function getDataVariant($uri)
    {
        $group = Group::where('uri', $uri)->first();

        if ($group != null) {
            $groupUri = $group->uri;

            $variantNames = Variant::where('group_id', $group->id)
                ->distinct('name')
                ->pluck('name');

            $data = Variant::where('group_id', $group->id)
                ->orderBy('updated_at', 'ASC')
                ->get();

            return view('product/detail', compact('group', 'groupUri', 'variantNames', 'data'));
        } else {
            return view('errors/404');
        }
    }

    public function getGroup($uri, $name)
    {
        $group = Group::where('uri', $uri)->first();

        $groupUri = $group->uri;

        $variantNames = Variant::where('group_id', $group->id)
            ->distinct('name')
            ->pluck('name');

        $variantUnits = Variant::where('group_id', $group->id)->where('name', $name)->get();

        return view('product/detail2', compact('group', 'groupUri', 'variantNames', 'variantUnits'));
    }

    public function getRandomProduct()
    {
        $products = Group::inRandomOrder()->limit(3)->get();

        return view('dealers', compact('products'));
    }
}
