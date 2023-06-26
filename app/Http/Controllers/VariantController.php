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

        $variantNames = Variant::where('group_id', $group->id)
            ->distinct('name')
            ->pluck('name');

        $data = Variant::where('group_id', $group->id)
            ->orderBy('updated_at', 'ASC')
            ->get();

        return view('product/detail', compact('group', 'data', 'variantNames'));
    }
}
