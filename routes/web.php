<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorKategoriController;
use App\Http\Controllers\MotorBarangController;
use App\Http\Controllers\MotorPembelianController;
use App\Http\Controllers\MotorPenjualanController;
use App\Http\Controllers\BatchController;

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
    return view('dashboard.index');
});

Route::get('/fetch-batch', [BatchController::class, 'fetchData'])->name('fetch.batch');

Route::get('/motor/kategori', [MotorKategoriController::class, 'index'])->name('motorkategori.index');
Route::post('/motor/kategori', [MotorKategoriController::class, 'store'])->name('motorkategori.store');
Route::get('/motor/kategori/{id}', [MotorKategoriController::class, 'edit'])->name('motorkategori.edit');
Route::post('/motor/kategori/{id}', [MotorKategoriController::class, 'update'])->name('motorkategori.update');
Route::delete('/motor/kategori/{id}', [MotorKategoriController::class, 'destroy'])->name('motorkategori.destroy');

Route::get('/motor/pembelian', [MotorPembelianController::class, 'index'])->name('motorpembelian.index');
Route::post('/motor/pembelian', [MotorPembelianController::class, 'store'])->name('motorpembelian.store');
Route::get('/motor/pembelian/{id}', [MotorPembelianController::class, 'edit'])->name('motorpembelian.edit');
Route::post('/motor/pembelian/{id}', [MotorPembelianController::class, 'update'])->name('motorpembelian.update');
Route::delete('/motor/pembelian/{id}', [MotorPembelianController::class, 'destroy'])->name('motorpembelian.destroy');

Route::get('/motor/penjualan', [MotorPenjualanController::class, 'index'])->name('motorpenjualan.index');
Route::post('/motor/penjualan', [MotorPenjualanController::class, 'store'])->name('motorpenjualan.store');
Route::get('/motor/penjualan/{id}', [MotorPenjualanController::class, 'edit'])->name('motorpenjualan.edit');
Route::post('/motor/penjualan/{id}', [MotorPenjualanController::class, 'update'])->name('motorpenjualan.update');
Route::delete('/motor/penjualan/{id}', [MotorPenjualanController::class, 'destroy'])->name('motorpenjualan.destroy');

Route::get('/motor', [MotorBarangController::class, 'index'])->name('motor.index');
Route::post('/motor', [MotorBarangController::class, 'store'])->name('motor.store');
Route::get('/motor/{id}', [MotorBarangController::class, 'edit'])->name('motor.edit');
Route::post('/motor/{id}', [MotorBarangController::class, 'update'])->name('motor.update');
Route::delete('/motor/{id}', [MotorKategoriController::class, 'destroy'])->name('motor.destroy');
