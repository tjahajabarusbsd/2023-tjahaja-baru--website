<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spec;
use App\Models\Group;

class ComparisonController extends Controller
{
    public function specComparison(Request $request)
    {
        $specList = Spec::orderBy('name')->distinct('name')->get();
        $products = Group::inRandomOrder()->limit(3)->get();

        return view('compare', compact('specList', 'products'));
    }

    public function getSpecDetails($id)
    {
        $spec = Spec::find($id);

        return $spec
            ? response()->json($spec)
            : response()->json(['error' => 'Spec not found'], 404);
    }
}
