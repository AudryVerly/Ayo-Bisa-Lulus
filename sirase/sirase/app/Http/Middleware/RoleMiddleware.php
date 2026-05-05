<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // ini kita pasangin yang namanya roles supaya bisa langsung paggil roles di routing
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // ini gunanya untuk mengecek apakah user sudah login atau belum
        // kalau yang belum logon coba akses halaman dashboard atau halaman lainnya, middleware akan direct ke login
       if(!Auth::check()){
            return redirect()->route('login');
       }

       // ini gunanya untuk mengambil role yang sedang login
       $userRole = Auth::user()->role;

       //untuk mengecek apakah role yang sudah login termasuk dalam daftara role
       // untuk mengakses route tertentu, misalnya kalau rolenya superadmin maka masuk ke halaman yang isisnya superadmin semua
        if(in_array($userRole, $roles,true)){
            return $next($request);

        }else{
            abort(403, 'Unauthorized');
        }
    }
}
