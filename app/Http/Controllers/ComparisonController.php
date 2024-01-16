<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spec;
use App\Models\Group;

class ComparisonController extends Controller
{
    public function specComparison(Request $request)
    {
        $specList = Spec::all()->unique('name')->sortBy('name');

        $products = Group::inRandomOrder()->limit(3)->get();

        return view('compare', compact('specList', 'products'));
    }

    public function getSpecDetails($id)
    {
        $spec = Spec::find($id);
        return response()->json($spec);
    }
}
