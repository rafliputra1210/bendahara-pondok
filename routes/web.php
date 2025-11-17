<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RiwayatController;

Route::get('/', [PembayaranController::class, 'dashboard'])->name('dashboard');

Route::resource('pembayaran', PembayaranController::class)->except(['show']);


// (opsional) CRUD Transaksi jika kamu pakai juga
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/transaksi/tambah', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

// Dashboard
Route::get('/', [PembayaranController::class, 'dashboard'])->name('dashboard');

// CRUD Pembayaran
Route::resource('pembayaran', PembayaranController::class);

// CRUD Transaksi (index, create, store, edit, update, destroy)
Route::resource('transaksi', TransaksiController::class)
    ->names('transaksi'); // transaksi.index, transaksi.destroy, dst

Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

Route::get('/riwayat',                [RiwayatController::class,'index'])->name('riwayat.index');
Route::get('/riwayat/print',          [RiwayatController::class,'print'])->name('riwayat.print');
Route::get('/riwayat/export/excel',   [RiwayatController::class,'exportExcel'])->name('riwayat.export.excel');
Route::get('/riwayat/export/pdf',     [RiwayatController::class,'exportPdf'])->name('riwayat.export.pdf');