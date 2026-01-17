<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Login
Route::get('/login',[AuthController::class,'login']);
Route::post('/login',[AuthController::class,'prosesLogin']);
Route::get('/logout',[AuthController::class,'logout']);

// Admin
Route::middleware(['login','admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::resource('user', UserController::class);
});

// Petugas
Route::middleware(['login','petugas'])->get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
});

// Pengguna
Route::middleware(['login','pengguna'])->get('/pengguna/dashboard', function () {
    return view('pengguna.dashboard');
});