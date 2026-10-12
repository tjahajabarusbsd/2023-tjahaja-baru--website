<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FeatureStatus;

class FeatureStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeatureStatus::firstOrCreate(
            ['key' => 'qr_scan'],
            [
                'label' => 'Scan QR Code',
                'is_active' => true,
            ]
        );
    }
}
