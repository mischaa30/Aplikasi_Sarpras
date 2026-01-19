<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriSarprasController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\SarprasKondisiController;
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
    Route::resource('sarpras', SarprasController::class);

    // Restore user
    Route::get('user/{id}/restore', [UserController::class, 'restore'])
        ->name('user.restore');

    // Restore sarpras
    Route::get('sarpras/{id}/restore', [SarprasController::class, 'restore'])
        ->name('sarpras.restore');

    // Tambah stok sarpras
    Route::get(
        'sarpras/{sarpras}/kondisi/create',
        [SarprasKondisiController::class, 'create']
    )->name('sarpras.kondisi.create');

    Route::post(
        'sarpras/{sarpras}/kondisi',
        [SarprasKondisiController::class, 'store']
    )->name('sarpras.kondisi.store');

});

// Petugas
Route::middleware(['login','petugas'])->get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
});

// Pengguna
Route::middleware(['login','pengguna'])->get('/pengguna/dashboard', function () {
    return view('pengguna.dashboard');
});
