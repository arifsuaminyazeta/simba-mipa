<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\ScholarshipApplicationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.mahasiswa');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('demo')->name('demo.')->group(function () {

    // Dashboard 
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/admin', fn() => view('dashboard.admin'))->name('admin');
        Route::get('/dosen', fn() => view('dashboard.dosen'))->name('dosen');
        Route::get('/mahasiswa', fn() => view('dashboard.mahasiswa'))->name('mahasiswa');
    });

   Route::prefix('demo')->name('demo.')->group(function () {

    Route::prefix('beasiswa')->name('beasiswa.')->group(function () {

        Route::get('/', [ScholarshipController::class, 'index'])->name('index');
        Route::get('/create', [ScholarshipController::class, 'create'])->name('create');
        Route::post('/', [ScholarshipController::class, 'store'])->name('store');

        Route::get('/{scholarship}/edit', [ScholarshipController::class, 'edit'])->name('edit');
        Route::get('/{scholarship}', [ScholarshipController::class, 'show'])->name('show');

        Route::put('/{scholarship}', [ScholarshipController::class, 'update'])->name('update');
        Route::delete('/{scholarship}', [ScholarshipController::class, 'destroy'])->name('destroy');

    });

    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {

        Route::get('/awal', [ScholarshipApplicationController::class, 'dosenIndex'])->name('awal');
        Route::get('/akhir', [ScholarshipApplicationController::class, 'adminIndex'])->name('akhir');

        Route::get('/detail/{application}', [ScholarshipApplicationController::class, 'show'])->name('detail');

        Route::post('/{application}/dosen', [ScholarshipApplicationController::class, 'verifyByDosen'])->name('dosen');
        Route::post('/{application}/admin', [ScholarshipApplicationController::class, 'verifyByAdmin'])->name('admin');

    });

});

    // Pendaftaran 
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', fn() => view('pendaftaran.index'))->name('index');
        Route::get('/form', fn() => view('pendaftaran.create'))->name('create');
        Route::get('/show', fn() => view('pendaftaran.show'))->name('show');
        Route::get('/upload-sk', fn() => view('pendaftaran.upload'))->name('upload');
    });

    // Verifikasi Berkas
    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/awal', fn() => view('verifikasi.awal'))->name('awal'); // Dosen PA
        Route::get('/akhir', fn() => view('verifikasi.akhir'))->name('akhir'); // Admin
        Route::get('/detail', fn() => view('verifikasi.detail'))->name('detail');
    });

    // Akademik & EWS (Monitoring & Upload KHS)
    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::get('/monitoring', fn() => view('akademik.monitoring-khs'))->name('monitoring');
        Route::get('/upload-khs', fn() => view('akademik.upload-khs'))->name('upload');
        Route::get('/evaluasi', fn() => view('akademik.evaluasi'))->name('evaluasi');
    });

    // Tracer Study
    Route::prefix('tracer')->name('tracer.')->group(function () {
        Route::get('/', fn() => view('tracer.index'))->name('index');        
        Route::get('/form', fn() => view('tracer.form'))->name('form');       
        Route::get('/rekap', fn() => view('tracer.rekap'))->name('rekap');   
    });

    // Pengumuman
    Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', fn() => view('announcements.index'))->name('index');
        Route::get('/create', fn() => view('announcements.create'))->name('create');
    });

    // Manajemen User
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', fn() => view('users.index'))->name('index');
        Route::get('/create', fn() => view('users.create'))->name('create');
    });
    
});

require __DIR__.'/auth.php';