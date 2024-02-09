<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Category;
use App\Models\PersonalityQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PersonalityController extends Controller
{
    public function submitQuiz(Request $request)
    {   
        // dd($request->result);
        $finalResult = $request->result;
        
        if($finalResult != ""){
            $data = new PersonalityQuiz();
            $data->result = $finalResult;
            $data->save();
        }
        
        // Proses data yang diterima dari permintaan AJAX
        $xmlObject = simplexml_load_file(public_path('personality.xml'));
        $features = $xmlObject->xpath("//result[motor='{$finalResult}']");

       // Mengonversi objek SimpleXMLElement ke array
        $featuresArray = json_decode(json_encode($features), true);

        $category = Category::where('uri', $finalResult)->first();

        if ( $category == null ) {
            return view('errors/404');
        } else {
            $groups = Group::where('category_id', $category->id)->get();
        }

        if (isset($groups)) {
            // Render the Blade view with the necessary data
            $html = View::make('quizResult', compact('groups'))->render();
        } else {
            $html = ''; // Or handle the case where $groups is not set
        }

        // Menyusun respons yang ingin dikirim kembali ke klien
        $response = [
            'message' => 'Data berhasil diterima di controller.',
            'features' => $featuresArray,
            'html' => $html,
        ];

        // Mengirim respons dalam format JSON
        return response()->json($response);
    }
}
