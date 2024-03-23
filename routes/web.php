<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorCustomerController;
use App\Http\Controllers\MotorKategoriController;
use App\Http\Controllers\MotorBarangController;
use App\Http\Controllers\MotorPembelianController;
use App\Http\Controllers\MotorPenjualanController;
use App\Http\Controllers\MotorPengeluaranController;
use App\Http\Controllers\MotorLaporanCustomerController;
use App\Http\Controllers\MotorLaporanKeuanganController;
use App\Http\Controllers\MotorLaporanPenjualanController;
use App\Http\Controllers\MotorLaporanMovingStock;
use App\Http\Controllers\MotorLaporanLabaKategoriController;
use App\Http\Controllers\MotorLaporanLabaBulanController;

use App\Http\Controllers\BatchController;
use App\Http\Controllers\BatchSalesController;
use App\Http\Controllers\BarangController;

use App\Http\Controllers\StudioKategoriController;
use App\Http\Controllers\StudioCustomerController;
use App\Http\Controllers\StudioBarangController;
use App\Http\Controllers\StudioProdukController;
use App\Http\Controllers\StudioPembelianController;
use App\Http\Controllers\StudioPenjualanController;
use App\Http\Controllers\StudioPengeluaranController;
use App\Http\Controllers\StudioLimbahController;
use App\Http\Controllers\StudioLaporanCustomerController;
use App\Http\Controllers\StudioStockController;
use App\Http\Controllers\StudioLaporanKeuanganController;

use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesPenjualanController;
use App\Http\Controllers\SalesPembelianController;
use App\Http\Controllers\SalesLaporanKeuanganController;
use App\Http\Controllers\SalesKeuanganController;

use App\Http\Controllers\RokokCustomerController;
use App\Http\Controllers\RokokKategoriController;
use App\Http\Controllers\RokokBarangController;
use App\Http\Controllers\RokokPembelianController;
use App\Http\Controllers\RokokPenjualanController;
use App\Http\Controllers\RokokLaporanKeuanganController;

use App\Http\Controllers\MinyakCustomerController;
use App\Http\Controllers\MinyakKategoriController;
use App\Http\Controllers\MinyakBarangController;
use App\Http\Controllers\MinyakPembelianController;
use App\Http\Controllers\MinyakPenjualanController;
use App\Http\Controllers\MinyakLaporanKeuanganController;

use App\Http\Controllers\BerasCustomerController;
use App\Http\Controllers\BerasKategoriController;
use App\Http\Controllers\BerasBarangController;
use App\Http\Controllers\BerasPembelianController;
use App\Http\Controllers\BerasPenjualanController;
use App\Http\Controllers\BerasLaporanKeuanganController;

use App\Http\Controllers\BrilinkTransaksiController;
use App\Http\Controllers\BrilinkBankController;
use App\Http\Controllers\BrilinkLaporanKeuanganController;

use App\Http\Controllers\PupukCustomerController;
use App\Http\Controllers\PupukKategoriController;
use App\Http\Controllers\PupukBarangController;
use App\Http\Controllers\PupukPembelianController;
use App\Http\Controllers\PupukPenjualanController;
use App\Http\Controllers\PupukLaporanKeuanganController;
use App\Http\Controllers\PupukLaporanPenjualanController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\PinjamanLaporanKeuanganController;

use App\Http\Controllers\DasboardController;
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

Route::get('/', [DasboardController::class, 'index'])->name('dashboard.index');

Route::get('/fetch-batch', [BatchController::class, 'fetchData'])->name('fetch.batch');
Route::get('/fetch-batch-edit', [BatchController::class, 'fetchEditData'])->name('fetch.batchedit');
Route::get('/fetch-batch-sales', [BatchSalesController::class, 'fetchData'])->name('fetch.batchsales');
Route::get('/fetch-mitem', [BarangController::class, 'fetchData'])->name('fetch.mitem');
Route::get('/fetch-keuangan-sales', [SalesKeuanganController::class, 'fetchData'])->name('fetch.keuangansales');

