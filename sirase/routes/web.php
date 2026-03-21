<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\KandidatPendaftaran;
use App\Http\Controllers\KandidatPendaftaranController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\pendaftaranController;
use App\Http\Controllers\StaffUnitController;
use App\Http\Controllers\TahapRekrutmenController;
use App\Http\Controllers\TimPenilaiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WawancaraController;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\StaffUnit;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Phiki\Phast\Root;
use App\Mail\MyTestEmail;

// Route::get('/', function () {
//     return view('dashboard'); 
// })->name('dashboard')->middleware('role:SuperAdmin');

Route::middleware('guest')->group(function(){
    Route::get('/',[AuthController::class,'ShowLogin'])->name('login');
    Route::post('/login',[AuthController::class,'Login'])->name('login.process');
});

Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
Route::get('/autoupdate',[LowonganController::class, 'autoUpdate'])->name('lowongan.autoupdate');
Route::get('/testroute', function(){
    $name="Audry Cantik";

    Mail::to('audry.verly@gmail.com')->send(new MyTestEmail($name));
});
Route::get('/interview/confirm/{$idPivot}/{aksi}',[WawancaraController::class, 'confirmJadwal'])->name('interview.confirm');


// Route::get('/dashboard', function () {return view('dashboard');})->name('superadmin.dashboard')->middleware('role:SuperAdmin');

Route::middleware(['auth','role:Mahasiswa'])->group(function(){
    Route::get('/dashboardMahasiswa', [DashboardMahasiswaController::class,'index'])->name('mahasiswa.dashboard');
    Route::get('/detailLowongan/{id}/lowongan',[DashboardMahasiswaController::class, 'detailLowongan'])->name('mahasiswa.detail');
    Route::get('/pendaftaran/{idLowongan}/studentemployee',[PendaftaranController::class,'formulirPendaftaran'])->name('pendaftaran.formulir');
    Route::post('/pendaftaran/{idLowongan}/formulir',[PendaftaranController::class,'inputPendaftaran'])->name('pendaftaran.store');
    Route::get('/riwayatPendaftaran',[PendaftaranController::class, 'showRiwayatPendaftaran'])->name('riwayatPendaftaran.list');
    Route::get('/riwayatPendaftaran/{id}/detailPendaftaran',[PendaftaranController::class, 'showDetailPendaftaran'])->name('riwayatPendaftaran.detail');
});

Route::middleware(['auth','role:AdminUnit'])->group(function(){
   Route::get('/dashboardAdminUnit', function () {return view('adminUnitPage.dashboard');})->name('adminunit.dashboard');
   Route::get('/lowongans',[LowonganController::class,'index'])->name('lowongans.index');
   Route::get('/lowongans/{id}/edit', [LowonganController::class, 'edit'])->name('lowongans.edit');
   Route::post('/lowongans/{id}',[LowonganController::class, 'update'])->name('lowongans.update');
   Route::get('/lowongans/create',[LowonganController::class, 'create'])->name('lowongans.create');
   Route::post('/lowongans',[LowonganController::class, 'store'])->name('lowongans.store');
   Route::post('/lowongan{id}', [LowonganController::class, 'publish'])->name('lowongan.publish');
   Route::post('/lowongan/{id}', [LowonganController::class, 'unpublish'])->name('lowongan.unpublish');
   
   Route::get('/formulir', [FormulirController::class, 'index'])->name('formulir.utama');
   Route::get('/formulir/{id}/manage', [FormulirController::class, 'show'])->name('formulir.manage');
   Route::post('/formulir/add',[FormulirController::class, 'store'])->name('formulir.add');
   Route::post('/formulir/{id}/update', [FormulirController::class, 'update'])->name('formulir.update');
   Route::post('/formulir/{id}/active', [FormulirController::class, 'active'])->name('formulir.active');
   Route::post('/formulir/{id}/nonactive', [FormulirController::class, 'nonactive'])->name('formulir.nonActive');
  // Route::get('/lowongans/{id}/manage',[lowonganController::class, 'show'])->name('lowongans.show');

  Route::get('/tahapan', [TahapRekrutmenController::class, 'index'])->name('tahapan.utama');
  Route::get('/tahapan/{id}/manage', [TahapRekrutmenController::class, 'show']) ->name('tahapan.manage');
  Route::post('/tahapan/{id}/toggle', [TahapRekrutmenController::class, 'toggle'])->name('tahapan.toggle');
  Route::post('/tahapan/{id}/update', [TahapRekrutmenController::class, 'update'])->name('tahapan.update');
  Route::get('/tahapan/{id}/preview',[TahapRekrutmenController::class, 'previewlist']);
  Route::get('/tahapan/{id}/previewkiri', [TahapRekrutmenController::class, 'listTahapan']);
  Route::post('/tahapan/store',[TahapRekrutmenController::class, 'store'])->name('tahapan.tambah');

  Route::get('/penilaian', [TimPenilaiController::class, 'index'])->name('timPenilai.utama');
  Route::get('/penilaian/{id}/manage',[TimPenilaiController::class,'show'])->name('timPenilai.manage');
  Route::post('/penilaian/add',[TimPenilaiController::class, 'store'])->name('timPenilai.add');
  Route::get('/show-staff',[TimPenilaiController::class,'showStaffUnit'])->name('timPenilai.showstaff');
  Route::get('/show-staffEdit', [TimPenilaiController::class, 'showStaffUnitEdit'])->name('timPenilai.showstaffedit');
  Route::post('/penilaian/{id}/update',[TimPenilaiController::class, 'update'])->name('timPenilai.update');
  Route::post('/penilaian/{id}/toggle',[TimPenilaiController::class, 'toggle'])->name('timPenilai.toggle');

  Route::get('/kandidat', [KandidatPendaftaranController::class, 'index'])->name('kandidat.listLowongan');
  Route::get('/kandidat/{idLowongan}/ListKandidat', [KandidatPendaftaranController::class,'kandidatList'])->name('kandidat.listKandidat');
  Route::get('/kandidat/{idPendaftaran}/DetailKandidat',[KandidatPendaftaranController::class, 'showDetailKandidat'])->name('kandidat.detailKandidat');
  Route::post('/kandidat/{idPendaftaran}',[KandidatPendaftaranController::class, 'updateStatusDaftar'])->name('kandidat.proses');
  Route::post('/kandidat/lulus/{idPendaftaran}',[KandidatPendaftaranController::class,'lulusTahapan'])->name('kandidat.lulus');
  Route::post('/kandidat/gagal/{idPendaftaran}',[KandidatPendaftaranController::class,'gagalTahapan'])->name('kandidat.gagal');
  
  Route::get('/kandidat/Wawancara',[WawancaraController::class,'index'])->name('kandidat.wawancara');
  Route::post('/simpanWawancara',[WawancaraController::class,'storeData'])->name('kandidat.addWawancara');
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
