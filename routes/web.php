<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SatgasController;
use App\Http\Controllers\PelaporController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminSatgasController;
use App\Http\Controllers\Admin\AdminPelaporController;
use App\Http\Controllers\Admin\AdminKasusController;
use App\Http\Controllers\Admin\KriteriaTopsisController;
use App\Http\Controllers\Admin\RuangController;
use App\Http\Controllers\Admin\FasilitasController;
use Illuminate\Support\Facades\Route;

// Route untuk pengaduan
Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/pengaduan/success', [PengaduanController::class, 'success'])->name('pengaduan.success');
Route::get('/pengaduan/progress', [PengaduanController::class, 'lihatProgres'])->name('pengaduan.progress');
Route::post('/pengaduan/cek-status', [PengaduanController::class, 'cekStatus'])->name('pengaduan.cek-status');
Route::get('/pengaduan/status/{kode}', [PengaduanController::class, 'detailStatus'])->name('pengaduan.detail-status');

// Route untuk registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes untuk pelapor
Route::prefix('pelapor')->name('pelapor.')->group(function () {
    Route::get('/dashboard', [PelaporController::class, 'dashboard'])->name('dashboard');
    Route::get('/ajukan-pengaduan', [PelaporController::class, 'ajukanPengaduan'])->name('ajukan_pengaduan');
    Route::get('/lihat-progres', [PelaporController::class, 'lihatProgres'])->name('lihat_progres');
});

// Routes untuk autentikasi
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route group untuk admin yang sudah terautentikasi
Route::group(['middleware' => ['web', 'auth', 'role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Routes untuk tindak lanjut
    Route::prefix('tindak-lanjut')->name('tindak_lanjut.')->group(function () {
        Route::get('/belum-selesai', [AdminController::class, 'kasusBelumSelesai'])->name('belum_selesai');
        Route::get('/selesai', [AdminController::class, 'kasusSelesai'])->name('selesai');
        Route::get('/{id}', [AdminController::class, 'detailKasus'])->name('detail');
        Route::put('/{id}/update-status', [AdminController::class, 'updateStatus'])->name('update_status');
        Route::post('/{id}/assign-satgas', [AdminController::class, 'assignSatgas'])->name('assign_satgas');
    });

    // Routes untuk data master
    Route::resources([
        'kasus' => AdminKasusController::class,
        'satgas' => AdminSatgasController::class,
        'pelapor' => AdminPelaporController::class,
        'ruang' => RuangController::class,
        'fasilitas' => FasilitasController::class,
        'topsis' => KriteriaTopsisController::class,
    ]);
});

// Route group untuk satgas
Route::middleware(['auth', 'role:satgas'])->prefix('satgas')->name('satgas.')->group(function () {
    Route::get('/dashboard', [SatgasController::class, 'dashboard'])->name('dashboard');
    Route::get('/kasus-baru', [SatgasController::class, 'kasusBaru'])->name('kasus_baru');
    Route::get('/kasus-proses', [SatgasController::class, 'kasusProses'])->name('kasus_proses');
    Route::get('/kasus-selesai', [SatgasController::class, 'kasusSelesai'])->name('kasus_selesai');
    Route::get('/detail-kasus/{id}', [SatgasController::class, 'detailKasus'])->name('detail_kasus');
    Route::put('/update-status-kasus/{id}', [SatgasController::class, 'updateStatusKasus'])->name('update_status_kasus');
    Route::get('/profil', [SatgasController::class, 'profil'])->name('profil');
    Route::put('/profil/update', [SatgasController::class, 'updateProfil'])->name('profil.update');
    Route::put('/profil/password', [SatgasController::class, 'updatePassword'])->name('password.update');
    Route::post('/update-foto', [SatgasController::class, 'updateFotoProfil'])->name('update_foto');
});


