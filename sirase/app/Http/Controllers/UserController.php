<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Cache\Console\CacheTableCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ini supaya yang ditampilin yang aktif aja
        $user = User::orderBy('status','desc')->get();

        return view('users.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            //ini supaya ketika input masukk sesuai dengan requirenya
            $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            //'password' => 'required|min:8',
            'role' => 'required',
            'status' => 'required|boolean'
        ]);
        $plain = $request->password ?? 'password';
        //kalau di laravel kalau mau buat baru tinggal pakai ini saja
        User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($plain),
            'role' =>$request->role,
            'status' => $request->status
        ]);
        return redirect()->route('users.index')->with('success','User berhasil ditambahkan.');
        }catch(\Exception $e){
            return redirect()->route('users.index')->with('error','Gagal menambahkan User: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findorFail($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try
        {
            $user = User::findOrFail($id);
            //ini gak update status karena kita bisa destroy dia menjadi tidak aktif lagi
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'. $user->id . ',id',
                'role' => 'required',
                //'status' => 'required|boolean'
            ]);

            $user ->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                //'status' =>$request->status
            ]);

            return redirect()->route('users.index')-> with('success','Data berhasil diUpdate');
        } catch(\Exception $e){
            return redirect()->route('users.index')->with('error','Gagal mengubah data user: ' .$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findorFail($id);
        $user->update(['status' => 0]);

        return response()->json(['message' => 'User berhasil dinonaktifkan']);
    }

    // ini buat aktifin datanya lagi
    public function active(string $id)
    {
        $user = User::findorFail($id);
        $user->update(['status' => 1]);

        return response()->json(['message' => 'User berhasil diaktifkan']);
    }
}
