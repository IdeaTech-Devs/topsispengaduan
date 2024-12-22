<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Kemahasiswaan_Controller;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SatgasController;
use App\Http\Controllers\PelaporController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminSatgasController;
use App\Http\Controllers\Admin\AdminKemahasiswaanController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPelaporController;
use App\Http\Controllers\Admin\AdminKasusController;
use App\Http\Controllers\Admin\AdminKasusSatgasController;
use App\Http\Controllers\Admin\KriteriaTopsisController;
use App\Http\Controllers\Admin\AdminManagementController;
use Illuminate\Support\Facades\Route;




// Kemahasiswaan routes
Route::middleware(['role:kemahasiswaan'])->prefix('kemahasiswaan')->name('kemahasiswaan.')->group(function () {
    Route::get('/dashboard', [Kemahasiswaan_Controller::class, 'dashboard'])->name('dashboard');
    Route::get('/lihat-kasus', [Kemahasiswaan_Controller::class, 'lihatKasus'])->name('lihat_kasus');
    Route::get('/kelola-kasus', [Kemahasiswaan_Controller::class, 'kelolaKasus'])->name('kelola_kasus');
    Route::get('/kasus-selesai', [Kemahasiswaan_Controller::class, 'kasusSelesai'])->name('kasus_selesai');
    Route::get('/profil', [Kemahasiswaan_Controller::class, 'profil'])->name('profil');
    Route::put('/update-profil', [Kemahasiswaan_Controller::class, 'updateProfil'])->name('update-profil');
    Route::put('/update-password', [Kemahasiswaan_Controller::class, 'updatePassword'])->name('update-password');
    Route::post('/update-foto', [Kemahasiswaan_Controller::class, 'updateFotoProfil'])->name('update-foto');
    Route::post('/update-status/{id}', [Kemahasiswaan_Controller::class, 'updateStatus'])->name('update_status');
    Route::get('/detail-kasus/{id}', [Kemahasiswaan_Controller::class, 'detailKasus'])->name('detail_kasus');
    Route::post('/evaluasi-kasus/{id}', [Kemahasiswaan_Controller::class, 'evaluasiKasus'])->name('evaluasi_kasus');
    Route::post('/verifikasi-kasus/{id}', [Kemahasiswaan_Controller::class, 'verifikasiKasus'])->name('verifikasi_kasus');
    Route::post('/evaluasi-ulang/{id}', [Kemahasiswaan_Controller::class, 'evaluasiUlang'])->name('evaluasi_ulang');
});


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
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::prefix('tindak-lanjut')->name('tindak_lanjut.')->group(function () {
        Route::get('/belum-selesai', [AdminController::class, 'kasusBelumSelesai'])->name('belum_selesai');
        Route::get('/selesai', [AdminController::class, 'kasusSelesai'])->name('selesai');
        Route::get('/{id}', [AdminController::class, 'detailKasus'])->name('detail');
        Route::put('/{id}/update-status', [AdminController::class, 'updateStatus'])->name('update_status');
        Route::post('/{id}/assign-satgas', [AdminController::class, 'assignSatgas'])->name('assign_satgas');
    });
    Route::resource('kasus', AdminKasusController::class);
    
    // Routes untuk Satgas
    Route::resource('satgas', AdminSatgasController::class);
    
    // Routes untuk Kemahasiswaan
    Route::resource('kemahasiswaan', AdminKemahasiswaanController::class);
    
    // Routes untuk User
    Route::resource('users', AdminUserController::class);
    
    // Routes untuk Pelapor
    Route::resource('pelapor', AdminPelaporController::class);
    
    // Routes untuk Kasus Satgas
    Route::get('kasus-satgas', [AdminKasusSatgasController::class, 'index'])
        ->name('kasus_satgas.index');
    Route::get('kasus-satgas/create', [AdminKasusSatgasController::class, 'create'])
        ->name('kasus_satgas.create');
    Route::post('kasus-satgas', [AdminKasusSatgasController::class, 'store'])
        ->name('kasus_satgas.store');
    Route::get('kasus-satgas/{idKasus}/{idSatgas}', [AdminKasusSatgasController::class, 'show'])
        ->name('kasus_satgas.show');
    Route::get('kasus-satgas/{idKasus}/{idSatgas}/edit', [AdminKasusSatgasController::class, 'edit'])
        ->name('kasus_satgas.edit');
    Route::put('kasus-satgas/{idKasus}/{idSatgas}', [AdminKasusSatgasController::class, 'update'])
        ->name('kasus_satgas.update');
    Route::delete('kasus-satgas/{idKasus}/{idSatgas}', [AdminKasusSatgasController::class, 'destroy'])
        ->name('kasus_satgas.destroy');
    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');
    Route::put('/update-profil', [AdminController::class, 'updateProfil'])->name('update-profil');
    Route::put('/update-password', [AdminController::class, 'updatePassword'])->name('update-password');
    Route::put('/admin/update-profil', [AdminController::class, 'updateProfil'])->name('admin.update-profil');
    
    Route::resource('topsis', KriteriaTopsisController::class);
    Route::resource('management', AdminManagementController::class);
});

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


