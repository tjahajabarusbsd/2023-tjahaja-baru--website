<?php

namespace App\Import;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;

class XlsImport implements ToModel
{
    public function model(array $row)
    {
        return new Staff([
            'code'     => $row[0],
            'name'     => $row[1],
            'division' => $row[2],
            'phone'    => $row[3],
            // Map the remaining columns here
        ]);
    }
}
