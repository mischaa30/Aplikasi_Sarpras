<?php

use App\Http\Controllers\ActivityLogController;
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
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\LaporanAssetHealthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login',[AuthController::class,'login']);
Route::post('/login',[AuthController::class,'prosesLogin']);
Route::get('/logout',[AuthController::class,'logout']);

//Profil
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');
});



// Admin
Route::middleware(['auth','admin'])
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

    // Approve Admin
    Route::get('/peminjaman', [AdminApproveController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}/bukti', [AdminApproveController::class, 'bukti'])->name('peminjaman.bukti');
    Route::post('/peminjaman/{id}/setujui', [AdminApproveController::class, 'setujui'])->name('peminjaman.setujui');
    Route::post('/peminjaman/{id}/tolak', [AdminApproveController::class, 'tolak'])->name('peminjaman.tolak');

    // Form pengembalian
    Route::get('/pengembalian/{peminjaman}', [PengembalianController::class, 'create'])
        ->name('pengembalian.create');

    // Simpan pengembalian
    Route::post('/pengembalian/store', [PengembalianController::class, 'store'])
        ->name('pengembalian.store');


    // Restore user
    // routes/web.php
    Route::put('/admin/user/{id}/restore', [UserController::class, 'restore'])
        ->name('user.restore');

    // Restore sarpras
    Route::get('sarpras/{id}/restore', [SarprasController::class, 'restore'])
        ->name('sarpras.restore');

    //Restore Kategori Sarpras
    //Restore Role
    //Restore Lokasi

});

// Petugas
Route::middleware(['auth','petugas'])->get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
});

// Pengguna
Route::middleware(['auth', 'pengguna'])
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

//Pengaduan
// USER
Route::middleware(['auth', 'pengguna'])
    ->prefix('pengguna')
    ->name('pengguna.')
    ->group(function () {

        Route::get('/pengaduan', [PengaduanController::class, 'myPengaduan'])
            ->name('pengaduan.index');

        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])
            ->name('pengaduan.create');

        Route::post('/pengaduan', [PengaduanController::class, 'store'])
            ->name('pengaduan.store');
    });


// ADMIN/PETUGAS
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pengaduan', [PengaduanController::class, 'index'])->name('admin.pengaduan.index');
    Route::get('/admin/pengaduan/{id}', [PengaduanController::class, 'show'])->name('admin.pengaduan.show');
    Route::post('/admin/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('admin.pengaduan.status');
    Route::post('/admin/pengaduan/{id}/catatan', [PengaduanController::class, 'addCatatan'])->name('admin.pengaduan.catatan');
});


//ActivityLogController
Route::get(
    '/admin/activity-log/peminjaman',
    [ActivityLogController::class, 'peminjaman']
)->name('admin.activity.peminjaman');

Route::get(
    '/admin/activity-log/pengaduan',
    [ActivityLogController::class, 'pengaduan']
)->name('admin.activity.pengaduan');
Route::get(
    '/admin/activity-log/login',
    [ActivityLogController::class, 'login']
)->name('activity.login');

//Laporan Asset Health
Route::get('/admin/laporan/asset-health',
[LaporanAssetHealthController::class,'index']
)->name('admin.laporan.asset_health');

//Dashboard
Route::get('/admin/dashboard',[AdminDashboardController::class,'index'])
->middleware('auth')
->name('admin.dashboard');
