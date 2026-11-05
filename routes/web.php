<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumniTracerController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\SemesterEvaluation;


Route::get('/', function () {
    return view('welcome');
});

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
});

// Dashboard
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
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
    Route::get('/evaluasi', function (Request $request) {
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
                $query->where('ips_score', '<', 3.25)
                    ->orWhere('status', 'warning');
            })
            ->count();
        $criticalCount = SemesterEvaluation::where(function ($query) {
            $query->where('status', 'revoked')
                ->orWhere('ips_score', '<', 3.00);
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

// Tracer Study
Route::prefix('tracer')->name('tracer.')->group(function () {
    Route::get('/', fn() => view('tracer.index'))->name('index');        
    Route::get('/form', fn() => view('tracer.form'))->name('form');       
    Route::get('/rekap/export', [AlumniTracerController::class, 'export'])->name('rekap.export');
    Route::get('/rekap', [AlumniTracerController::class, 'index'])->name('rekap');
});

// Pengumuman
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

// Manajemen User
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