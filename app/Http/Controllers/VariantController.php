<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Variant;

class VariantController extends Controller
{
    public function getDataVariant($uri)
    {
        // $group = Group::where('uri', $uri)->first();

        // $variantNames = Variant::where('group_id', $group->id)
        //     ->pluck('name')
        //     ->toArray();

        // $data = Variant::where('group_id', $group->id)
        //     ->whereIn('name', $variantNames)
        //     ->get();

        // ===================================

        $group = Group::where('uri', $uri)->first();

        $variantNames = Variant::where('group_id', $group->id)
            ->distinct('name')
            ->pluck('name');

        $data = Variant::where('group_id', $group->id)->get();



        // dd($names);
        // $variants = Variant::where('group_id', $group->id)
        //     ->whereIn('name', $variantNames)
        //     ->get();

        // $variants = $variants->unique('name')->pluck('name');

        // foreach ($variants as $variant) {
        //     $data = Variant::where('group_id', $group->id)
        //         ->where('name', $variant)
        //         ->get();
        // }
        // $data = Variant::where('group_id', $group->id)
        //     ->where('name', $variants)
        //     ->get();

        // dd($data);


        // $data = Variant::where('group_id', $group->id)->get();
        // dd($data->color_name);
        // return view('product/detail', [
        //     'name' => $data->name,
        //     'price' => $data->price,
        //     'color_name' => $data->color_name,
        //     'image' => $data->image,
        // ]);
        return view('product/detail', compact('group', 'data', 'variantNames'));
    }
}
