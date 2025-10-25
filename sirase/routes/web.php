<?php

use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard'); 
});

Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');

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