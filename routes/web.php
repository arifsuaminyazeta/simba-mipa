<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// PORTAL MAHASISWA (Prefix: /mahasiswa)
// ==========================================
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.mahasiswa'))->name('dashboard');
    Route::get('/beasiswa', fn() => view('beasiswa.katalog'))->name('beasiswa.katalog');
    Route::get('/pendaftaran', fn() => view('pendaftaran.index'))->name('pendaftaran.index');
    Route::get('/pendaftaran/form', fn() => view('pendaftaran.create'))->name('pendaftaran.create');
    Route::get('/pendaftaran/show', fn() => view('pendaftaran.show'))->name('pendaftaran.show');
    Route::get('/akademik/upload-khs', fn() => view('akademik.upload-khs'))->name('akademik.upload');
    Route::get('/tracer/form', fn() => view('tracer.form'))->name('tracer.form');
});

Route::get('/dashboard', fn() => redirect()->route('mahasiswa.dashboard'))->name('dashboard');

// Alias rute dashboard
Route::get('/dashboard/mahasiswa', fn() => redirect()->route('mahasiswa.dashboard'));
Route::get('/dashboard/admin', fn() => view('dashboard.admin'))->name('admin.dashboard');
Route::get('/dashboard/dosen', fn() => view('dashboard.dosen'))->name('dosen.dashboard');

// Beasiswa (Rute Utama tanpa /demo)
Route::prefix('beasiswa')->name('beasiswa.')->group(function () {
    Route::get('/', fn() => view('beasiswa.index'))->name('index');
    Route::get('/katalog', fn() => view('beasiswa.katalog'))->name('katalog');
    Route::get('/create', fn() => view('beasiswa.create'))->name('create');
    Route::get('/edit', fn() => view('beasiswa.edit'))->name('edit');
    Route::get('/show', fn() => view('beasiswa.show'))->name('show');
});

// Pendaftaran (Rute Utama tanpa /demo)
Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::get('/', fn() => view('pendaftaran.index'))->name('index');
    Route::get('/form', fn() => view('pendaftaran.create'))->name('create');
    Route::get('/show', fn() => view('pendaftaran.show'))->name('show');
    Route::get('/upload-sk', fn() => view('pendaftaran.upload'))->name('upload');
});

// Akademik & KHS (Rute Utama tanpa /demo)
Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('/upload-khs', fn() => view('akademik.upload-khs'))->name('upload');
    Route::get('/monitoring', fn() => view('akademik.monitoring-khs'))->name('monitoring');
    Route::get('/evaluasi', fn() => view('akademik.evaluasi'))->name('evaluasi');
});

// Tracer Study (Rute Utama tanpa /demo)
Route::prefix('tracer')->name('tracer.')->group(function () {
    Route::get('/', fn() => view('tracer.index'))->name('index');        
    Route::get('/form', fn() => view('tracer.form'))->name('form');       
    Route::get('/rekap', fn() => view('tracer.rekap'))->name('rekap');   
});

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

    // Beasiswa
    Route::prefix('beasiswa')->name('beasiswa.')->group(function () {
        Route::get('/', fn() => view('beasiswa.index'))->name('index');
        Route::get('/katalog', fn() => view('beasiswa.katalog'))->name('katalog');
        Route::get('/create', fn() => view('beasiswa.create'))->name('create');
        Route::get('/edit', fn() => view('beasiswa.edit'))->name('edit');
        Route::get('/show', fn() => view('beasiswa.show'))->name('show');
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