<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\SaveNoRangkaRequest ;
use App\Models\NomorRangka;
use App\Models\MasterPart;
use App\Models\Spec;
use PDF;

class UserProfileController extends Controller
{
    
    protected function getRiwayatServis($getOneNomorRangka)
    {
        if (!$getOneNomorRangka) {
            throw new \Exception('nomor rangka not found');
        }

        $nomor_rangka = $getOneNomorRangka;
        $url_services = env('GET_URL_SERIVCES');
        $apiUrl = $url_services . "?id=" . $nomor_rangka;
        $response = Http::get($apiUrl);
        $data = $response->json();
        
        if (!$data) {
            throw new \Exception('Sedang ada masalah dalam penarikan data');
        }

        foreach ($data as &$innerArray) {
            if (isset($innerArray['part_id'])) {
                $partIds = json_decode($innerArray['part_id'], true);

                $partNames = [];
                foreach ($partIds as $partId) {
                    $part = MasterPart::where('part_number', $partId)->first();
                    if ($part) {
                        $partNames[] = $part->part_name;
                    } else {
                        $partNames[] = 'UNNAME PART';
                    }
                }

                $innerArray['part_name'] = $partNames;
            } else {
                $innerArray['part_name'] = [];
            }
        }

        return $data;
    }

    protected function getOther($getOneNomorRangka)
    {
        $user = Auth::user();
        $specList = Spec::orderBy('name')->distinct('name')->get();
        $getAllNomorRangka = NomorRangka::where('user_id', $user->id)->get();
        $nomor_rangka = $getOneNomorRangka;
        $url_services = env('GET_URL_SERIVCES');
        $apiUrl = $url_services . "?id=" . $nomor_rangka;
        $response = Http::get($apiUrl);
        $data = $response->json();
        
        try {       
            
            if (!$data) {
                throw new \Exception('Sedang ada masalah dalam penarikan data2');
            }
    
            foreach ($data as &$innerArray) {
                if (isset($innerArray['part_id'])) {
                    $partIds = json_decode($innerArray['part_id'], true);
    
                    $partNames = [];
                    foreach ($partIds as $partId) {
                        $part = MasterPart::where('part_number', $partId)->first();
                        if ($part) {
                            $partNames[] = $part->part_name;
                        } else {
                            $partNames[] = 'UNNAME PART';
                        }
                    }
    
                    $innerArray['part_name'] = $partNames;
                } else {
                    $innerArray['part_name'] = [];
                }
            }
            
            return view('users.details', compact('data', 'user', 'getAllNomorRangka', 'getOneNomorRangka', 'specList'));
        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            return view('users.details', compact('user', 'getOneNomorRangka', 'getAllNomorRangka', 'specList', 'message'));
        }
    }

    public function getUserProfile()
    {
        $user = Auth::user();

        $getOneNomorRangka = NomorRangka::where('user_id', $user->id)->first();
        $getAllNomorRangka = NomorRangka::where('user_id', $user->id)->get();
        $specList = Spec::orderBy('name')->distinct('name')->get();
        
        try {
            $getOneNomorRangka = $getOneNomorRangka->nomor_rangka;
            $data = $this->getRiwayatServis($getOneNomorRangka);
            
            return view('users.details', compact('data', 'user', 'getOneNomorRangka', 'getAllNomorRangka', 'specList'));
        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            return view('users.details', compact('user', 'getOneNomorRangka', 'getAllNomorRangka', 'specList', 'message'));
        }
    }

    public function cetakPdf($getOneNomorRangka)
    {
        $user = Auth::user();

        try {
            $data = $this->getRiwayatServis($getOneNomorRangka);

            $pdf = PDF::loadview('users/riwayat-servis-view',['riwayat'=>$data]);
            return $pdf->stream('laporan-riwayat-servis.pdf');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            return view('users.details', compact('user', 'getOneNomorRangka'));
        }
    }

    public function saveNoRangka(SaveNoRangkaRequest $request)
    {
        $validatedData = $request->validated();

        $user = Auth::user();

        NomorRangka::create([
            'user_id' => $user->id,
            'nomor_rangka' => $validatedData['nomor_rangka'],
        ]);

        return redirect()->route('user.profile');
    }

    public function update(UserUpdateRequest $request)
    {
        // Get the authenticated user
        $user = $request->user();
        
        // Fill the user model with the validated data
        $user->fill($request->validated());

        // Save the changes to the database
        $user->save();

        // Get a fresh instance of the user model with the updated data
        $user = $user->fresh();

        // Return the updated user data as a JSON response
        return response()->json($user->only('name', 'email', 'phone_number'));
    }
}