Route::get('/pinjaman/customer/search', [CustomerController::class, 'search'])->name('customer.search');
Route::get('/pinjaman/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::post('/pinjaman/customer', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/pinjaman/customer/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('/pinjaman/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/pinjaman/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

Route::get('/pinjaman/keuangan/search', [PinjamanLaporanKeuanganController::class, 'search'])->name('pinjamankeuangan.search');
Route::get('/pinjaman/keuangan', [PinjamanLaporanKeuanganController::class, 'index'])->name('pinjamankeuangan.index');

Route::get('/pinjaman/search', [PinjamanController::class, 'search'])->name('pinjaman.search');
Route::get('/pinjaman', [PinjamanController::class, 'index'])->name('pinjaman.index');
Route::post('/pinjaman', [PinjamanController::class, 'store'])->name('pinjaman.store');
Route::get('/pinjaman/{id}', [PinjamanController::class, 'edit'])->name('pinjaman.edit');
Route::post('/pinjaman/{id}', [PinjamanController::class, 'update'])->name('pinjaman.update');
Route::delete('/pinjaman/{id}', [PinjamanController::class, 'destroy'])->name('pinjaman.destroy');

Route::get('/motor/customer/search', [MotorCustomerController::class, 'search'])->name('motorcustomer.search');
Route::get('/motor/customer', [MotorCustomerController::class, 'index'])->name('motorcustomer.index');
Route::post('/motor/customer', [MotorCustomerController::class, 'store'])->name('motorcustomer.store');
Route::get('/motor/customer/{id}', [MotorCustomerController::class, 'edit'])->name('motorcustomer.edit');
Route::post('/motor/customer/{id}', [MotorCustomerController::class, 'update'])->name('motorcustomer.update');
Route::delete('/motor/customer/{id}', [MotorCustomerController::class, 'destroy'])->name('motorcustomer.destroy');

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

Route::get('/motor/pengeluaran/search', [MotorPengeluaranController::class, 'search'])->name('motorpengeluaran.search');
Route::get('/motor/pengeluaran', [MotorPengeluaranController::class, 'index'])->name('motorpengeluaran.index');
Route::post('/motor/pengeluaran', [MotorPengeluaranController::class, 'store'])->name('motorpengeluaran.store');
Route::get('/motor/pengeluaran/{id}', [MotorPengeluaranController::class, 'edit'])->name('motorpengeluaran.edit');
Route::post('/motor/pengeluaran/{id}', [MotorPengeluaranController::class, 'update'])->name('motorpengeluaran.update');
Route::delete('/motor/pengeluaran/{id}', [MotorPengeluaranController::class, 'destroy'])->name('motorpengeluaran.destroy');

Route::get('/motor/laporanpenjualan/search', [MotorLaporanPenjualanController::class, 'search'])->name('motorlaporanpenjualan.search');
Route::get('/motor/laporanpenjualan', [MotorLaporanPenjualanController::class, 'index'])->name('motorlaporanpenjualan.index');

Route::get('/motor/laporanmovingstock/search', [MotorLaporanMovingStock::class, 'search'])->name('motorlaporanmovingstock.search');
Route::get('/motor/laporanmovingstock', [MotorLaporanMovingStock::class, 'index'])->name('motorlaporanmovingstock.index');

// Route::get('/motor/laporanpenjualan/search', [MotorLaporanPenjualanController::class, 'search'])->name('motorlaporanpenjualan.search');
Route::get('/motor/laporancustomer/search', [MotorLaporanCustomerController::class, 'search'])->name('motorlaporancustomer.search');
Route::get('/motor/laporancustomer', [MotorLaporanCustomerController::class, 'index'])->name('motorlaporancustomer.index');

Route::get('/motor/keuangan/search', [MotorLaporanKeuanganController::class, 'search'])->name('motorkeuangan.search');
Route::get('/motor/keuangan', [MotorLaporanKeuanganController::class, 'index'])->name('motorkeuangan.index');

Route::get('/motor/labakategori/search', [MotorLaporanLabaKategoriController::class, 'search'])->name('motorlaporanlabakategori.search');
Route::get('/motor/labakategori', [MotorLaporanLabaKategoriController::class, 'index'])->name('motorlaporanlabakategori.index');

Route::get('/motor/lababulan/search', [MotorLaporanLabaBulanController::class, 'search'])->name('motorlaporanlababulan.search');
Route::get('/motor/lababulan', [MotorLaporanLabaBulanController::class, 'index'])->name('motorlaporanlababulan.index');

Route::get('/motor/search', [MotorBarangController::class, 'search'])->name('motor.search');
Route::get('/motor', [MotorBarangController::class, 'index'])->name('motor.index');
Route::post('/motor', [MotorBarangController::class, 'store'])->name('motor.store');
Route::get('/motor/{id}', [MotorBarangController::class, 'edit'])->name('motor.edit');
Route::post('/motor/{id}', [MotorBarangController::class, 'update'])->name('motor.update');
Route::delete('/motor/{id}', [MotorBarangController::class, 'destroy'])->name('motor.destroy');

Route::get('/studio/customer/search', [StudioCustomerController::class, 'search'])->name('studiocustomer.search');
Route::get('/studio/customer', [StudioCustomerController::class, 'index'])->name('studiocustomer.index');
Route::post('/studio/customer', [StudioCustomerController::class, 'store'])->name('studiocustomer.store');
Route::get('/studio/customer/{id}', [StudioCustomerController::class, 'edit'])->name('studiocustomer.edit');
Route::post('/studio/customer/{id}', [StudioCustomerController::class, 'update'])->name('studiocustomer.update');
Route::delete('/studio/customer/{id}', [StudioCustomerController::class, 'destroy'])->name('studiocustomer.destroy');

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

Route::get('/studio/pengeluaran/search', [StudioPengeluaranController::class, 'search'])->name('studiopengeluaran.search');
Route::get('/studio/pengeluaran', [StudioPengeluaranController::class, 'index'])->name('studiopengeluaran.index');
Route::post('/studio/pengeluaran', [StudioPengeluaranController::class, 'store'])->name('studiopengeluaran.store');
Route::get('/studio/pengeluaran/{id}', [StudioPengeluaranController::class, 'edit'])->name('studiopengeluaran.edit');
Route::post('/studio/pengeluaran/{id}', [StudioPengeluaranController::class, 'update'])->name('studiopengeluaran.update');
Route::delete('/studio/pengeluaran/{id}', [StudioPengeluaranController::class, 'destroy'])->name('studiopengeluaran.destroy');

Route::get('/studio/limbah/search', [StudioLimbahController::class, 'search'])->name('studiolimbah.search');
Route::get('/studio/limbah', [StudioLimbahController::class, 'index'])->name('studiolimbah.index');
Route::post('/studio/limbah', [StudioLimbahController::class, 'store'])->name('studiolimbah.store');
Route::get('/studio/limbah/{id}', [StudioLimbahController::class, 'edit'])->name('studiolimbah.edit');
Route::post('/studio/limbah/{id}', [StudioLimbahController::class, 'update'])->name('studiolimbah.update');
Route::delete('/studio/limbah/{id}', [StudioLimbahController::class, 'destroy'])->name('studiolimbah.destroy');

Route::get('/studio/stock/search', [StudioStockController::class, 'search'])->name('studiostock.search');
Route::get('/studio/stock', [StudioStockController::class, 'index'])->name('studiostock.index');
Route::post('/studio/stock', [StudioStockController::class, 'store'])->name('studiostock.store');

Route::get('/studio/keuangan/search', [StudioLaporanKeuanganController::class, 'search'])->name('studiokeuangan.search');
Route::get('/studio/keuangan', [StudioLaporanKeuanganController::class, 'index'])->name('studiokeuangan.index');

Route::get('/studio/laporancustomer/search', [StudioLaporanCustomerController::class, 'search'])->name('studiolaporancustomer.search');
Route::get('/studio/laporancustomer', [StudioLaporanCustomerController::class, 'index'])->name('studiolaporancustomer.index');

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

Route::get('/sales/keuangan/search', [SalesLaporanKeuanganController::class, 'search'])->name('saleskeuangan.search');
Route::get('/sales/keuangan', [SalesLaporanKeuanganController::class, 'index'])->name('saleskeuangan.index');

Route::get('/sales/search', [SalesController::class, 'search'])->name('sales.search');
Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
Route::get('/sales/{id}', [SalesController::class, 'edit'])->name('sales.edit');
Route::post('/sales/{id}', [SalesController::class, 'update'])->name('sales.update');
Route::delete('/sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');

Route::get('/rokok/customer/search', [RokokCustomerController::class, 'search'])->name('rokokcustomer.search');
Route::get('/rokok/customer', [RokokCustomerController::class, 'index'])->name('rokokcustomer.index');
Route::post('/rokok/customer', [RokokCustomerController::class, 'store'])->name('rokokcustomer.store');
Route::get('/rokok/customer/{id}', [RokokCustomerController::class, 'edit'])->name('rokokcustomer.edit');
Route::post('/rokok/customer/{id}', [RokokCustomerController::class, 'update'])->name('rokokcustomer.update');
Route::delete('/rokok/customer/{id}', [RokokCustomerController::class, 'destroy'])->name('rokokcustomer.destroy');

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

Route::get('/rokok/keuangan/search', [RokokLaporanKeuanganController::class, 'search'])->name('rokokkeuangan.search');
Route::get('/rokok/keuangan', [RokokLaporanKeuanganController::class, 'index'])->name('rokokkeuangan.index');

Route::get('/rokok/search', [RokokBarangController::class, 'search'])->name('rokok.search');
Route::get('/rokok', [RokokBarangController::class, 'index'])->name('rokok.index');
Route::post('/rokok', [RokokBarangController::class, 'store'])->name('rokok.store');
Route::get('/rokok/{id}', [RokokBarangController::class, 'edit'])->name('rokok.edit');
Route::post('/rokok/{id}', [RokokBarangController::class, 'update'])->name('rokok.update');
Route::delete('/rokok/{id}', [RokokBarangController::class, 'destroy'])->name('rokok.destroy');

Route::get('/minyak/customer/search', [MinyakCustomerController::class, 'search'])->name('minyakcustomer.search');
Route::get('/minyak/customer', [MinyakCustomerController::class, 'index'])->name('minyakcustomer.index');
Route::post('/minyak/customer', [MinyakCustomerController::class, 'store'])->name('minyakcustomer.store');
Route::get('/minyak/customer/{id}', [MinyakCustomerController::class, 'edit'])->name('minyakcustomer.edit');
Route::post('/minyak/customer/{id}', [MinyakCustomerController::class, 'update'])->name('minyakcustomer.update');
Route::delete('/minyak/customer/{id}', [MinyakCustomerController::class, 'destroy'])->name('minyakcustomer.destroy');

Route::get('/minyak/kategori/search', [MinyakKategoriController::class, 'search'])->name('minyakkategori.search');
Route::get('/minyak/kategori', [MinyakKategoriController::class, 'index'])->name('minyakkategori.index');
Route::post('/minyak/kategori', [MinyakKategoriController::class, 'store'])->name('minyakkategori.store');
Route::get('/minyak/kategori/{id}', [MinyakKategoriController::class, 'edit'])->name('minyakkategori.edit');
Route::post('/minyak/kategori/{id}', [MinyakKategoriController::class, 'update'])->name('minyakkategori.update');
Route::delete('/minyak/kategori/{id}', [MinyakKategoriController::class, 'destroy'])->name('minyakkategori.destroy');

Route::get('/minyak/pembelian/search', [MinyakPembelianController::class, 'search'])->name('minyakpembelian.search');
Route::get('/minyak/pembelian', [MinyakPembelianController::class, 'index'])->name('minyakpembelian.index');
Route::post('/minyak/pembelian', [MinyakPembelianController::class, 'store'])->name('minyakpembelian.store');
Route::get('/minyak/pembelian/{id}', [MinyakPembelianController::class, 'edit'])->name('minyakpembelian.edit');
Route::post('/minyak/pembelian/{id}', [MinyakPembelianController::class, 'update'])->name('minyakpembelian.update');
Route::delete('/minyak/pembelian/{id}', [MinyakPembelianController::class, 'destroy'])->name('minyakpembelian.destroy');

Route::get('/minyak/penjualan/search', [MinyakPenjualanController::class, 'search'])->name('minyakpenjualan.search');
Route::get('/minyak/penjualan', [MinyakPenjualanController::class, 'index'])->name('minyakpenjualan.index');
Route::post('/minyak/penjualan', [MinyakPenjualanController::class, 'store'])->name('minyakpenjualan.store');
Route::get('/minyak/penjualan/{id}', [MinyakPenjualanController::class, 'edit'])->name('minyakpenjualan.edit');
Route::post('/minyak/penjualan/{id}', [MinyakPenjualanController::class, 'update'])->name('minyakpenjualan.update');
Route::delete('/minyak/penjualan/{id}', [MinyakPenjualanController::class, 'destroy'])->name('minyakpenjualan.destroy');

Route::get('/minyak/keuangan/search', [MinyakLaporanKeuanganController::class, 'search'])->name('minyakkeuangan.search');
Route::get('/minyak/keuangan', [MinyakLaporanKeuanganController::class, 'index'])->name('minyakkeuangan.index');

Route::get('/minyak/search', [MinyakBarangController::class, 'search'])->name('minyak.search');
Route::get('/minyak', [MinyakBarangController::class, 'index'])->name('minyak.index');
Route::post('/minyak', [MinyakBarangController::class, 'store'])->name('minyak.store');
Route::get('/minyak/{id}', [MinyakBarangController::class, 'edit'])->name('minyak.edit');
Route::post('/minyak/{id}', [MinyakBarangController::class, 'update'])->name('minyak.update');
Route::delete('/minyak/{id}', [MinyakBarangController::class, 'destroy'])->name('minyak.destroy');

Route::get('/beras/customer/search', [BerasCustomerController::class, 'search'])->name('berascustomer.search');
Route::get('/beras/customer', [BerasCustomerController::class, 'index'])->name('berascustomer.index');
Route::post('/beras/customer', [BerasCustomerController::class, 'store'])->name('berascustomer.store');
Route::get('/beras/customer/{id}', [BerasCustomerController::class, 'edit'])->name('berascustomer.edit');
Route::post('/beras/customer/{id}', [BerasCustomerController::class, 'update'])->name('berascustomer.update');
Route::delete('/beras/customer/{id}', [BerasCustomerController::class, 'destroy'])->name('berascustomer.destroy');

Route::get('/beras/kategori/search', [BerasKategoriController::class, 'search'])->name('beraskategori.search');
Route::get('/beras/kategori', [BerasKategoriController::class, 'index'])->name('beraskategori.index');
Route::post('/beras/kategori', [BerasKategoriController::class, 'store'])->name('beraskategori.store');
Route::get('/beras/kategori/{id}', [BerasKategoriController::class, 'edit'])->name('beraskategori.edit');
Route::post('/beras/kategori/{id}', [BerasKategoriController::class, 'update'])->name('beraskategori.update');
Route::delete('/beras/kategori/{id}', [BerasKategoriController::class, 'destroy'])->name('beraskategori.destroy');

Route::get('/beras/pembelian/search', [BerasPembelianController::class, 'search'])->name('beraspembelian.search');
Route::get('/beras/pembelian', [BerasPembelianController::class, 'index'])->name('beraspembelian.index');
Route::post('/beras/pembelian', [BerasPembelianController::class, 'store'])->name('beraspembelian.store');
Route::get('/beras/pembelian/{id}', [BerasPembelianController::class, 'edit'])->name('beraspembelian.edit');
Route::post('/beras/pembelian/{id}', [BerasPembelianController::class, 'update'])->name('beraspembelian.update');
Route::delete('/beras/pembelian/{id}', [BerasPembelianController::class, 'destroy'])->name('beraspembelian.destroy');

Route::get('/beras/penjualan/search', [BerasPenjualanController::class, 'search'])->name('beraspenjualan.search');
Route::get('/beras/penjualan', [BerasPenjualanController::class, 'index'])->name('beraspenjualan.index');
Route::post('/beras/penjualan', [BerasPenjualanController::class, 'store'])->name('beraspenjualan.store');
Route::get('/beras/penjualan/{id}', [BerasPenjualanController::class, 'edit'])->name('beraspenjualan.edit');
Route::post('/beras/penjualan/{id}', [BerasPenjualanController::class, 'update'])->name('beraspenjualan.update');
Route::delete('/beras/penjualan/{id}', [BerasPenjualanController::class, 'destroy'])->name('beraspenjualan.destroy');

Route::get('/beras/keuangan/search', [BerasLaporanKeuanganController::class, 'search'])->name('beraskeuangan.search');
Route::get('/beras/keuangan', [BerasLaporanKeuanganController::class, 'index'])->name('beraskeuangan.index');

Route::get('/beras/search', [BerasBarangController::class, 'search'])->name('beras.search');
Route::get('/beras', [BerasBarangController::class, 'index'])->name('beras.index');
Route::post('/beras', [BerasBarangController::class, 'store'])->name('beras.store');
Route::get('/beras/{id}', [BerasBarangController::class, 'edit'])->name('beras.edit');
Route::post('/beras/{id}', [BerasBarangController::class, 'update'])->name('beras.update');
Route::delete('/beras/{id}', [BerasBarangController::class, 'destroy'])->name('beras.destroy');

Route::get('/brilink/bank/search', [BrilinkBankController::class, 'search'])->name('brilinkbank.search');
Route::get('/brilink/bank', [BrilinkBankController::class, 'index'])->name('brilinkbank.index');
Route::post('/brilink/bank', [BrilinkBankController::class, 'store'])->name('brilinkbank.store');
Route::get('/brilink/bank/{id}', [BrilinkBankController::class, 'edit'])->name('brilinkbank.edit');
Route::post('/brilink/bank/{id}', [BrilinkBankController::class, 'update'])->name('brilinkbank.update');
Route::delete('/brilink/bank/{id}', [BrilinkBankController::class, 'destroy'])->name('brilinkbank.destroy');

Route::get('/brilink/keuangan/search', [BrilinkLaporanKeuanganController::class, 'search'])->name('brilinkkeuangan.search');
Route::get('/brilink/keuangan', [BrilinkLaporanKeuanganController::class, 'index'])->name('brilinkkeuangan.index');

Route::get('/brilink/search', [BrilinkTransaksiController::class, 'search'])->name('brilink.search');
Route::get('/brilink', [BrilinkTransaksiController::class, 'index'])->name('brilink.index');
Route::post('/brilink', [BrilinkTransaksiController::class, 'store'])->name('brilink.store');
Route::get('/brilink/{id}', [BrilinkTransaksiController::class, 'edit'])->name('brilink.edit');
Route::post('/brilink/{id}', [BrilinkTransaksiController::class, 'update'])->name('brilink.update');
Route::delete('/brilink/{id}', [BrilinkTransaksiController::class, 'destroy'])->name('brilink.destroy');

Route::get('/pupuk/customer/search', [PupukCustomerController::class, 'search'])->name('pupukcustomer.search');
Route::get('/pupuk/customer', [PupukCustomerController::class, 'index'])->name('pupukcustomer.index');
Route::post('/pupuk/customer', [PupukCustomerController::class, 'store'])->name('pupukcustomer.store');
Route::get('/pupuk/customer/{id}', [PupukCustomerController::class, 'edit'])->name('pupukcustomer.edit');
Route::post('/pupuk/customer/{id}', [PupukCustomerController::class, 'update'])->name('pupukcustomer.update');
Route::delete('/pupuk/customer/{id}', [PupukCustomerController::class, 'destroy'])->name('pupukcustomer.destroy');

Route::get('/pupuk/kategori/search', [PupukKategoriController::class, 'search'])->name('pupukkategori.search');
Route::get('/pupuk/kategori', [PupukKategoriController::class, 'index'])->name('pupukkategori.index');
Route::post('/pupuk/kategori', [PupukKategoriController::class, 'store'])->name('pupukkategori.store');
Route::get('/pupuk/kategori/{id}', [PupukKategoriController::class, 'edit'])->name('pupukkategori.edit');
Route::post('/pupuk/kategori/{id}', [PupukKategoriController::class, 'update'])->name('pupukkategori.update');
Route::delete('/pupuk/kategori/{id}', [PupukKategoriController::class, 'destroy'])->name('pupukkategori.destroy');

Route::get('/pupuk/pembelian/search', [PupukPembelianController::class, 'search'])->name('pupukpembelian.search');
Route::get('/pupuk/pembelian', [PupukPembelianController::class, 'index'])->name('pupukpembelian.index');
Route::post('/pupuk/pembelian', [PupukPembelianController::class, 'store'])->name('pupukpembelian.store');
Route::get('/pupuk/pembelian/{id}', [PupukPembelianController::class, 'edit'])->name('pupukpembelian.edit');
Route::post('/pupuk/pembelian/{id}', [PupukPembelianController::class, 'update'])->name('pupukpembelian.update');
Route::delete('/pupuk/pembelian/{id}', [PupukPembelianController::class, 'destroy'])->name('pupukpembelian.destroy');

Route::get('/pupuk/penjualan/search', [PupukPenjualanController::class, 'search'])->name('pupukpenjualan.search');
Route::get('/pupuk/penjualan', [PupukPenjualanController::class, 'index'])->name('pupukpenjualan.index');
Route::post('/pupuk/penjualan', [PupukPenjualanController::class, 'store'])->name('pupukpenjualan.store');
Route::get('/pupuk/penjualan/{id}', [PupukPenjualanController::class, 'edit'])->name('pupukpenjualan.edit');
Route::post('/pupuk/penjualan/{id}', [PupukPenjualanController::class, 'update'])->name('pupukpenjualan.update');
Route::delete('/pupuk/penjualan/{id}', [PupukPenjualanController::class, 'destroy'])->name('pupukpenjualan.destroy');

Route::get('/pupuk/keuangan/search', [PupukLaporanKeuanganController::class, 'search'])->name('pupukkeuangan.search');
Route::get('/pupuk/keuangan', [PupukLaporanKeuanganController::class, 'index'])->name('pupukkeuangan.index');

Route::get('/pupuk/laporanpenjualan', [PupukLaporanPenjualanController::class, 'index'])->name('pupuklaporanpenjualan.index');
Route::get('/pupuk/laporanpenjualan/search', [PupukLaporanPenjualanController::class, 'search'])->name('pupuklaporanpenjualan.search');

Route::get('/pupuk/search', [PupukBarangController::class, 'search'])->name('pupuk.search');
Route::get('/pupuk', [PupukBarangController::class, 'index'])->name('pupuk.index');
Route::post('/pupuk', [PupukBarangController::class, 'store'])->name('pupuk.store');
Route::get('/pupuk/{id}', [PupukBarangController::class, 'edit'])->name('pupuk.edit');
Route::post('/pupuk/{id}', [PupukBarangController::class, 'update'])->name('pupuk.update');
Route::delete('/pupuk/{id}', [PupukBarangController::class, 'destroy'])->name('pupuk.destroy');
