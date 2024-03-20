<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\NomorRangka;
use App\Models\MasterPart;

class UserProfileController extends Controller
{
    public function getUserProfile()
    {   
        $user = Auth::user(); // Retrieve the authenticated user

        if ($user) {
            $getnomor = NomorRangka::where('user_id', $user->id)->first();

            if ($getnomor) {
                $nomor_rangka = $getnomor->nomor_rangka;
                $url_services = env('GET_URL_SERIVCES');
                $apiUrl = $url_services . "?id=" . $nomor_rangka;
                
                $response = Http::get($apiUrl);

                $data = $response->json();

                // Assuming $data is an array of arrays, and each inner array contains a 'part_id' key
                foreach ($data as &$innerArray) {
                    // Check if 'part_id' key exists in the inner array
                    if (isset($innerArray['part_id'])) {
                        // Extract part_ids from the 'part_id' key and decode JSON
                        $partIds = json_decode($innerArray['part_id'], true);

                        // Fetch part_names from the MasterPart model
                        $partNames = [];
                        foreach ($partIds as $partId) {
                            $part = MasterPart::where('part_number', $partId)->first();
                            if ($part) {
                                $partNames[] = $part->part_name;
                            }
                        }

                        // Convert part_names array to JSON string
                        // $partNamesJson = json_encode($partNames);

                        // Assign part_names array to the inner array
                        // $innerArray['part_name'] = $partNamesJson;

                        // Assign part_names array to the inner array
                        $innerArray['part_name'] = $partNames;
                    } else {
                        // If 'part_id' key does not exist, set an empty array for 'part_name'
                        $innerArray['part_name'] = [];
                    }
                }

                // dd($data);

                return view('users.details', compact('data', 'user'));
            } else {
                $message = 'Data Riwayat Servis tidak ditemukan.';
                return view('users.details', compact('user', 'message'));
            }
        } else {
            $message = 'User tidak ditemukan. Silakan login.';
            return view('users.details', compact('message'));
        }
    }
    
    public function saveNoRangka(Request $request)
    {
        $request->validate([
            'nomor_rangka' => 'required|unique:nomor_rangkas,nomor_rangka',
        ]);

        $user = Auth::user();

        if ($user) {
            // Check if the user already has a nomor_rangka entry
            $existingNomorRangka = NomorRangka::where('user_id', $user->id)->first();
    
            if ($existingNomorRangka) {
                $message = 'Nomor Rangka already exists for this user.';
                return redirect()->route('user.profile')->with('message', $message);
            }
    
            // Save the nomor_rangka for the user
            NomorRangka::create([
                'user_id' => $user->id,
                'nomor_rangka' => $request->input('nomor_rangka'),
            ]);
    
            $message = 'Nomor Rangka saved successfully.';
            return redirect()->route('user.profile')->with('message', $message);
        } else {
            $message = 'User not found. Please login.';
            return redirect()->route('user.profile')->with('message', $message);
        }
    }
}
