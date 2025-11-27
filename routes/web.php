<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPengunjungController;
use App\Http\Controllers\AdminSkmController;

// ====================================================
// RUTE PENGUNJUNG (FRONT END)
// ====================================================

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
    Route::get('/layanan', [SurveyController::class, 'showLayananForm'])->name('survey.layanan'); 
    Route::get('/petugas', [SurveyController::class, 'showPetugasForm'])->name('survey.petugas'); 
    Route::post('/selesai', [SurveyController::class, 'store'])->name('survey.store');
    Route::get('/selesai', [SurveyController::class, 'thankYou'])->name('survey.thank-you');
});


// ====================================================
// RUTE ADMIN (BACK END)
// ====================================================

Route::prefix('admin')->group(function () {
    
    // Auth Routes
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Group Middleware Auth
    Route::middleware(['auth'])->group(function () {
        
        // --- DASHBOARD UTAMA ---
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // --- MANAJEMEN PENGUNJUNG ---
        Route::get('/pengunjung', [AdminPengunjungController::class, 'index'])->name('admin.pengunjung');
        Route::post('/pengunjung/batch-delete', [AdminPengunjungController::class, 'batchDelete'])->name('admin.pengunjung.batchDelete');
        Route::get('/pengunjung/edit-multiple', [AdminPengunjungController::class, 'editMultiple'])->name('admin.pengunjung.editMultiple');
        Route::post('/pengunjung/update-multiple', [AdminPengunjungController::class, 'updateMultiple'])->name('admin.pengunjung.updateMultiple');

        // --- MANAJEMEN SKM (READ - AdminSkmController) ---
        
        // 1. Tampilan Data Demografi (List Index)
        Route::get('/skm', [AdminSkmController::class, 'index'])->name('admin.skm'); // Menggunakan AdminSkmController::index
        
        // 2. Tampilan Data Jawaban/Pertanyaan (MEMPERBAIKI 405 ERROR)
        // URL yang dicoba user adalah /skm/jawaban
        Route::get('/skm/jawaban', [AdminSkmController::class, 'jawaban'])->name('admin.skm.jawaban'); 

        // --- MANAJEMEN SKM (CRUD - AdminSkmController) ---
        
        // A. CRUD dari Halaman Demografi (Default)
        Route::get('/skm/{id}/edit', [AdminSkmController::class, 'edit'])->name('admin.skm.edit'); 
        Route::put('/skm/{id}', [AdminSkmController::class, 'update'])->name('admin.skm.update');
        Route::delete('/skm/{id}', [AdminSkmController::class, 'destroy'])->name('admin.skm.delete');
        
        // B. CRUD dari Halaman Jawaban/Pertanyaan (Agar URL rapi)
        Route::get('/skm/jawaban/{id}/edit', [AdminSkmController::class, 'edit'])->name('admin.skm.jawaban.edit'); 
        Route::put('/skm/jawaban/{id}', [AdminSkmController::class, 'update'])->name('admin.skm.jawaban.update'); 
        Route::delete('/skm/jawaban/{id}', [AdminSkmController::class, 'destroy'])->name('admin.skm.jawaban.delete');

        // --- LAPORAN & DOWNLOAD ---
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
        Route::get('/laporan/download-pengunjung', [AdminController::class, 'downloadPengunjung'])->name('laporan.download_pengunjung');
        Route::get('/laporan/download-skm', [AdminController::class, 'downloadSkm'])->name('laporan.download_skm');
    });
});