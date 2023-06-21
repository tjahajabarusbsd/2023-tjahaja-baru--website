<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Import\XlsImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');

        $nama_file = rand() . $file->getClientOriginalName();

        $file->move('file_staff', $nama_file);

        Excel::import(new XlsImport, public_path('/file_staff/' . $nama_file));

        return redirect()->back()->with('success', 'Excel file imported successfully.');
    }
}
