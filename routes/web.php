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

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', function (Request $request) {
    return match ($request->user()->role) {
        'admin' => redirect()->route('dashboard.admin'),
        'dosen' => redirect()->route('dashboard.dosen'),
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
            abort_unless($request->user()->role === 'dosen', 403);

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

        Route::get('/beasiswa', function () {
            $scholarships = Scholarship::latest()->paginate(10);

            return view('beasiswa.katalog', compact('scholarships'));
        })->name('beasiswa.katalog');
        Route::get('/pendaftaran', fn() => view('pendaftaran.index'))->name('pendaftaran.index');
        Route::get('/pendaftaran/form', fn() => view('pendaftaran.create'))->name('pendaftaran.create');
        Route::get('/pendaftaran/show', fn() => view('pendaftaran.show'))->name('pendaftaran.show');
        Route::get('/akademik/upload-khs', fn() => view('akademik.upload-khs'))->name('akademik.upload');
        Route::get('/tracer/form', fn() => view('tracer.form'))->name('tracer.form');
    });
});

Route::prefix('beasiswa')->name('beasiswa.')->group(function () {
    Route::get('/katalog', function () {
        $scholarships = Scholarship::latest()->paginate(10);

        return view('beasiswa.katalog', compact('scholarships'));
    })->name('katalog');
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

Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', fn() => view('pendaftaran.index'))->name('index');
        Route::get('/form', fn() => view('pendaftaran.create'))->name('create');
        Route::get('/show', fn() => view('pendaftaran.show'))->name('show');
        Route::get('/upload-sk', fn() => view('pendaftaran.upload'))->name('upload');
    });
});

Route::prefix('verifikasi')->name('verifikasi.')->middleware('auth')->group(function () {
    Route::get('/awal', [ScholarshipApplicationController::class, 'dosenIndex'])->name('awal');
    Route::get('/akhir', [ScholarshipApplicationController::class, 'adminIndex'])->name('akhir');
    Route::get('/detail/{application}', [ScholarshipApplicationController::class, 'show'])->name('detail');
    Route::post('/{application}/dosen', [ScholarshipApplicationController::class, 'verifyByDosen'])->name('dosen');
    Route::post('/{application}/admin', [ScholarshipApplicationController::class, 'verifyByAdmin'])->name('admin');
});

Route::prefix('akademik')->name('akademik.')->middleware('auth')->group(function () {
    Route::get('/monitoring', function (Request $request) {
        abort_unless($request->user()->role === 'dosen', 403);

        return view('akademik.monitoring-khs');
    })->name('monitoring');

    Route::get('/upload-khs', function (Request $request) {
        abort_unless($request->user()->role === 'mahasiswa', 403);

        return view('akademik.upload-khs');
    })->name('upload');

    Route::get('/evaluasi', function (Request $request) {
        abort_unless($request->user()->role === 'admin', 403);

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['pending', 'verified', 'warning', 'revoked'])],
        ]);

        $evaluations = SemesterEvaluation::query()
            ->with(['user', 'scholarship'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('nim_nip', 'like', "%{$search}%");
                    })->orWhereHas('scholarship', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($filters['status'] ?? null, fn($query, $status) => $query->where('status', $status))
            ->orderByDesc('semester_ke')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalEvaluations = SemesterEvaluation::count();
        $safeCount = SemesterEvaluation::where('ips_score', '>=', 3.25)
            ->whereNotIn('status', ['warning', 'revoked'])
            ->count();
        $warningCount = SemesterEvaluation::where('status', '!=', 'revoked')
            ->where('ips_score', '>=', 3.00)
            ->where(function ($query) {
                $query->where('ips_score', '<', 3.25)->orWhere('status', 'warning');
            })
            ->count();
        $criticalCount = SemesterEvaluation::where(function ($query) {
            $query->where('status', 'revoked')->orWhere('ips_score', '<', 3.00);
        })->count();
        $pendingCount = SemesterEvaluation::where('status', 'pending')->count();

        return view('akademik.evaluasi', compact(
            'evaluations',
            'filters',
            'totalEvaluations',
            'safeCount',
            'warningCount',
            'criticalCount',
            'pendingCount'
        ));
    })->name('evaluasi');
});

Route::prefix('tracer')->name('tracer.')->group(function () {
    Route::get('/', fn() => view('tracer.index'))->name('index');
    Route::get('/form', function (Request $request) {
        abort_unless($request->user()->role === 'mahasiswa', 403);

        return view('tracer.form');
    })->middleware('auth')->name('form');
    Route::middleware('auth')->group(function () {
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
    Route::get('/{dosen}/advisees', [UserController::class, 'advisees'])->name('advisees');
    Route::put('/{dosen}/advisees', [UserController::class, 'updateAdvisees'])->name('advisees.update');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
});

require __DIR__.'/auth.php';
