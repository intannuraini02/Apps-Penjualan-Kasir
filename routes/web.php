<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('auth.login');
});

// Autentikasi
Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard dengan data dari controller
Route::get('/dashboard', [ProdukController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

// Proteksi semua resource routes dengan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::resource('produks', ProdukController::class);
    Route::resource('pelanggans', PelangganController::class);
    Route::resource('penjualans.detail', DetailPenjualanController::class);
});

Route::get('/penjualans', [PenjualanController::class, 'index'])->name('penjualans.index');
Route::get('/penjualans/create', [PenjualanController::class, 'create'])->name('penjualans.create');
Route::post('/penjualans', [PenjualanController::class, 'store'])->name('penjualans.store');
Route::get('/penjualans/{Penjualan}', [PenjualanController::class, 'show'])->name('penjualans.show');
Route::get('/penjualans/{penjualan}/edit', [PenjualanController::class, 'edit'])->name('penjualans.edit');
Route::put('/penjualans/{penjulan}', [PenjualanController::class, 'update'])->name('penjualans.update');
Route::delete('/penjualans/{penjualan}', [PenjualanController::class, 'destroy'])->name('penjualans.destroy');
Route::get('/cetak-Penjualan', [PenjualanController::class, 'cetaklaporan'])->name('penjualans.cetak-Pegawai');
Route::get('/laporan-penjualan/cetak', [PenjualanController::class, 'cetakLaporan'])->name('laporan.penjualan.cetak');
// Route Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
