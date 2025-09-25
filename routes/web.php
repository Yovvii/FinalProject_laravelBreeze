<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmaController;
use App\Http\Middleware\IsAdminSekolah;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProgressBarController;
use App\Http\Controllers\AdminSekolahController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk super admin
Route::get('/superadmin/login', [SuperAdminController::class, 'showLoginForm'])->name('superadmin.login.form');
Route::post('/superadmin/login', [SuperAdminController::class, 'login'])->name('superadmin.login');
Route::middleware(['is_super_admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super_admin.dashboard');
    Route::get('/data-sma', [SuperAdminController::class, 'dataSma'])->name('super_admin.data_sma');
    Route::get('/data-sma/tambah', [SuperAdminController::class, 'createSma'])->name('super_admin.sma.create');
    Route::get('/data-sma/{sma}/edit', [SuperAdminController::class, 'editSma'])->name('super_admin.sma.edit');
    Route::put('/data-sma/{sma}', [SuperAdminController::class, 'updateSma'])->name('super_admin.sma.update');
    Route::delete('/data-sma/{sma}', [SuperAdminController::class, 'updateSma'])->name('super_admin.sma.destroy');
    Route::post('/data-sekolah', [SuperAdminController::class, 'storeSma'])->name('super_admin.sma.store');

    Route::get('/data-admin-sekolah', [SuperAdminController::class, 'dataAdminSekolah'])->name('super_admin.data_admin_sekolah');
});

// Grup rute untuk Admin Sekolah
Route::get('/admin/login', [AdminSekolahController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminSekolahController::class, 'login']);
Route::middleware([IsAdminSekolah::class])->group(function () {
    Route::get('/admin/dashboard', [AdminSekolahController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/sertifikat-murid', [AdminSekolahController::class, 'showSertifikatMurid'])->name('admin.sertifikat_murid');
    Route::post('/admin/verifikasi_sertifikat/{siswa}', [AdminSekolahController::class, 'verifikasiSertifikat'])->name('admin.verifikasi_sertifikat');
    Route::get('/admin/jalur-pendaftaran', [AdminSekolahController::class, 'showJalurIndex'])->name('admin.jalur_pendaftaran.index');
    Route::get('/admin/jalur-pendaftaran/{jalur_id}', [AdminSekolahController::class, 'showStudentsByJalur'])->name('admin.jalur_pendaftaran.show');
});

Route::get('/dashboard/test', [SmaController::class, 'testField'])->name('test_field');
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
    Route::post('/pendaftaran_sma/simpan-jalur', [SmaController::class, 'saveJalurPendaftaran'])->name('pendaftaran.sma.saveJalur');
    Route::get('/pendaftaran_sma/timeline', [SmaController::class, 'showTimeline'])->name('pendaftaran.sma.timeline');

    Route::get('/pendaftaran_sma/resume', [SmaController::class, 'showResume'])->name('resume');
    Route::post('/pendaftaran_sma/save-step', [SmaController::class, 'savePendaftaran'])->name('pendaftaran.sma.save_step');
});

require __DIR__.'/auth.php';
