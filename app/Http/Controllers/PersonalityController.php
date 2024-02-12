<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\PersonalityQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PersonalityController extends Controller
{
    public function submitQuiz(Request $request)
    {   
        $finalResult = $request->result;

        if ($finalResult) {
            PersonalityQuiz::create(['result' => $finalResult]);
        }

        $featuresArray = Cache::remember('personality_features_' . $finalResult, 60, function () use ($finalResult) {
            $xmlObject = simplexml_load_file(public_path('personality.xml'));
            $features = $xmlObject->xpath("//result[motor='{$finalResult}']");
            return json_decode(json_encode($features), true);
        });        

        $category = Category::where('uri', $finalResult)->firstOrFail();
        $groups = $category->groups; // Eager loading

        $html = view('quizResult', compact('groups'))->render();

        return response()->json([
            'message' => 'Data berhasil diterima di controller.',
            'features' => $featuresArray,
            'html' => $html,
        ]);
    }
}
