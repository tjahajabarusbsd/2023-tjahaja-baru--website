<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SkySubmissionRequest;
use App\Models\SkySubmission; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;

class SkyController extends Controller
{
    public function store(SkySubmissionRequest $request)
    {
        $validatedData = $request->validated();

        $user = Auth::user();
        
        $submission = SkySubmission::create([
            'name' => $validatedData['sky_name'],
            'nohp' => $validatedData['sky_phone_number'],
            'alamat' => $validatedData['sky_alamat'],
            'tipe' => $validatedData['sky_tipe'],
            'kendala' => $validatedData['sky_kendala'],
            'user_id' => $user->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been successfully saved',
            'data' => $submission
        ], 201);
    }
}
