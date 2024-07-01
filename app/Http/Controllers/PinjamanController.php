<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spec;

class PinjamanController extends Controller
{
    public function hitungPinjaman(Request $request)
    {
        $hargaMotor = $request->harga_motor;
        
        $maksimalPinjaman = $hargaMotor * 0.8; 

        return response()->json(['maksimal_pinjaman' => $maksimalPinjaman]);
    }

    protected function masaAsuransi($tenor)
    {
        if ($tenor <= 12) {
            $masaAsuransi = 1;
        } elseif ($tenor >= 13 && $tenor <= 24) {
            $masaAsuransi = 2;
        } else {
            $masaAsuransi = 3;
        }

        return $masaAsuransi;
    }

    public function hitungAngsuran(Request $request)
    {
        $danaDicairkan = $request->dana_dicairkan;
        $tenor = $request->tenor;
        $insurancePeriod = $this->masaAsuransi($tenor); 

        $angsuranPerBulan = ($danaDicairkan + 450000) * (1 + (0.25 / 12 * $tenor)) / $tenor;
        $angsuranPerBulan = ceil($angsuranPerBulan / 1000) * 1000; 

        return response()->json([
            'angsuran_per_bulan' => $angsuranPerBulan,
            'masa_asuransi' => $insurancePeriod
        ]);
    }

    public function list()
    {
        $specList = Spec::orderBy('name')->distinct('name')->get();
        return view('/users/detail', compact('specList'));
    }
}
