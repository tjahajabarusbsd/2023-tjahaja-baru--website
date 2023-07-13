<?php

namespace App\Import;

use App\Models\Dealer;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportDealer implements ToModel
{
    public function model(array $row)
    {
        return new Dealer([
            'kode_sales'    => $row[0],
            'name_dealer'   => $row[1],
            'kecamatan'     => $row[2],
            'kota'          => $row[3],
            'address'       => $row[4],
            'nohp'          => $row[5],
            'latitude'      => $row[6],
            'longitude'     => $row[7],
            // Map the remaining columns here
        ]);
    }
}
