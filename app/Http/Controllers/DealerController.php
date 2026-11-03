<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Group;

class DealerController extends Controller
{
    public function getDealer()
    {
        $dealers = Dealer::select(
            'id',
            'kode_dealer',
            'name_dealer',
            'kecamatan',
            'kota',
            'address',
            'nohp',
            'latitude',
            'longitude'
        )
            ->orderBy('kota')
            ->orderBy('name_dealer')
            ->get();

        // Hanya dealer dengan koordinat valid yang dikirim ke peta
        $mapDealers = $dealers
            ->filter(fn($d) => is_numeric($d->latitude) && is_numeric($d->longitude))
            ->map(fn($d) => [
                'id'      => $d->id,
                'name'    => $d->name_dealer,
                'address' => $d->address,
                'phone'   => $d->nohp,
                'lat'     => (float) $d->latitude,
                'lng'     => (float) $d->longitude,
            ])
            ->values();

        $products = Group::inRandomOrder()
            ->where('is_active', true)
            ->limit(3)
            ->get();

        return view('dealers', compact('dealers', 'mapDealers', 'products'));
    }
}
