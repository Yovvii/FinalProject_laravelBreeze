<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProgressBarController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () { 
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pendaftaran_sma', function () {
    return view('pendaftaran_sma');
})->middleware(['auth', 'verified'])->name('pendaftaran_sma.index');

Route::get('/test_field', function () { 
    return view('test_field');
})->middleware(['auth', 'verified'])->name('test_field');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/pendaftaran_sma', [SmaController::class, 'index'])->middleware(['auth'])->name('pendaftaran_sma');

Route::get('/dashboard/progress_bar', [ProgressBarController::class, 'index'])->name('progress_bar');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('logout');
    Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    Route::get('/dashboard', [PendaftaranController::class, 'showTimeline'])->name('dashboard');
    Route::post('/simpan-data', [PendaftaranController::class, 'saveRegistration'])->name('save.registration');
    Route::get('/surat_pernyataan', [DocumentController::class, 'showSuratPernyataan'])->name('surat_pernyataan');
    Route::get('/download_surat', [DocumentController::class, 'downloadPdf'])->name('download.surat.pernyataan');
    
    Route::get('/pendaftaran_sma', [SmaController::class, 'index'])->name('pendaftaran_sma');
    Route::get('/pendaftaran_sma/jalur', [SmaController::class, 'showJalurPendaftaran'])->name('jalur_pendaftaran');
    Route::get('/pendaftaran_sma/timeline', [SmaController::class, 'showTimeline'])->name('pendaftaran.sma.timeline');
    Route::post('/pendaftaran_sma/save-step', [SmaController::class, 'saveRegistration'])->name('pendaftaran.sma.save_step');
});

require __DIR__.'/auth.php';
