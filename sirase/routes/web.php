<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\lowonganController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\StaffUnitController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\StaffUnit;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;
use Phiki\Phast\Root;

// Route::get('/', function () {
//     return view('dashboard'); 
// })->name('dashboard')->middleware('role:SuperAdmin');

Route::middleware('guest')->group(function(){
    Route::get('/',[AuthController::class,'ShowLogin'])->name('login');
    Route::post('/login',[AuthController::class,'Login'])->name('login.process');
});

Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
Route::get('/autoupdate',[lowonganController::class, 'autoUpdate'])->name('lowongan.autoupdate');


// Route::get('/dashboard', function () {return view('dashboard');})->name('superadmin.dashboard')->middleware('role:SuperAdmin');

Route::middleware(['auth','role:Mahasiswa'])->group(function(){
    Route::get('/dashboardMahasiswa', function () {return view('mahasiswaPage.dashboard');})->name('mahasiswa.dashboard');
});

Route::middleware(['auth','role:AdminUnit'])->group(function(){
   Route::get('/dashboardAdminUnit', function () {return view('adminUnitPage.dashboard');})->name('adminunit.dashboard');
   Route::get('/lowongans',[lowonganController::class,'index'])->name('lowongans.index');
   Route::get('/lowongans/{id}/edit', [lowonganController::class, 'edit'])->name('lowongans.edit');
   Route::post('/lowongans/{id}',[lowonganController::class, 'update'])->name('lowongans.update');
   Route::get('/lowongans/create',[lowonganController::class, 'create'])->name('lowongans.create');
   Route::post('/lowongans',[lowonganController::class, 'store'])->name('lowongans.store');
   Route::post('/lowongan{id}', [lowonganController::class, 'publish'])->name('lowongan.publish');
   Route::post('/lowongan/{id}', [lowonganController::class, 'unpublish'])->name('lowongan.unpublish');
//    Route::get('/lowongans/{id}/manage',[lowonganController::class, 'show'])->name('lowongans.show');
});

Route::middleware(['auth','role:StaffUnit'])->group(function(){
   Route::get('/dashboardStaffUnit', function () {return view('staffUnitPage.dashboard');})->name('staff.dashboard');
});

Route::middleware(['auth','role:SuperAdmin'])->group(function(){
    Route::get('/dashboard', function () {return view('dashboard');})->name('superadmin.dashboard');

    //routing master user
    Route::get('/users',[UserController::class,'index'])->name('users.index');
    Route::get('/users/create',[UserController::class,'create'])->name('users.create');
    Route::post('/users',[UserController::class,'store'])->name('users.store');
    Route::post('/users/{id}',[UserController::class,'update'])->name('users.update');
    Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('users.edit');
    Route::get('/users/{id}/show',[UserController::class, 'show'])->name('users.show');
    Route::post('users/{id}/active', [UserController::class,'active']);
    Route::post('users/{id}/destroy', [UserController::class,'destroy']);

    //routing unit
    Route::get('/units', [UnitController::class,'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units',[UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{id}/edit',[UnitController::class, 'edit'])->name('units.edit');
    Route::post('/units/{id}',[UnitController::class, 'update'])->name('units.update');
    Route::get('/units/{id}/show', [UnitController::class, 'show'])->name('units.show');
    Route::post('/units/{id}/active',[UnitController::class, 'active']);
    Route::post('/units/{id}/destroy',[UnitController::class, 'destroy']);

    //routing staffUnit
    Route::get('/staffUnits',[StaffUnitController::class, 'index'])->name('staff.index');
    Route::get('/staffUnits/create',[StaffUnitController::class, 'create'])->name('staff.create');
    Route::post('/staffUnits',[StaffUnitController::class, 'store'])->name('staff.store');
    Route::get('/staffUnits/{id}/edit',[StaffUnitController::class, 'edit'])->name('staff.edit');
    Route::post('/staffUnits/{id}',[StaffUnitController::class, 'update'])->name('staff.update');
    Route::get('/staffUnits/{id}/show', [StaffUnitController::class, 'show'])->name('staff.show');
    Route::post('/staffUnits/{id}/active',[StaffUnitController::class, 'active']);
    Route::post('/staffUnits/{id}/destroy',[StaffUnitController::class, 'destroy']);

    //routing mahasiswa
    Route::get('/mahasiswas', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/mahasiswas/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/mahasiswas', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/mahasiswas/{id}/show',[MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('/mahasiswas/{id}/edit',[MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::post('/mahasiswas/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::post('/mahasiswas/{id}/active', [MahasiswaController::class, 'active']);
    Route::post('/mahasiswas/{id}/destroy',[MahasiswaController::class, 'destroy']);
});
