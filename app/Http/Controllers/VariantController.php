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

            return view('product/detail', compact('group', 'groupUri', 'variantNames', 'data', 'cookieSales', 'features', 'reviews', 'groupSpec'));
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
