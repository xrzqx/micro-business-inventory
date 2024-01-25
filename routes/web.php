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
use App\Http\Controllers\StudioLimbahController;
use App\Http\Controllers\StudioStockController;

use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesPenjualanController;
use App\Http\Controllers\SalesPembelianController;

use App\Http\Controllers\RokokKategoriController;
use App\Http\Controllers\RokokBarangController;
use App\Http\Controllers\RokokPembelianController;
use App\Http\Controllers\RokokPenjualanController;

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

Route::get('/studio/limbah/search', [StudioLimbahController::class, 'search'])->name('studiolimbah.search');
Route::get('/studio/limbah', [StudioLimbahController::class, 'index'])->name('studiolimbah.index');
Route::post('/studio/limbah', [StudioLimbahController::class, 'store'])->name('studiolimbah.store');
Route::get('/studio/limbah/{id}', [StudioLimbahController::class, 'edit'])->name('studiolimbah.edit');
Route::post('/studio/limbah/{id}', [StudioLimbahController::class, 'update'])->name('studiolimbah.update');
Route::delete('/studio/limbah/{id}', [StudioLimbahController::class, 'destroy'])->name('studiolimbah.destroy');

Route::get('/studio/stock/search', [StudioStockController::class, 'search'])->name('studiostock.search');
Route::get('/studio/stock', [StudioStockController::class, 'index'])->name('studiostock.index');
Route::post('/studio/stock', [StudioStockController::class, 'store'])->name('studiostock.store');
// Route::get('/studio/stock/{id}', [StudioStockController::class, 'edit'])->name('studiostock.edit');
// Route::post('/studio/stock/{id}', [StudioStockController::class, 'update'])->name('studiostock.update');
// Route::delete('/studio/stock/{id}', [StudioStockController::class, 'destroy'])->name('studiostock.destroy');

Route::get('/studio/search', [StudioBarangController::class, 'search'])->name('studio.search');
Route::get('/studio', [StudioBarangController::class, 'index'])->name('studio.index');
Route::post('/studio', [StudioBarangController::class, 'store'])->name('studio.store');
Route::get('/studio/{id}', [StudioBarangController::class, 'edit'])->name('studio.edit');
Route::post('/studio/{id}', [StudioBarangController::class, 'update'])->name('studio.update');
Route::delete('/studio/{id}', [StudioBarangController::class, 'destroy'])->name('studio.destroy');

Route::get('/sales/pembelian/search', [SalesPembelianController::class, 'search'])->name('salespembelian.search');
Route::get('/sales/pembelian', [SalesPembelianController::class, 'index'])->name('salespembelian.index');
Route::post('/sales/pembelian', [SalesPembelianController::class, 'store'])->name('salespembelian.store');
Route::get('/sales/pembelian/{id}', [SalesPembelianController::class, 'edit'])->name('salespembelian.edit');
Route::post('/sales/pembelian/{id}', [SalesPembelianController::class, 'update'])->name('salespembelian.update');
Route::delete('/sales/pembelian/{id}', [SalesPembelianController::class, 'destroy'])->name('salespembelian.destroy');

Route::get('/sales/penjualan/search', [SalesPenjualanController::class, 'search'])->name('salespenjualan.search');
Route::get('/sales/penjualan', [SalesPenjualanController::class, 'index'])->name('salespenjualan.index');
Route::post('/sales/penjualan', [SalesPenjualanController::class, 'store'])->name('salespenjualan.store');
Route::get('/sales/penjualan/{id}', [SalesPenjualanController::class, 'edit'])->name('salespenjualan.edit');
Route::post('/sales/penjualan/{id}', [SalesPenjualanController::class, 'update'])->name('salespenjualan.update');
Route::delete('/sales/penjualan/{id}', [SalesPenjualanController::class, 'destroy'])->name('salespenjualan.destroy');

Route::get('/sales/search', [SalesController::class, 'search'])->name('sales.search');
Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
Route::get('/sales/{id}', [SalesController::class, 'edit'])->name('sales.edit');
Route::post('/sales/{id}', [SalesController::class, 'update'])->name('sales.update');
Route::delete('/sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');

Route::get('/rokok/kategori/search', [RokokKategoriController::class, 'search'])->name('rokokkategori.search');
Route::get('/rokok/kategori', [RokokKategoriController::class, 'index'])->name('rokokkategori.index');
Route::post('/rokok/kategori', [RokokKategoriController::class, 'store'])->name('rokokkategori.store');
Route::get('/rokok/kategori/{id}', [RokokKategoriController::class, 'edit'])->name('rokokkategori.edit');
Route::post('/rokok/kategori/{id}', [RokokKategoriController::class, 'update'])->name('rokokkategori.update');
Route::delete('/rokok/kategori/{id}', [RokokKategoriController::class, 'destroy'])->name('rokokkategori.destroy');

Route::get('/rokok/pembelian/search', [RokokPembelianController::class, 'search'])->name('rokokpembelian.search');
Route::get('/rokok/pembelian', [RokokPembelianController::class, 'index'])->name('rokokpembelian.index');
Route::post('/rokok/pembelian', [RokokPembelianController::class, 'store'])->name('rokokpembelian.store');
Route::get('/rokok/pembelian/{id}', [RokokPembelianController::class, 'edit'])->name('rokokpembelian.edit');
Route::post('/rokok/pembelian/{id}', [RokokPembelianController::class, 'update'])->name('rokokpembelian.update');
Route::delete('/rokok/pembelian/{id}', [RokokPembelianController::class, 'destroy'])->name('rokokpembelian.destroy');

Route::get('/rokok/penjualan/search', [RokokPenjualanController::class, 'search'])->name('rokokpenjualan.search');
Route::get('/rokok/penjualan', [RokokPenjualanController::class, 'index'])->name('rokokpenjualan.index');
Route::post('/rokok/penjualan', [RokokPenjualanController::class, 'store'])->name('rokokpenjualan.store');
Route::get('/rokok/penjualan/{id}', [RokokPenjualanController::class, 'edit'])->name('rokokpenjualan.edit');
Route::post('/rokok/penjualan/{id}', [RokokPenjualanController::class, 'update'])->name('rokokpenjualan.update');
Route::delete('/rokok/penjualan/{id}', [RokokPenjualanController::class, 'destroy'])->name('rokokpenjualan.destroy');

Route::get('/rokok/search', [RokokBarangController::class, 'search'])->name('rokok.search');
Route::get('/rokok', [RokokBarangController::class, 'index'])->name('rokok.index');
Route::post('/rokok', [RokokBarangController::class, 'store'])->name('rokok.store');
Route::get('/rokok/{id}', [RokokBarangController::class, 'edit'])->name('rokok.edit');
Route::post('/rokok/{id}', [RokokBarangController::class, 'update'])->name('rokok.update');
Route::delete('/rokok/{id}', [RokokBarangController::class, 'destroy'])->name('rokok.destroy');
