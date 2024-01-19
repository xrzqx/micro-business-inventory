<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorKategoriController;
use App\Http\Controllers\MotorBarangController;
use App\Http\Controllers\MotorPembelianController;
use App\Http\Controllers\MotorPenjualanController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\StudioKategoriController;
use App\Http\Controllers\StudioBarangController;
use App\Http\Controllers\StudioProdukController;
use App\Http\Controllers\StudioPembelianController;
use App\Http\Controllers\StudioPenjualanController;

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

Route::get('/motor/kategori/search', [MotorKategoriController::class, 'search'])->name('motorkategori.search');
Route::get('/motor/kategori', [MotorKategoriController::class, 'index'])->name('motorkategori.index');
Route::post('/motor/kategori', [MotorKategoriController::class, 'store'])->name('motorkategori.store');
Route::get('/motor/kategori/{id}', [MotorKategoriController::class, 'edit'])->name('motorkategori.edit');
Route::post('/motor/kategori/{id}', [MotorKategoriController::class, 'update'])->name('motorkategori.update');
Route::delete('/motor/kategori/{id}', [MotorKategoriController::class, 'destroy'])->name('motorkategori.destroy');

Route::get('/motor/pembelian/search', [MotorPembelianController::class, 'search'])->name('motorpembelian.search');
Route::get('/motor/pembelian', [MotorPembelianController::class, 'index'])->name('motorpembelian.index');
Route::post('/motor/pembelian', [MotorPembelianController::class, 'store'])->name('motorpembelian.store');
Route::get('/motor/pembelian/{id}', [MotorPembelianController::class, 'edit'])->name('motorpembelian.edit');
Route::post('/motor/pembelian/{id}', [MotorPembelianController::class, 'update'])->name('motorpembelian.update');
Route::delete('/motor/pembelian/{id}', [MotorPembelianController::class, 'destroy'])->name('motorpembelian.destroy');

Route::get('/motor/penjualan/search', [MotorPenjualanController::class, 'search'])->name('motorpenjualan.search');
Route::get('/motor/penjualan', [MotorPenjualanController::class, 'index'])->name('motorpenjualan.index');
Route::post('/motor/penjualan', [MotorPenjualanController::class, 'store'])->name('motorpenjualan.store');
Route::get('/motor/penjualan/{id}', [MotorPenjualanController::class, 'edit'])->name('motorpenjualan.edit');
Route::post('/motor/penjualan/{id}', [MotorPenjualanController::class, 'update'])->name('motorpenjualan.update');
Route::delete('/motor/penjualan/{id}', [MotorPenjualanController::class, 'destroy'])->name('motorpenjualan.destroy');

Route::get('/motor/search', [MotorBarangController::class, 'search'])->name('motor.search');
Route::get('/motor', [MotorBarangController::class, 'index'])->name('motor.index');
Route::post('/motor', [MotorBarangController::class, 'store'])->name('motor.store');
Route::get('/motor/{id}', [MotorBarangController::class, 'edit'])->name('motor.edit');
Route::post('/motor/{id}', [MotorBarangController::class, 'update'])->name('motor.update');
Route::delete('/motor/{id}', [MotorBarangController::class, 'destroy'])->name('motor.destroy');

Route::get('/studio/kategori/search', [StudioKategoriController::class, 'search'])->name('studiokategori.search');
Route::get('/studio/kategori', [StudioKategoriController::class, 'index'])->name('studiokategori.index');
Route::post('/studio/kategori', [StudioKategoriController::class, 'store'])->name('studiokategori.store');
Route::get('/studio/kategori/{id}', [StudioKategoriController::class, 'edit'])->name('studiokategori.edit');
Route::post('/studio/kategori/{id}', [StudioKategoriController::class, 'update'])->name('studiokategori.update');
Route::delete('/studio/kategori/{id}', [StudioKategoriController::class, 'destroy'])->name('studiokategori.destroy');

Route::get('/studio/produk/search', [StudioProdukController::class, 'search'])->name('studioproduk.search');
Route::get('/studio/produk', [StudioProdukController::class, 'index'])->name('studioproduk.index');
Route::post('/studio/produk', [StudioProdukController::class, 'store'])->name('studioproduk.store');
Route::get('/studio/produk/{id}', [StudioProdukController::class, 'edit'])->name('studioproduk.edit');
Route::post('/studio/produk/{id}', [StudioProdukController::class, 'update'])->name('studioproduk.update');
Route::delete('/studio/produk/{id}', [StudioProdukController::class, 'destroy'])->name('studioproduk.destroy');

Route::get('/studio/pembelian/search', [StudioPembelianController::class, 'search'])->name('studiopembelian.search');
Route::get('/studio/pembelian', [StudioPembelianController::class, 'index'])->name('studiopembelian.index');
Route::post('/studio/pembelian', [StudioPembelianController::class, 'store'])->name('studiopembelian.store');
Route::get('/studio/pembelian/{id}', [StudioPembelianController::class, 'edit'])->name('studiopembelian.edit');
Route::post('/studio/pembelian/{id}', [StudioPembelianController::class, 'update'])->name('studiopembelian.update');
Route::delete('/studio/pembelian/{id}', [StudioPembelianController::class, 'destroy'])->name('studiopembelian.destroy');

Route::get('/studio/penjualan/search', [StudioPenjualanController::class, 'search'])->name('studiopenjualan.search');
Route::get('/studio/penjualan', [StudioPenjualanController::class, 'index'])->name('studiopenjualan.index');
Route::post('/studio/penjualan', [StudioPenjualanController::class, 'store'])->name('studiopenjualan.store');
Route::get('/studio/penjualan/{id}', [StudioPenjualanController::class, 'edit'])->name('studiopenjualan.edit');
Route::post('/studio/penjualan/{id}', [StudioPenjualanController::class, 'update'])->name('studiopenjualan.update');
Route::delete('/studio/penjualan/{id}', [StudioPenjualanController::class, 'destroy'])->name('studiopenjualan.destroy');

Route::get('/studio/search', [StudioBarangController::class, 'search'])->name('studio.search');
Route::get('/studio', [StudioBarangController::class, 'index'])->name('studio.index');
Route::post('/studio', [StudioBarangController::class, 'store'])->name('studio.store');
Route::get('/studio/{id}', [StudioBarangController::class, 'edit'])->name('studio.edit');
Route::post('/studio/{id}', [StudioBarangController::class, 'update'])->name('studio.update');
Route::delete('/studio/{id}', [StudioBarangController::class, 'destroy'])->name('studio.destroy');
