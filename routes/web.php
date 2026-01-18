<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriSarprasController;
use App\Http\Controllers\SarprasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login',[AuthController::class,'login']);
Route::post('/login',[AuthController::class,'prosesLogin']);
Route::get('/logout',[AuthController::class,'logout']);

// Admin
Route::middleware(['login','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriSarprasController::class);
    Route::resource('sarpras',SarprasController::class);
});

// Petugas
Route::middleware(['login','petugas'])->get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
});

// Pengguna
Route::middleware(['login','pengguna'])->get('/pengguna/dashboard', function () {
    return view('pengguna.dashboard');
});
