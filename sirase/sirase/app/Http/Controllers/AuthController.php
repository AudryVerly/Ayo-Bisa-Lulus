<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function ShowLogin(){
        return view('auth.login');
    }

    public function Login(Request $request){
        $request ->validate([
            'email'=>'required|email',
            'password'=>'required|min:8'
        ]);

        $cek = $request->only('email','password');

        if(Auth::attempt($cek)){
            $role = Auth::user()->role;

            if($role == 'SuperAdmin'){
                return redirect()->route('superadmin.dashboard');
            }elseif($role == 'AdminUnit'){
                    return redirect()->route('adminunit.dashboard');
            }elseif($role == 'Mahasiswa'){
                    return redirect()->route('mahasiswa.dashboard');
            }elseif($role == 'StaffUnit'){
                    return redirect()->route('staff.dashboard');
            }

            //kalau role tidak diketahui 
            Auth::logout();
            abort(403, 'Role Undefined');
        }
        return redirect()->route('login')->with('error','Email atau Password salah');
    }

    public function Logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil Logout.');
    }
}
