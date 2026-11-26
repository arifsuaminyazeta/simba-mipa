<?php

use App\Http\Controllers\AlumniTracerController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScholarshipApplicationController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\UserController;
use App\Models\Scholarship;
use App\Models\SemesterEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use App\Http\Controllers\SemesterEvaluationController;

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', function (Request $request) {
    return match ($request->user()->role) {
        'admin' => redirect()->route('dashboard.admin'),
        'dosen_pa' => redirect()->route('dashboard.dosen'),
        default => redirect()->route('dashboard.mahasiswa'),
    };
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/admin', function (Request $request) {
            abort_unless($request->user()->role === 'admin', 403);

            return view('dashboard.admin');
        })->name('admin');

        Route::get('/dosen', function (Request $request) {
            abort_unless($request->user()->role === 'dosen_pa', 403);

            return view('dashboard.dosen');
        })->name('dosen');

        Route::get('/mahasiswa', function (Request $request) {
            abort_unless($request->user()->role === 'mahasiswa', 403);

            return view('dashboard.mahasiswa');
        })->name('mahasiswa');
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', function (Request $request) {
            abort_unless($request->user()->role === 'mahasiswa', 403);

            return view('dashboard.mahasiswa');
        })->name('dashboard');

        Route::get('/beasiswa', [ScholarshipController::class, 'catalog'])->name('beasiswa.katalog');

        Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
            Route::get('/', [ScholarshipApplicationController::class, 'mahasiswaIndex'])->name('index');
            Route::get('/form', [ScholarshipApplicationController::class, 'create'])->name('create');
            Route::post('/', [ScholarshipApplicationController::class, 'store'])->name('store');
            Route::get('/show/{application}', [ScholarshipApplicationController::class, 'show'])->name('show');
            Route::get('/{application}/edit', [ScholarshipApplicationController::class, 'edit'])->name('edit');
            Route::put('/{application}', [ScholarshipApplicationController::class, 'update'])->name('update');
            Route::delete('/{application}', [ScholarshipApplicationController::class, 'destroy'])->name('destroy');
            Route::get('/{application}/upload-sk', [ScholarshipApplicationController::class, 'uploadForm'])->name('upload');
            Route::post('/{application}/upload-sk', [ScholarshipApplicationController::class, 'uploadAcceptanceProof'])->name('upload-sk.store');
            Route::get('/{application}/rekomendasi', [ScholarshipApplicationController::class, 'downloadRecommendation'])->name('recommendation');
        });
        Route::get('/akademik/upload-khs', [SemesterEvaluationController::class, 'create'])->name('akademik.upload');
        Route::get('/tracer/form', [AlumniTracerController::class, 'create'])->name('tracer.form');
    });
});

