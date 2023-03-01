<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth', 'verified');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::get('data-barang', [DataBarangController::class, 'index']);
// Route::post('data-barang/tambah-data', [DataBarangController::class, 'store'])->name('databarang.store');
// Route::get('data-barang/list', [DataBarangController::class, 'getDataBarang'])->name('databarang.list');

Route::resource('data-barang', DataBarangController::class)->middleware('auth', 'verified');
Route::get('data-barang-get', [DataBarangController::class, 'getDataBarang'])->name('data-barang-get')->middleware('auth', 'verified');
// Route::get('data-barang', [DataBarangController::class, 'index'])->middleware('auth', 'verified');

require __DIR__ . '/auth.php';
