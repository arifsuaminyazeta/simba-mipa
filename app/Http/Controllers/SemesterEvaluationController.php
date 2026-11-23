<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\SemesterEvaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SemesterEvaluationController extends Controller
{
    private const WARNING_MARGIN = 0.25;
    
    public function create(Request $request)
    {
        $user = $request->user();
        abort_unless($user->role === 'mahasiswa', 403);

        $scholarship = $this->activeScholarship($user);

        $evaluations = $user->semesterEvaluations()
            ->with('scholarship')
            ->orderByDesc('semester_ke')
            ->get();

        $latest = $evaluations->first();

        $blockReason = null;
        if (! $user->is_awardee) {
            $blockReason = 'Unggah KHS hanya untuk mahasiswa penerima beasiswa (awardee).';
        } elseif ($user->academic_status === 'lulus') {
            $blockReason = 'Status akademik Anda sudah lulus, pelaporan KHS dikunci.';
        } elseif (! $scholarship) {
            $blockReason = 'Data beasiswa aktif Anda belum ditemukan. Hubungi admin.';
        }

        return view('akademik.upload-khs', compact('scholarship', 'evaluations', 'latest', 'blockReason'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        abort_unless($user->role === 'mahasiswa' && $user->is_awardee, 403);

        if ($user->academic_status === 'lulus') {
            return back()->withErrors(['semester_ke' => 'Status akademik lulus, pelaporan KHS dikunci.']);
        }

        $scholarship = $this->activeScholarship($user);

        if (! $scholarship) {
            return back()->withErrors(['semester_ke' => 'Data beasiswa aktif Anda belum ditemukan.']);
        }

        $data = $request->validate([
            'semester_ke' => ['required', 'integer', 'between:1,14'],
            'ips_score' => ['required', 'numeric', 'between:0,4'],
            'ipk_score' => ['required', 'numeric', 'between:0,4'],
            'khs_file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        $sudahAda = SemesterEvaluation::where('user_id', $user->id)
            ->where('scholarship_id', $scholarship->id)
            ->where('semester_ke', $data['semester_ke'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withErrors(['semester_ke' => 'KHS semester ini sudah pernah dilaporkan untuk beasiswa tersebut.'])
                ->withInput();
        }

        SemesterEvaluation::create([
            'user_id' => $user->id,
            'scholarship_id' => $scholarship->id,
            'semester_ke' => $data['semester_ke'],
            'ips_score' => $data['ips_score'],
            'ipk_score' => $data['ipk_score'],
            'khs_file' => $request->file('khs_file')->store('khs', 'public'),
            'verification_status' => 'pending',
            'ews_status' => $this->calculateEws((float) $data['ipk_score'], (float) $scholarship->min_gpa),
        ]);

        return redirect()->route('akademik.upload')->with('success', 'KHS berhasil dikirim dan menunggu verifikasi Dosen PA.');
    }

    public function monitoring(Request $request)
    {
        $user = $request->user();
        abort_unless($user->role === 'dosen_pa', 403);

        $base = SemesterEvaluation::whereHas(
            'user',
            fn ($query) => $query->where('dosen_pa_id', $user->id)
        );

        $evaluations = (clone $base)
            ->with(['user', 'scholarship'])
            ->orderByDesc('semester_ke')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $safeCount = (clone $base)->where('ews_status', 'aman')->count();
        $warningCount = (clone $base)->where('ews_status', 'warning')->count();
        $criticalCount = (clone $base)->whereIn('ews_status', ['kritis', 'revoked'])->count();
        $totalCount = (clone $base)->count();

        return view('akademik.monitoring-khs', compact(
            'evaluations',
            'safeCount',
            'warningCount',
            'criticalCount',
            'totalCount'
        ));
    }

    public function verify(Request $request, SemesterEvaluation $evaluation)
    {
        $user = $request->user();
        abort_unless($user->role === 'dosen_pa', 403);
        abort_unless($evaluation->user?->dosen_pa_id === $user->id, 403);

        $data = $request->validate([
            'decision' => ['required', Rule::in(['verify', 'revision'])],
            'evaluator_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $evaluation->update([
            'verification_status' => $data['decision'] === 'verify' ? 'verified' : 'revision',
            'evaluator_notes' => $data['evaluator_notes'] ?? null,
        ]);

        return redirect()->route('akademik.monitoring')->with('success', 'Verifikasi KHS berhasil disimpan.');
    }

    public function index(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'verification_status' => ['nullable', Rule::in(['pending', 'verified', 'revision'])],
            'ews_status' => ['nullable', Rule::in(['aman', 'warning', 'kritis', 'revoked'])],
            'semester_ke' => ['nullable', 'integer', 'between:1,14'],
            'scholarship_id' => ['nullable', 'integer'],
            'major' => ['nullable', 'string', 'max:50'],
        ]);

        $evaluations = SemesterEvaluation::query()
            ->with(['user', 'scholarship'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%")
                            ->orWhere('nim_nip', 'ilike', "%{$search}%");
                    })->orWhereHas('scholarship', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%");
                    });
                });
            })
            ->when($filters['verification_status'] ?? null, fn ($q, $v) => $q->where('verification_status', $v))
            ->when($filters['ews_status'] ?? null, fn ($q, $v) => $q->where('ews_status', $v))
            ->when($filters['semester_ke'] ?? null, fn ($q, $v) => $q->where('semester_ke', $v))
            ->when($filters['scholarship_id'] ?? null, fn ($q, $v) => $q->where('scholarship_id', $v))
            ->when($filters['major'] ?? null, fn ($q, $v) => $q->whereHas('user', fn ($u) => $u->where('major', $v)))
            ->orderByDesc('semester_ke')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalEvaluations = SemesterEvaluation::count();
        $safeCount = SemesterEvaluation::where('ews_status', 'aman')->count();
        $warningCount = SemesterEvaluation::where('ews_status', 'warning')->count();
        $criticalCount = SemesterEvaluation::whereIn('ews_status', ['kritis', 'revoked'])->count();
        $pendingCount = SemesterEvaluation::where('verification_status', 'pending')->count();

        $scholarships = Scholarship::orderBy('name')->get(['id', 'name']);
        $majors = ['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'];

        return view('akademik.evaluasi', compact(
            'evaluations',
            'filters',
            'scholarships',
            'majors',
            'totalEvaluations',
            'safeCount',
            'warningCount',
            'criticalCount',
            'pendingCount'
        ));
    }

    private function calculateEws(float $ipk, float $minGpa): string
    {
        if (round($ipk, 2) < round($minGpa, 2)) {
            return 'kritis';
        }

        if (round($ipk, 2) < round($minGpa + self::WARNING_MARGIN, 2)) {
            return 'warning';
        }

        return 'aman';
    }

    private function activeScholarship(User $user): ?Scholarship
    {
        return ScholarshipApplication::with('scholarship')
            ->where('user_id', $user->id)
            ->where('status', 'awardee_confirmed')
            ->latest()
            ->first()
            ?->scholarship
            ?? $user->semesterEvaluations()->with('scholarship')->latest()->first()?->scholarship;
    }
}