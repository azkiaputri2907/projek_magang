<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPengunjungController;
use App\Http\Controllers\AdminSkmController;


// --- Rute Pengunjung (Sesuai Blade yang Dibuat) ---

// Halaman Awal
Route::get('/', [PengunjungController::class, 'onboard'])->name('onboard');

// Buku Tamu
Route::prefix('buku-tamu')->group(function () {
    Route::get('/', [PengunjungController::class, 'dashboard'])->name('buku-tamu.dashboard');
    Route::get('/isi', [PengunjungController::class, 'showForm'])->name('buku-tamu.form');
    Route::post('/terima-kasih', [PengunjungController::class, 'store'])->name('buku-tamu.store');
    Route::get('/terima-kasih', [PengunjungController::class, 'thankYou'])->name('buku-tamu.thank-you');
});

// Survei Kepuasan (SKM)
Route::prefix('survey')->group(function () {
    Route::get('/ajakan', [SurveyController::class, 'ajakan'])->name('survey.ajakan');
    Route::get('/data-diri', [SurveyController::class, 'showDataDiriForm'])->name('survey.data-diri');
    Route::get('/layanan', [SurveyController::class, 'showLayananForm'])->name('survey.layanan'); // Form Bagian 2
    Route::get('/petugas', [SurveyController::class, 'showPetugasForm'])->name('survey.petugas'); // Form Bagian 3
    Route::post('/selesai', [SurveyController::class, 'store'])->name('survey.store');
    Route::get('/selesai', [SurveyController::class, 'thankYou'])->name('survey.thank-you');
});


// --- Rute Admin ---
Route::prefix('admin')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/pengunjung', [AdminPengunjungController::class, 'index'])->name('admin.pengunjung');

        // Batch actions
        Route::post('/pengunjung/batch-delete', [AdminPengunjungController::class, 'batchDelete'])->name('pengunjung.batchDelete');
        Route::get('/pengunjung/edit-multiple', [AdminPengunjungController::class, 'editMultiple'])->name('pengunjung.editMultiple');
        Route::post('/pengunjung/update-multiple', [AdminPengunjungController::class, 'updateMultiple'])->name('pengunjung.updateMultiple');
    });

    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Group Rute yang memerlukan autentikasi
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/pengunjung', [AdminController::class, 'dataPengunjung'])->name('admin.pengunjung');

        Route::get('/skm', [AdminController::class, 'dataSkmDemografi'])->name('admin.skm');
        Route::get('/skm/pertanyaan', [AdminController::class, 'dataSkmPertanyaan'])->name('admin.skm.pertanyaan');

// === DATA SKM: EDIT & DELETE (Menggunakan AdminSkmController) ===
        // Untuk Edit/Update
        Route::get('/skm/{id}/edit', [AdminSkmController::class, 'edit'])->name('admin.skm.edit'); 
        Route::put('/skm/{id}', [AdminSkmController::class, 'update'])->name('admin.skm.update');
        // Untuk Hapus
        Route::delete('/skm/{id}', [AdminSkmController::class, 'destroy'])->name('admin.skm.delete');
        
        // Anda juga perlu mengarahkan rute edit/delete di dataSkmPertanyaan ke controller baru ini:
        Route::get('/skm/jawaban/{id}/edit', [AdminSkmController::class, 'edit'])->name('admin.skm.jawaban.edit'); 
        Route::put('/skm/jawaban/{id}', [AdminSkmController::class, 'update'])->name('admin.skm.jawaban.update'); 
        Route::delete('/skm/jawaban/{id}', [AdminSkmController::class, 'destroy'])->name('admin.skm.jawaban.delete');

        Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
        // Rute unduh Laporan ke Google Sheets
        Route::get('/laporan/unduh/pengunjung', [AdminController::class, 'downloadPengunjung'])->name('admin.download.pengunjung');
        Route::get('/laporan/unduh/skm', [AdminController::class, 'downloadSkm'])->name('admin.download.skm');
    });
});