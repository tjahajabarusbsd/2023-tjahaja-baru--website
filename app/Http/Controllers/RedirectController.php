<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectToContact(Request $request)
    {
        $sales = $request->query('sales');

        return redirect()->to('/contact' . ($sales ? '?sales=' . $sales : ''));
    }
}
