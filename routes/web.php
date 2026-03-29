<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\KepalaAuthController;
use App\Http\Controllers\KepalaMadrasahController;

Route::get('/', function () {
    return view('auth.landing');
})->name('landing');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::delete('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [PembayaranController::class, 'dashboard'])
        ->name('dashboard');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('siswa/import', [SiswaController::class, 'showImportForm'])->name('siswa.import.form');
    Route::post('siswa/import', [SiswaController::class, 'import'])->name('siswa.import');

    Route::resource('siswa', SiswaController::class);

    Route::get('/dashboard', [PembayaranController::class, 'dashboard'])->name('dashboard');
    Route::resource('pembayaran', PembayaranController::class)->except(['show']);
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/riwayat', [RiwayatController::class, 'index'])
    ->name('riwayat.index');
});

Route::middleware(['auth','role:kepala'])->group(function () {
    Route::get('/kepala/dashboard', [KepalaMadrasahController::class,'index'])->name('kepala.dashboard');
});
Route::get('/kepala/login', [KepalaAuthController::class, 'showLoginForm'])
    ->name('kepala.login');

Route::post('/kepala/login', [KepalaAuthController::class, 'login']);