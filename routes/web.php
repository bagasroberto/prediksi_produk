<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\DataSupplierController;
use App\Http\Controllers\KeluarBarangController;
use App\Http\Controllers\TerimaBarangController;
use App\Http\Controllers\DataBarangDiscController;

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
    return view('landing-page');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth', 'verified');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['verified', 'auth']], function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Get Data Barang
    Route::get('data-barang-get', [DataBarangController::class, 'getDataBarang'])->name('data-barang-get');
    // Data Barang Resource
    Route::resource('data-barang', DataBarangController::class);

    // Get Data Kategori
    Route::get('kategori-get', [KategoriController::class, 'getDataKategori'])->name('kategori-get')->middleware('auth', 'verified');
    // Data Kategori Resource
    Route::resource('kategori', KategoriController::class)->middleware('auth', 'verified');

    // Data Supplier Resource
    Route::resource('data-supplier', DataSupplierController::class);

    // Data Barang Discontinue Resource
    Route::resource('data-barangDisc', DataBarangDiscController::class);

    // Terima Barang Discontinue Resource
    Route::resource('terima-barang', TerimaBarangController::class);

    // Keluar Barang Discontinue Resource
    Route::resource('keluar-barang', KeluarBarangController::class);

    // Get Data User
    Route::get('user-get', [UserController::class, 'getDataUser'])->name('user-get')->middleware('auth', 'verified');

    // User Resource
    Route::resource('user', UserController::class);

});

// Route::get('data-barang', [DataBarangController::class, 'index']);
// Route::post('data-barang/tambah-data', [DataBarangController::class, 'store'])->name('databarang.store');
// Route::get('data-barang/list', [DataBarangController::class, 'getDataBarang'])->name('databarang.list');

// Route::resource('data-barang', DataBarangController::class)->middleware('auth', 'verified');
// Route::get('data-barang-get', [DataBarangController::class, 'getDataBarang'])->name('data-barang-get')->middleware('auth', 'verified');

require __DIR__ . '/auth.php';
