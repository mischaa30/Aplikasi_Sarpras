<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriSarprasController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\SarprasItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AdminApproveController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login',[AuthController::class,'login']);
Route::post('/login',[AuthController::class,'prosesLogin']);
Route::get('/logout',[AuthController::class,'logout']);

//Profil
Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');


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

    //Sarpras Item
    Route::get('sarpras/{sarpras}/item/create', [SarprasItemController::class, 'create'])
        ->name('sarpras.item.create');

    Route::post('sarpras/{sarpras}/item', [SarprasItemController::class, 'store'])
        ->name('sarpras.item.store');

    Route::get('sarpras/item/{item}/edit', [SarprasItemController::class, 'edit'])
        ->name('sarpras.item.edit');

    Route::put('sarpras/item/{item}', [SarprasItemController::class, 'update'])
        ->name('sarpras.item.update');

    Route::delete('sarpras/item/{item}', [SarprasItemController::class, 'destroy'])
        ->name('sarpras.item.destroy');

    //Approve Admin
    Route::get('peminjaman', [AdminApproveController::class, 'index'])->name('peminjaman.index');
    Route::post('peminjaman/{id}/setujui', [AdminApproveController::class, 'setujui'])->name('peminjaman.setujui');
    Route::post('peminjaman/{id}/tolak', [AdminApproveController::class, 'tolak'])->name('peminjaman.tolak');

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
Route::middleware(['login', 'pengguna'])
    ->prefix('pengguna')
    ->name('pengguna.')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('pengguna.dashboard');
    })->name('dashboard');

    // 1. daftar kategori
    Route::get('/kategori', 
        [KategoriSarprasController::class, 'userIndex']
    )->name('kategori.index');

    // 2. isi kategori → sarpras
    Route::get('/kategori/{kategori}', 
        [KategoriSarprasController::class, 'userShow']
    )->name('kategori.show');

    // 3. detail sarpras → item
    Route::get('/sarpras/{sarpras}',
        [SarprasController::class, 'showUser']
    )->name('sarpras.show');

    // 4. form pinjam item
    Route::get('/peminjaman/{item}/create',
        [PeminjamanController::class, 'create']
    )->name('peminjaman.create');

    // 5. simpan peminjaman
    Route::post('/peminjaman/{item}',
        [PeminjamanController::class, 'store']
    )->name('peminjaman.store');

    // 6. pinjaman saya
    Route::get('/peminjaman',
        [PeminjamanController::class, 'index']
    )->name('peminjaman.index');
});
