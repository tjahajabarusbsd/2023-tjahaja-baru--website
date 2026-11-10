<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class RedirectController extends Controller
{
    /*
     * Hanya untuk link lama /consultation (bookmark atau link sales versi lama).
     * Link sales yang aktif sekarang memakai /?sales=KODE di home, bukan lewat sini.
     *
     * Kode sales dari ?sales=KODE tetap disimpan ke cookie 'sales' supaya link lama
     * yang masih beredar tetap tercatat atas nama sales-nya. Tanpa parameter sales,
     * cookie yang sudah ada dibiarkan (perilaku sebelumnya).
     */
    public function redirectToContact(Request $request): RedirectResponse
    {
        $sales = $request->query('sales');
        $hasSales = is_string($sales) && $sales !== '';

        if ($hasSales) {
            Cookie::queue('sales', $sales);
        }

        return redirect()->route('contact.get', $hasSales ? ['sales' => $sales] : []);
    }
}