Route::prefix('beasiswa')->name('beasiswa.')->group(function () {
    Route::get('/katalog', [ScholarshipController::class, 'catalog'])->name('katalog');
    Route::get('/show/{scholarship?}', [ScholarshipController::class, 'show'])->name('show');

    Route::middleware('auth')->group(function () {
        Route::get('/', [ScholarshipController::class, 'index'])->name('index');
        Route::get('/create', [ScholarshipController::class, 'create'])->name('create');
        Route::post('/', [ScholarshipController::class, 'store'])->name('store');
        Route::get('/{scholarship}/edit', [ScholarshipController::class, 'edit'])->name('edit');
        Route::put('/{scholarship}', [ScholarshipController::class, 'update'])->name('update');
        Route::delete('/{scholarship}', [ScholarshipController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('pendaftaran')->name('pendaftaran.')->middleware('auth')->group(function () {
    Route::get('/', [ScholarshipApplicationController::class, 'mahasiswaIndex'])->name('index');
    Route::get('/form', [ScholarshipApplicationController::class, 'create'])->name('create');
    Route::post('/', [ScholarshipApplicationController::class, 'store'])->name('store');
    Route::get('/show/{application}', [ScholarshipApplicationController::class, 'show'])->name('show');
    Route::get('/{application}/edit', [ScholarshipApplicationController::class, 'edit'])->name('edit');
    Route::put('/{application}', [ScholarshipApplicationController::class, 'update'])->name('update');
    Route::delete('/{application}', [ScholarshipApplicationController::class, 'destroy'])->name('destroy');
    Route::get('/{application}/upload-sk', [ScholarshipApplicationController::class, 'uploadForm'])->name('upload');
    Route::post('/{application}/upload-sk', [ScholarshipApplicationController::class, 'uploadAcceptanceProof'])->name('upload-sk.store');
    Route::get('/{application}/rekomendasi', [ScholarshipApplicationController::class, 'downloadRecommendation'])->name('recommendation');
});

Route::prefix('verifikasi')->name('verifikasi.')->middleware('auth')->group(function () {
    Route::get('/awal', [ScholarshipApplicationController::class, 'dosenIndex'])->name('awal');
    Route::get('/akhir', [ScholarshipApplicationController::class, 'adminIndex'])->name('akhir');
    Route::get('/detail/{application}', [ScholarshipApplicationController::class, 'show'])->name('detail');
    Route::post('/{application}/dosen', [ScholarshipApplicationController::class, 'verifyByDosen'])->name('dosen');
    Route::post('/{application}/admin', [ScholarshipApplicationController::class, 'verifyByAdmin'])->name('admin');
});

Route::prefix('akademik')->name('akademik.')->middleware('auth')->group(function () {
    Route::get('/monitoring', [SemesterEvaluationController::class, 'monitoring'])->name('monitoring');
    Route::get('/upload-khs', [SemesterEvaluationController::class, 'create'])->name('upload');
    Route::post('/upload-khs', [SemesterEvaluationController::class, 'store'])->name('store');
    Route::post('/evaluasi/{evaluation}/verifikasi', [SemesterEvaluationController::class, 'verify'])->name('verify');
    Route::get('/evaluasi', [SemesterEvaluationController::class, 'index'])->name('evaluasi');
});

Route::prefix('tracer')->name('tracer.')->group(function () {
    Route::get('/', [AlumniTracerController::class, 'publicIndex'])->name('index');
    Route::middleware('auth')->group(function () {
        Route::get('/form', [AlumniTracerController::class, 'create'])->name('form');
        Route::post('/form', [AlumniTracerController::class, 'store'])->name('store');
        Route::get('/rekap/export', [AlumniTracerController::class, 'export'])->name('rekap.export');
        Route::get('/rekap', [AlumniTracerController::class, 'index'])->name('rekap');
    });
});

Route::prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');

    Route::middleware('auth')->group(function () {
        Route::get('/manage', [AnnouncementController::class, 'manage'])->name('manage');
        Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
        Route::post('/', [AnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
        Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('users')->name('users.')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/students/{student}/edit', [UserController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{student}', [UserController::class, 'updateStudent'])->name('students.update');
    Route::get('/{dosen}/advisees', [UserController::class, 'advisees'])->name('advisees');
    Route::put('/{dosen}/advisees', [UserController::class, 'updateAdvisees'])->name('advisees.update');
    Route::patch('/{user}/academic-status', [UserController::class, 'updateAcademicStatus'])->name('academic-status.update');
    Route::patch('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggle-active');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
});

Route::prefix('demo')->name('demo.')->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/admin', fn () => view('dashboard.admin'))->name('admin');
        Route::get('/dosen', fn () => view('dashboard.dosen'))->name('dosen');
        Route::get('/mahasiswa', fn () => view('dashboard.mahasiswa'))->name('mahasiswa');
    });

    Route::prefix('beasiswa')->name('beasiswa.')->group(function () {
        Route::get('/', fn () => view('beasiswa.index'))->name('index');
        Route::get('/katalog', fn () => view('beasiswa.katalog'))->name('katalog');
        Route::get('/create', fn () => view('beasiswa.create'))->name('create');
        Route::get('/edit', fn () => view('beasiswa.edit'))->name('edit');
        Route::get('/show', fn () => view('beasiswa.show'))->name('show');
    });

    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', fn () => view('pendaftaran.index'))->name('index');
        Route::get('/form', fn () => view('pendaftaran.create'))->name('create');
        Route::get('/show', fn () => view('pendaftaran.show'))->name('show');
        Route::get('/upload-sk', fn () => view('pendaftaran.upload'))->name('upload');
    });

    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/awal', fn () => view('verifikasi.awal'))->name('awal');
        Route::get('/akhir', fn () => view('verifikasi.akhir'))->name('akhir');
        Route::get('/detail', fn () => view('verifikasi.detail'))->name('detail');
    });

    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::get('/monitoring', fn () => view('akademik.monitoring-khs'))->name('monitoring');
        Route::get('/upload-khs', fn () => view('akademik.upload-khs'))->name('upload');
        Route::get('/evaluasi', fn () => view('akademik.evaluasi'))->name('evaluasi');
    });

    Route::prefix('tracer')->name('tracer.')->group(function () {
        Route::get('/', fn () => view('tracer.index'))->name('index');
        Route::get('/form', fn () => view('tracer.form'))->name('form');
        Route::get('/rekap', fn () => view('tracer.rekap'))->name('rekap');
    });

    Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', fn () => view('announcements.index'))->name('index');
        Route::get('/create', fn () => view('announcements.create'))->name('create');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', fn () => view('users.index'))->name('index');
        Route::get('/create', fn () => view('users.create'))->name('create');
    });
});

require __DIR__.'/auth.php';