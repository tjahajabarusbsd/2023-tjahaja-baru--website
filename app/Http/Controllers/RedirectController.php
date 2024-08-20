<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class RedirectController extends Controller
{
    public function redirectToContact(Request $request)
    {
        $sales = $request->query('sales');

        if ($sales) {
            Cookie::queue('sales', $sales); 
        } else {
            Cookie::forget('sales');
        }

        return Redirect::to('/contact' . ($sales ? '?sales=' . $sales : ''));
    }
}
