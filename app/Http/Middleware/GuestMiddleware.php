<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // guest middleware ini untuk mengecek apakah role yang masuk ini sesuai apa enggak dengan yang ada di database
    // lalu untuk menghalagi yang sudah login untuk kembali ke login kecuali udah logout
    public function handle(Request $request, Closure $next): Response
    {
       if(!Auth::Check()){
        //retrn ini akan di jalankan sesuai nanti di routing apa yang dibuat terlebih dahulu
        //ini kalau usernya belum login atau statusnya masih guest
        return $next($request);
       } 

       $role = Auth::user()->role;
       
       //Ini kalau udah login bakal diarahin sesuai rolenya nanti
       if($role == 'SuperAdmin'){
            return redirect()->route('superadmin.dashboard');
       }elseif($role == 'AdminUnit'){
            return redirect()->route('adminunit.dashboard');
       }elseif($role == 'Mahasiswa'){
            return redirect()->route('mahasiswa.dashboard');
       }elseif($role == 'StaffUnit'){
            return redirect()->route('staff.dashboard');
       }else{
          abort(403,'Unthorized');
       }

    }
}
