<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HasilRekomendasiController as AdminRekomendasi;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MatakuliahBidangController;
use App\Http\Controllers\Admin\NilaiAkademikController;
use App\Http\Controllers\Admin\PreferensiMinatController;
use App\Http\Controllers\Admin\ProsesController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TesBakatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController as mahasiswaDashboard;
use App\Http\Controllers\HasilRekomendasiController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TesBakatController as TesBakatMahasiswa;
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
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
});

Route::middleware(['auth'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [mahasiswaDashboard::class, 'index'])->name('dashboard');
    Route::get('/input-nilai-minat', [InputController::class, 'form'])->name('input.form');
    Route::post('/input-nilai-minat', [InputController::class, 'submit'])->name('input.submit');
    Route::get('/hasil-rekomendasi-peminatan', [HasilRekomendasiController::class, 'showSelf'])
        ->name('rekomendasi.self');
    Route::get('tes-bakat', [TesBakatMahasiswa::class, 'form'])->name('tes.form');
    Route::post('tes-bakat', [TesBakatMahasiswa::class, 'submit'])->name('tes.submit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/mahasiswa', MahasiswaController::class);
    Route::resource('/nilai', NilaiAkademikController::class);
    Route::resource('/minat', PreferensiMinatController::class);
    Route::resource('/tes', TesBakatController::class);
    Route::get('/proses', [ProsesController::class, 'index'])->name('proses.index');
    Route::get('/proses/{id}', [ProsesController::class, 'proses'])->name('proses.proses');
    Route::get('/proses/ajax/{id}', [ProsesController::class, 'prosesAjax'])->name('admin.proses.ajax');
    Route::get('/hasil-rekomendasi', [AdminRekomendasi::class, 'index'])->name('hasil.index');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('matakuliah-bidang', MatakuliahBidangController::class)->names('matakuliah-bidang');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
//     // Semua menu mahasiswa
// });

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';