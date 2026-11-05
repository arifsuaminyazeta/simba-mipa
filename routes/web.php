<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;


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

// Dashboard 
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/admin', fn() => view('dashboard.admin'))->name('admin');
    Route::get('/dosen', fn() => view('dashboard.dosen'))->name('dosen');
    Route::get('/mahasiswa', fn() => view('dashboard.mahasiswa'))->name('mahasiswa');
});

// Beasiswa
Route::prefix('beasiswa')->name('beasiswa.')->group(function () {

    // Daftar Beasiswa
    Route::get('/', function () {
        $scholarships = Scholarship::latest()->paginate(10);

        return view('beasiswa.index', compact('scholarships'));
    })->name('index');

    // Katalog Beasiswa
    Route::get('/katalog', function () {
        $scholarships = Scholarship::latest()->paginate(10);

        return view('beasiswa.katalog', compact('scholarships'));
    })->name('katalog');

    // Tambah Beasiswa
    Route::get('/create', fn() => view('beasiswa.create'))
        ->name('create');

    // Edit Beasiswa
    Route::get('/edit', fn() => view('beasiswa.edit'))
        ->name('edit');

    // Detail Beasiswa
    Route::get('/show', fn() => view('beasiswa.show'))
        ->name('show');
});

// Pendaftaran 
Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::get('/', fn() => view('pendaftaran.index'))->name('index');
    Route::get('/form', fn() => view('pendaftaran.create'))->name('create');
    Route::get('/show', fn() => view('pendaftaran.show'))->name('show');
    Route::get('/upload-sk', fn() => view('pendaftaran.upload'))->name('upload');
});
/*
|--------------------------------------------------------------------------
| Verifikasi Berkas
|--------------------------------------------------------------------------
*/

Route::prefix('verifikasi')->name('verifikasi.')->group(function () {

    // Verifikasi Dosen PA
    Route::get('/awal', function () {

        $applications = \App\Models\ScholarshipApplication::with(['user', 'scholarship'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        $countPending = \App\Models\ScholarshipApplication::where('status', 'pending')->count();

        $countApproved = \App\Models\ScholarshipApplication::where('status', 'verified_by_dosen')->count();

        $countRejected = \App\Models\ScholarshipApplication::where('status', 'rejected_by_dosen')->count();

        return view('verifikasi.awal', compact(
            'applications',
            'countPending',
            'countApproved',
            'countRejected'
        ));

    })->name('awal');


    // Verifikasi Admin
    Route::get('/akhir', function () {

        $applications = \App\Models\ScholarshipApplication::with(['user', 'scholarship'])
            ->where('status', 'verified_by_dosen')
            ->latest()
            ->paginate(10);

        // Statistik verifikasi admin
        $countPending = \App\Models\ScholarshipApplication::where('status', 'verified_by_dosen')->count();

        $countApproved = \App\Models\ScholarshipApplication::where('status', 'approved_by_admin')->count();

        $countRejected = \App\Models\ScholarshipApplication::where('status', 'rejected_by_admin')->count();

        return view('verifikasi.akhir', compact(
            'applications',
            'countPending',
            'countApproved',
            'countRejected'
        ));

    })->name('akhir');


    // Detail Verifikasi
    Route::get('/detail/{application}', function ($application) {

        $application = \App\Models\ScholarshipApplication::with(['user', 'scholarship'])
            ->findOrFail($application);

        return view('verifikasi.detail', compact('application'));

    })->name('detail');

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

require __DIR__.'/auth.php';