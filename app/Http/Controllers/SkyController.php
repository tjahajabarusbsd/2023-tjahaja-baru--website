<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SkySubmissionRequest;
use App\Models\SkySubmission; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class SkyController extends Controller
{
    private $apiUrl;
    private $apiToken;

    public function __construct()
    {
        $this->apiUrl = 'https://api.1msg.io/434886/sendMessage';
        $this->apiToken = env('TOKEN_WA');
    }

    public function store(SkySubmissionRequest $request)
    {
        $recaptchaResponse = RecaptchaV3::verify($request->input('g-recaptcha-response'), 'send_sky');
        
        if ($recaptchaResponse >= 0.7) {
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

        return response()->json(['errorMessage' => 'You are most likely a bot'], 422);
    }
}
