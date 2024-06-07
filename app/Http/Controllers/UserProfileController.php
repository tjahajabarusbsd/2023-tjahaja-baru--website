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
    protected function getRiwayatServis($nomorRangka)
    {
        $url_services = env('GET_URL_SERIVCES');
        $apiUrl = $url_services . "?id=" . $nomorRangka;
        $response = Http::withoutVerifying()->get($apiUrl);
        $data = $response->json();
        
        if (!$data) {
            throw new \Exception('Riwayat servis tidak ditemukan.');
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

    public function getUserProfile(Request $request, $nomorRangka = null)
    {
        $user = Auth::user();
        $getAllNomorRangka = NomorRangka::where('user_id', $user->id)->get();
        $specList = Spec::orderBy('name')->distinct('name')->get();

        try {
            if ($nomorRangka !== null) {
                $data = $this->getRiwayatServis($nomorRangka);
                
                return view('users.details', compact('data', 'user', 'nomorRangka', 'getAllNomorRangka', 'specList'));
            } else {
                $nomorRangka = NomorRangka::where('user_id', $user->id)->first();
                $nomorRangka = $nomorRangka->nomor_rangka;
                if ($nomorRangka) {
                    $data = $this->getRiwayatServis($nomorRangka);
                    
                    return view('users.details', compact('data', 'user', 'nomorRangka', 'getAllNomorRangka', 'specList'));
                } else {
                    throw new \Exception('Nomor rangka tidak ditemukan.');
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $message = 'Mohon maaf, data riwayat servis tidak ditemukan';
            return view('users.details', compact('user', 'nomorRangka', 'getAllNomorRangka', 'specList', 'message'));
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

    public function cetakPdf($nomorRangka)
    {
        $user = Auth::user();

        try {
            $data = $this->getRiwayatServis($nomorRangka);

            $pdf = PDF::loadview('users/riwayat-servis-view',['riwayat'=>$data]);
            return $pdf->stream('laporan-riwayat-servis.pdf');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            return view('users.details', compact('user', 'nomorRangka'));
        }
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
