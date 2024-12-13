<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetSalesCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah parameter "sales" ada di query string
        $salesCodeParameter = $request->query('sales');

        // Jika ada, buat cookie dengan nama "sales"
        if ($salesCodeParameter) {
            Cookie::queue('sales', $salesCodeParameter, 1440);
        }
        
        return $next($request);
    }
}
