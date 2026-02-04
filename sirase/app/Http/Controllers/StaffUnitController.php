<?php

namespace App\Http\Controllers;

use App\Models\StaffUnit;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class StaffUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = StaffUnit::with(['user','unit'])
            ->orderBy('status','desc')
            ->get();
        return view('staffUnits.index',compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //ini biar bisa ditampilin
        $users = User::whereIn('role',['StaffUnit','AdminUnit'])
                ->where('status',1)
                ->orderBy('name')
                ->get();
        $units=Unit::orderBy('name')->get();
        return view('staffUnits.create', compact('users','units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idUser' => [
                'required',
                'exists:users,id',
            ],
            'idUnit' => 'required|exists:unit,id',
            'jabatan' => 'required',
            'status'  => 'required|boolean',
        ]);


        // ini buat ngecek apaka user ini ada di unit apa enggak
        //karena 1 user bisa di banyak staffunit dan 1 unit bisa punya banyak staffunit
        $exist = StaffUnit::where('idUser', $request->idUser)
                                ->where('idUnit', $request->idUnit)
                                ->exists();
        // dd($exist, $request->idUser, $request->idUnit);

        if($exist){
            return redirect()->back()
                                ->withErrors(['idUser' => 'User ini sudah terdaftar di unit tersebut'])
                                ->withInput();
        }
        StaffUnit::create([
            'idUser'=>$request->idUser,
            'idUnit'=>$request->idUnit,
            'jabatan'=>$request->jabatan,
            'status'=>$request->status
        ]);
        return redirect()->route('staff.index')->with('success','Staff Unit berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $staff = StaffUnit::with(['user','unit'])
                ->findOrFail($id);
        return view('staffUnits.show',compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $staff = StaffUnit::findOrFail($id);
        $users = User::whereIn('role',['StaffUnit','AdminUnit'])
                ->where('status',1)
                ->orderBy('name')
                ->get();
        $units=Unit::orderBy('name')->get();
        return view('staffUnits.edit', compact('staff','users','units'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff = StaffUnit::findOrFail($id);
        $request->validate([
            'idUser' => 'required|exists:users,id',
            'idUnit' => 'required|exists:unit,id',
            'jabatan'=> 'required',
        ]);
            
        //ini supaya gak keinput double di unit yang sama dengan nama yang sama 
         $exist = StaffUnit::where('idUser', $request->idUser)
                            ->where('idUnit', $request->idUnit)
                            ->where('id', '!=', $id)
                            ->exists();
        if($exist){
                return redirect()->back()
                            ->withErrors(['idUser' => 'User ini sudah terdaftar di unit tersebut'])
                             ->withInput();
        }

        $staff->update([
                'idUser'=>$request->idUser,
                'idUnit'=>$request->idUnit,
                'jabatan'=>$request->jabatan,
        ]);
        return redirect()->route('staff.index')->with('success', 'Data Staff Unit berhasil diperbarui.');
    }

    /** 
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = StaffUnit::findOrFail($id);
        $staff->update(['status' => 0]);

        return response()->json(['message' => 'Staff Unit berhasil dinonaktifkan']);
    }

    public function active (string $id)
    {
        $staff = StaffUnit::findOrFail($id);
        $staff->update(['status' => 1]);

        return response()->json(['message' => 'Staff Unit berhasil diaktifkan']);
    }
}
