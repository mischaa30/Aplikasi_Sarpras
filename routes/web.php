<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriSarprasController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\SarprasItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AdminApproveController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LaporanAssetHealthController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| PROFIL (SEMUA ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profil', [ProfilController::class, 'edit'])
        ->name('profil.edit');

    Route::post('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    /* Dashboard */
    Route::get('/dashboard', [AdminDashboardController::class,'index'])
        ->name('dashboard');


    /* Master Data */
    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriSarprasController::class);
    Route::resource('sarpras', SarprasController::class);
    Route::resource('role', RoleController::class);
    Route::resource('lokasi', LokasiController::class);


    /* Sarpras Item */
    Route::prefix('sarpras')->name('sarpras.')->group(function () {

        Route::get('{sarpras}/item/create',
            [SarprasItemController::class,'create']
        )->name('item.create');

        Route::post('{sarpras}/item',
            [SarprasItemController::class,'store']
        )->name('item.store');

        Route::get('item/{item}/edit',
            [SarprasItemController::class,'edit']
        )->name('item.edit');

        Route::put('item/{item}',
            [SarprasItemController::class,'update']
        )->name('item.update');

        Route::delete('item/{item}',
            [SarprasItemController::class,'destroy']
        )->name('item.destroy');
    });


    /* Approve Peminjaman */
    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {

        Route::get('/',
            [AdminApproveController::class,'index']
        )->name('index');

        Route::get('{id}/bukti',
            [AdminApproveController::class,'bukti']
        )->name('bukti');

        Route::post('{id}/setujui',
            [AdminApproveController::class,'setujui']
        )->name('setujui');

        Route::post('{id}/tolak',
            [AdminApproveController::class,'tolak']
        )->name('tolak');
    });


    /* Pengembalian */
    Route::prefix('pengembalian')->name('pengembalian.')->group(function () {

        Route::get('{peminjaman}',
            [PengembalianController::class,'create']
        )->name('create');

        Route::post('/store',
            [PengembalianController::class,'store']
        )->name('store');
    });


    /* Pengaduan */
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {

        Route::get('/',
            [PengaduanController::class,'index']
        )->name('index');

        Route::get('{id}',
            [PengaduanController::class,'show']
        )->name('show');

        Route::post('{id}/status',
            [PengaduanController::class,'updateStatus']
        )->name('status');

        Route::post('{id}/catatan',
            [PengaduanController::class,'addCatatan']
        )->name('catatan');
    });


    /* Activity Log */
    Route::prefix('activity-log')->name('activity.')->group(function () {

        Route::get('/login',
            [ActivityLogController::class,'login']
        )->name('login');

        Route::get('/peminjaman',
            [ActivityLogController::class,'peminjaman']
        )->name('peminjaman');

        Route::get('/pengaduan',
            [ActivityLogController::class,'pengaduan']
        )->name('pengaduan');
    });


    /* Laporan */
    Route::prefix('laporan')->name('laporan.')->group(function () {

        Route::get('/asset-health',
            [LaporanAssetHealthController::class,'index']
        )->name('asset_health');
    });

});


/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

    Route::get('/dashboard', fn () => view('petugas.dashboard'))
        ->name('dashboard');
});


/*
|--------------------------------------------------------------------------
| PENGGUNA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','pengguna'])
    ->prefix('pengguna')
    ->name('pengguna.')
    ->group(function () {

    /* Dashboard */
    Route::get('/dashboard', fn () => view('pengguna.dashboard'))
        ->name('dashboard');


    /* Kategori & Sarpras */
    Route::get('/kategori',
        [KategoriSarprasController::class,'userIndex']
    )->name('kategori.index');

    Route::get('/kategori/{kategori}',
        [KategoriSarprasController::class,'userShow']
    )->name('kategori.show');

    Route::get('/sarpras/{sarpras}',
        [SarprasController::class,'showUser']
    )->name('sarpras.show');


    /* Peminjaman */
    Route::get('/peminjaman/{item}/create',
        [PeminjamanController::class,'create']
    )->name('peminjaman.create');

    Route::post('/peminjaman/{item}',
        [PeminjamanController::class,'store']
    )->name('peminjaman.store');

    Route::get('/peminjaman',
        [PeminjamanController::class,'index']
    )->name('peminjaman.index');


    /* Pengaduan */
    Route::get('/pengaduan',
        [PengaduanController::class,'myPengaduan']
    )->name('pengaduan.index');

    Route::get('/pengaduan/create',
        [PengaduanController::class,'create']
    )->name('pengaduan.create');

    Route::post('/pengaduan',
        [PengaduanController::class,'store']
    )->name('pengaduan.store');
});
