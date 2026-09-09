<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\BagiHasilController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanStokController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\KasbonController;

Route::get('/', function () {
    return view('welcome');
});
// Nonaktifkan register (PERMANEN)
Route::match(['get', 'post'], '/register', function () {
    abort(404);
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    Route::get('/dashboard/download', [DashboardController::class, 'download'])
    ->name('dashboard.download');
    Route::get('/dashboard/pemasukan-hari-ini', [DashboardController::class, 'pemasukanHariIni'])
    ->name('dashboard.pemasukanHariIni');
Route::get('/dashboard/pengeluaran-hari-ini', [DashboardController::class, 'pengeluaranHariIni'])
    ->name('dashboard.pengeluaranHariIni');
    // ========================================
    // PRODUK (Owner)
    // ========================================
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/api/produk/{kategori}', [ProdukController::class, 'getByKategori']);

    // ========================================
    // KARYAWAN (Owner)
    // ========================================
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::get('/kasbon/sisa/{karyawan}', [PengeluaranController::class, 'sisaKasbon']);
    Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::post('/karyawan/{id}/nonaktif',
        [App\Http\Controllers\KaryawanController::class, 'nonaktifkanKaryawan']
    )->name('karyawan.nonaktifKaryawan');

    Route::post('/karyawan/{id}/aktif',
        [App\Http\Controllers\KaryawanController::class, 'aktifkanKaryawan']
    )->name('karyawan.aktifkanKaryawan');

    Route::get('/bagi-hasil', [BagiHasilController::class, 'index'])
        ->name('bagi-hasil.index');
    Route::get('/laporan/bagi-hasil', 
    [BagiHasilController::class, 'laporan']
)->name('bagi-hasil.laporan');

Route::get('/laporan/bagi-hasil/pdf/{periode}', 
    [BagiHasilController::class, 'pdf']
)->name('bagi-hasil.pdf');

  Route::post('/bagi-hasil/simpan-gaji', 
    [BagiHasilController::class, 'simpanGajiKasir']
)->name('bagi-hasil.simpan-gaji');
Route::post(
    '/bagi-hasil/bayar-periode',
    [BagiHasilController::class, 'bayarGajiPeriode']
)->name('bagi-hasil.bayar-periode');

Route::post('/periode/tutup', [PeriodeController::class, 'tutup'])
    ->name('periode.tutup');


    // ========================================
    // PENJUALAN & LAPORAN
    // ========================================
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/pesanan', [App\Http\Controllers\PesananController::class, 'index'])
    ->name('pesanan.index');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');

    Route::patch('/pesanan/{id}/siap', [PesananController::class, 'siap'])
    ->name('pesanan.siap');

    // ========================================
    // PEMASUKAN
    // ========================================
    Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
    Route::get('/pemasukan/create', [PemasukanController::class, 'create'])->name('pemasukan.create');
    Route::post('/pemasukan/store', [PemasukanController::class, 'store'])->name('pemasukan.store');
    Route::get('/api/pemasukan/produk/{kategori}', [PemasukanController::class, 'getByKategori']);
      Route::get('/pemasukan/export', [PemasukanController::class, 'export'])
        ->name('pemasukan.export');

    Route::get('/stok', [App\Http\Controllers\LaporanStokController::class, 'index'])
        ->name('stok.index');
     Route::get('/laporan/stok/pdf',
        [LaporanStokController::class, 'export'])
        ->name('stok.export');

    // cek tambahan (plat, cuci gratis)
    Route::get('/cek-plat', [PemasukanController::class, 'checkPlat']);
    Route::get('/cek-cuci-gratis', [PemasukanController::class, 'cekCuciGratis']);

    // API PRODUK untuk pemasukan
    Route::get('/api/pemasukan/{kategori}', [PemasukanController::class, 'getByKategori']);


    // ========================================
    // PENGELUARAN
    // ========================================
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');
    Route::get('/pengeluaran/export', [PengeluaranController::class, 'export'])
    ->name('pengeluaran.export');
    Route::get('/kasbon', [KasbonController::class, 'index'])->name('kasbon.index');
    Route::get('/search-stok-barang', [PengeluaranController::class, 'searchStokBarang']);
    Route::get('/search-minuman', [PengeluaranController::class, 'searchMinuman']);


    // API pengeluaran
    Route::get('/pengeluaran/karyawan', [PengeluaranController::class, 'listKaryawan']);
    // API search produk (auto-suggestion untuk pengeluaran lainnya)
    Route::get('/api/search-produk', [ProdukController::class, 'search']);
    Route::get('/api/pengeluaran/{kategori}', [ProdukController::class, 'getByKategori']); 
// jika pakai produk tambahan

});

require __DIR__.'/auth.php';
