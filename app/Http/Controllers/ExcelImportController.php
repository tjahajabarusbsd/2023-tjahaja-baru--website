<?php

namespace App\Http\Controllers;

use App\Import\ImportDealer;
use Illuminate\Http\Request;
use App\Import\XlsImport;
use App\Import\SpecImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx|max:2048', // Sesuaikan dengan format file yang diizinkan dan batasan ukuran
        ]);
        
        try {
            $file = $request->file('file');
            $nama_file = rand() . $file->getClientOriginalName();
    
            $file->move('file_staff', $nama_file);
    
            Excel::import(new XlsImport, public_path('/file_staff/' . $nama_file));
    
            return redirect()->back()->with('success', 'Excel file imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import Excel file. ' . $e->getMessage());
        }
    }

    public function importDealer(Request $request)
    {
        $file = $request->file('file');

        $nama_file = rand() . $file->getClientOriginalName();

        $file->move('file_staff', $nama_file);

        Excel::import(new ImportDealer, public_path('/file_staff/' . $nama_file));

        return redirect()->back()->with('success', 'Excel file imported successfully.');
    }

    public function importSpec(Request $request)
    {
        $file = $request->file('file');

        $nama_file = rand() . $file->getClientOriginalName();

        $file->move('file_spec', $nama_file);

        Excel::import(new SpecImport, public_path('/file_spec/' . $nama_file));

        return redirect()->back()->with('success', 'Excel file imported successfully.');
    }
}
