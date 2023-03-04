<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\DataBarangDiscController;
use App\Http\Controllers\DataSupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TerimaBarangController;
use App\Models\TerimaBarang;
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
    return view('landing-page');
});

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

    // Data Supplier Resource
    Route::resource('data-supplier', DataSupplierController::class);

    // Data Barang Discontinue Resource
    Route::resource('data-barangDisc', DataBarangDiscController::class);

    // Terima Barang Discontinue Resource
    Route::resource('terima-barang', TerimaBarangController::class);

});

Route::get('/coba', function(){
    return
    $terimas = TerimaBarang::with(['supplier', 'barang'])->get();
});


require __DIR__ . '/auth.php';
