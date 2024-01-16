<?php

namespace App\Import;

use App\Models\Spec;
use Maatwebsite\Excel\Concerns\ToModel;

class SpecImport implements ToModel
{
    public function model(array $row)
    {
        return new Spec([
            'name'     => $row[0],
            'thumbnail'     => $row[1],
            'p_l_t' => $row[2],
            'jarak_sumbu_roda'    => $row[3],
            'ground_clearence'    => $row[4],
            'tinggi_tempat_duduk'    => $row[5],
            'berat_isi'    => $row[6],
            'volume_tangki'    => $row[7],
            'volume_bagasi'    => $row[8],
            'tipe_rangka'    => $row[9],
            'suspensi_depan'    => $row[10],
            'suspensi_belakang'    => $row[11],
            'tipe_ban'    => $row[12],
            'ban_depan'    => $row[13],
            'ban_belakang'    => $row[14],
            'rem_depan'    => $row[15],
            'rem_belakang'    => $row[16],
            'rem_abs'    => $row[17],
            'kapasitas'    => $row[18],
            'pendingin'    => $row[19],
            'd_x_l'    => $row[20],
            'rasio_kompresi'    => $row[21],
            'daya_maksimum'    => $row[22],
            'torsi_maksimum'    => $row[23],
            'sistem_starter'    => $row[24],
            'kapasitas_oli_mesin'    => $row[25],
            'sistem_bbm'    => $row[26],
            'tipe_kopling'    => $row[27],
            'tipe_transmisi'    => $row[28],
            'sistem_pengapian'    => $row[29],
            'baterai'    => $row[30],
            'busi'    => $row[31],
            'price'    => $row[32],
            // Map the remaining columns here
        ]);
    }
}
