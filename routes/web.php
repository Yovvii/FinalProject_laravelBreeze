<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () { 
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
// Route::get('/timeline', [TimelineController::class, 'index'])->middleware(['auth'])->name('timeline.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    Route::get('/dashboard', [PendaftaranController::class, 'showTimeline'])->name('dashboard');
    Route::post('/pendaftaran/simpan-data', [PendaftaranController::class, 'saveRegistration'])->name('save.registration');
});

require __DIR__.'/auth.php';
