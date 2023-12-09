<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalityQuiz;

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

        // Menyusun respons yang ingin dikirim kembali ke klien
        $response = [
            'message' => 'Data berhasil diterima di controller.',
            'features' => $featuresArray,
        ];

        // Mengirim respons dalam format JSON
        return response()->json($response);
    }
}
