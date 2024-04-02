<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\NomorRangka;
use App\Models\MasterPart;
use PDF;

class UserProfileController extends Controller
{
    
    protected function getRiwayatServis($user)
    {
        
        $getNomor = NomorRangka::where('user_id', $user->id)->first();
        
        if (!$getNomor) {
            throw new \Exception('error nomor rangka');
        }

        $nomor_rangka = $getNomor->nomor_rangka;
        $url_services = env('GET_URL_SERIVCES');
        $apiUrl = $url_services . "?id=" . $nomor_rangka;
        $response = Http::get($apiUrl);
        
        $data = $response->json();
        
        if (!$data) {
            throw new \Exception('error api');
        }

        foreach ($data as &$innerArray) {
            if (isset($innerArray['part_id'])) {
                $partIds = json_decode($innerArray['part_id'], true);

                $partNames = [];
                foreach ($partIds as $partId) {
                    $part = MasterPart::where('part_number', $partId)->first();
                    if ($part) {
                        $partNames[] = $part->part_name;
                    }
                }

                $innerArray['part_name'] = $partNames;
            } else {
                $innerArray['part_name'] = [];
            }
        }
        
        return $data;
    }

    public function getUserProfile()
    {
        $user = Auth::user();

        if(!$user){
            $message = 'User tidak ditemukan. Silakan login.';
            return view('users.details', compact('message'));
        }

        try {
            $data = $this->getRiwayatServis($user);
            return view('users.details', compact('data', 'user'));
        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            if($message == 'error nomor rangka'){
                $message = 'Data Riwayat Servis tidak ditemukan.';
                return view('users.details', compact('user', 'message'));
            } else {
                return view('users.details', compact('user'));
            }
        }
        
    }

    public function cetakPdf()
    {
        $user = Auth::user();

        $data = $this->getRiwayatServis($user);

        $pdf = PDF::loadview('users/riwayat-servis-view',['riwayat'=>$data]);
    	return $pdf->stream('laporan-riwayat-servis.pdf');
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

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'phone_number' => ['nullable', 'numeric', 'regex:/^(\62|0)8[1-9][0-9]{6,10}$/', 'unique:users,phone_number,'.$user->id],
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'phone_number.numeric' => 'Nomor HP harus berupa karakter numerik.',
            'phone_number.regex' => 'Format nomor telepon tidak valid.',
            'phone_number.unique' => 'Nomor handphone sudah digunakan.'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Simpan perubahan pada data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->save();

        // Mengembalikan respons JSON dengan data user yang diperbarui
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
        ]);
    }
}
