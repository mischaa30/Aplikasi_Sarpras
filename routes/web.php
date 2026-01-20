<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriSarprasController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\SarprasItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LokasiController;
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
    Route::resource('sarpras', SarprasController::class)
    ->parameters(['sarpras' => 'sarpras']);
    Route::resource('role',RoleController::class);
    Route::resource('lokasi',LokasiController::class);

    //Sarpras
    Route::post('sarpras/{sarpras}/item', [SarprasItemController::class, 'store'])
        ->name('sarpras.item.store');

    Route::get('sarpras/item/{item}/edit', [SarprasItemController::class, 'edit'])
        ->name('sarpras.item.edit');

    Route::put('sarpras/item/{item}', [SarprasItemController::class, 'update'])
        ->name('sarpras.item.update');

    Route::delete('sarpras/item/{item}', [SarprasItemController::class, 'destroy'])
        ->name('sarpras.item.destroy');


    // Restore user
    Route::get('user/{id}/restore', [UserController::class, 'restore'])
        ->name('user.restore');

    // Restore sarpras
    Route::get('sarpras/{id}/restore', [SarprasController::class, 'restore'])
        ->name('sarpras.restore');

    //Restore Kategori Sarpras
    //Restore Role
    //Restore Lokasi

});

// Petugas
Route::middleware(['login','petugas'])->get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
});

// Pengguna
Route::middleware(['login','pengguna'])->get('/pengguna/dashboard', function () {
    return view('pengguna.dashboard');
});
