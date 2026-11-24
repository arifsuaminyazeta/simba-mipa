<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ScholarshipApplicationController extends Controller
{
    public function mahasiswaIndex(Request $request)
    {
        abort_unless($request->user()?->role === 'mahasiswa', 403);

        $applications = ScholarshipApplication::with('scholarship')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('pendaftaran.index', compact('applications'));
    }

    public function create(Request $request)
    {
        abort_unless($request->user()?->role === 'mahasiswa', 403);

        $scholarships = $this->openScholarships();
        $latestEvaluation = $request->user()->semesterEvaluations()->latest('semester_ke')->first();
        $latestGpa = $latestEvaluation?->ipk_score;

        return view('pendaftaran.create', compact('scholarships', 'latestEvaluation', 'latestGpa'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        abort_unless($user?->role === 'mahasiswa', 403);

        $data = $request->validate([
            'scholarship_id' => ['required', 'exists:scholarships,id'],
            'gpa_score' => ['nullable', 'numeric', 'between:0,4'],
            'document_file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'statement_file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'motivation_file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'declaration' => ['accepted'],
        ]);

        $scholarship = Scholarship::findOrFail($data['scholarship_id']);
        $gpaScore = $this->validateEligibility($user, $scholarship, $data['gpa_score'] ?? null);

        ScholarshipApplication::create([
            'user_id' => $user->id,
            'scholarship_id' => $scholarship->id,
            'gpa_score' => $gpaScore,
            'document_file' => $request->file('document_file')->store('applications', 'public'),
            'statement_file' => $request->file('statement_file')->store('applications', 'public'),
            'motivation_file' => $request->file('motivation_file')->store('applications', 'public'),
            'status' => 'pending',
        ]);

        return redirect()->route('pendaftaran.index')->with('success', 'Pengajuan beasiswa berhasil dikirim.');
    }

    public function edit(Request $request, ScholarshipApplication $application)
    {
        $this->authorizeStudentApplication($request, $application);
        abort_unless($application->status === 'pending', 422);

        $scholarships = $this->openScholarships();
        $latestEvaluation = $request->user()->semesterEvaluations()->latest('semester_ke')->first();
        $latestGpa = $latestEvaluation?->ipk_score;

        return view('pendaftaran.create', compact('application', 'scholarships', 'latestEvaluation', 'latestGpa'));
    }

    public function update(Request $request, ScholarshipApplication $application)
    {
        $user = $this->authorizeStudentApplication($request, $application);
        abort_unless($application->status === 'pending', 422);

        $data = $request->validate([
            'scholarship_id' => ['required', 'exists:scholarships,id'],
            'gpa_score' => ['nullable', 'numeric', 'between:0,4'],
            'document_file' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'statement_file' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'motivation_file' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'declaration' => ['accepted'],
        ]);

        $scholarship = Scholarship::findOrFail($data['scholarship_id']);
        $gpaScore = $this->validateEligibility($user, $scholarship, $data['gpa_score'] ?? null, $application);

        $payload = [
            'scholarship_id' => $scholarship->id,
            'gpa_score' => $gpaScore,
        ];

        foreach (['document_file', 'statement_file', 'motivation_file'] as $field) {
            if ($request->hasFile($field)) {
                if ($application->{$field}) {
                    Storage::disk('public')->delete($application->{$field});
                }

                $payload[$field] = $request->file($field)->store('applications', 'public');
            }
        }

        $application->update($payload);

        return redirect()->route('pendaftaran.show', $application)->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(Request $request, ScholarshipApplication $application)
    {
        $this->authorizeStudentApplication($request, $application);
        abort_unless($application->status === 'pending', 422);

        foreach (['document_file', 'statement_file', 'motivation_file'] as $field) {
            if ($application->{$field}) {
                Storage::disk('public')->delete($application->{$field});
            }
        }

        $application->delete();

        return redirect()->route('pendaftaran.index')->with('success', 'Pengajuan beasiswa berhasil dibatalkan.');
    }

    public function uploadForm(Request $request, ScholarshipApplication $application)
    {
        $this->authorizeStudentApplication($request, $application);
        abort_unless($application->status === 'approved_by_admin', 422);

        return view('pendaftaran.upload', compact('application'));
    }

    public function uploadAcceptanceProof(Request $request, ScholarshipApplication $application)
    {
        $this->authorizeStudentApplication($request, $application);
        abort_unless($application->status === 'approved_by_admin', 422);

        $data = $request->validate([
            'acceptance_proof_file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        $application->update([
            'acceptance_proof_file' => $request->file('acceptance_proof_file')
                ->store('acceptance-proofs', 'public'),
            'status' => 'loa_submitted',
        ]);

        return redirect()->route('pendaftaran.index')->with('success', 'LoA/SK berhasil diunggah.');
    }

    public function dosenIndex(Request $request)
    {
        abort_unless($request->user()?->role === 'dosen_pa', 403);

        $dosenId = $request->user()->id;

        $baseQuery = ScholarshipApplication::whereHas(
            'user',
            fn($query) => $query->where('dosen_pa_id', $dosenId)
        );

        $applications = (clone $baseQuery)
            ->with(['user', 'scholarship'])
            ->where('status', 'pending')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', fn($query) => $query->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $countPending = (clone $baseQuery)->where('status', 'pending')->count();
        $countVerified = (clone $baseQuery)->where('status', 'verified_by_dosen')->count();
        $countRejected = (clone $baseQuery)->where('status', 'rejected_by_dosen')->count();

        return view('verifikasi.awal', compact('applications', 'countPending', 'countVerified', 'countRejected'));
    }

    public function adminIndex(Request $request)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $search = $request->search;
        $recommendationApplications = ScholarshipApplication::with(['user', 'scholarship'])
            ->where('status', 'verified_by_dosen')
            ->when($search, fn ($query, $term) => $query->whereHas('user', fn ($query) => $query->where('name', 'like', "%{$term}%")))
            ->latest()
            ->paginate(10, ['*'], 'recommendations_page')
            ->withQueryString();

        $loaApplications = ScholarshipApplication::with(['user', 'scholarship'])
            ->where('status', 'loa_submitted')
            ->when($search, fn ($query, $term) => $query->whereHas('user', fn ($query) => $query->where('name', 'like', "%{$term}%")))
            ->latest()
            ->paginate(10, ['*'], 'loa_page')
            ->withQueryString();

        $countPending = ScholarshipApplication::whereIn('status', ['verified_by_dosen', 'loa_submitted'])->count();
        $countApproved = ScholarshipApplication::whereIn('status', ['approved_by_admin', 'awardee_confirmed'])->count();
        $countRejected = ScholarshipApplication::where('status', 'rejected_by_admin')->count();

        return view('verifikasi.akhir', compact(
            'recommendationApplications',
            'loaApplications',
            'countPending',
            'countApproved',
            'countRejected'
        ));
    }

    public function show(Request $request, ScholarshipApplication $application)
    {
        $user = $request->user();
        abort_unless(in_array($user?->role, ['admin', 'dosen_pa', 'mahasiswa'], true), 403);

        $application->load(['user', 'scholarship']);

        if ($user->role === 'mahasiswa') {
            abort_unless($application->user_id === $user->id, 403);

            return view('pendaftaran.show', compact('application'));
        }

        if ($user->role === 'dosen_pa') {
            abort_unless($application->user?->dosen_pa_id === $user->id, 403);
        }

        return view('verifikasi.detail', compact('application'));
    }

    public function verifyByDosen(Request $request, ScholarshipApplication $application)
    {
        $user = $request->user();
        abort_unless($user?->role === 'dosen_pa', 403);
        abort_unless($application->user?->dosen_pa_id === $user->id, 403);
        abort_unless($application->status === 'pending', 422);

        $data = $request->validate([
            'decision' => ['required', Rule::in(['verify', 'reject'])],
            'dosen_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $application->update([
            'status' => $data['decision'] === 'verify' ? 'verified_by_dosen' : 'rejected_by_dosen',
            'dosen_notes' => $data['dosen_notes'] ?? null,
        ]);

        return redirect()->route('verifikasi.awal')->with('success', 'Verifikasi Dosen PA berhasil disimpan.');
    }

    public function verifyByAdmin(Request $request, ScholarshipApplication $application)
    {
        abort_unless($request->user()?->role === 'admin', 403);
        abort_unless(in_array($application->status, ['verified_by_dosen', 'loa_submitted'], true), 422);

        $data = $request->validate([
            'decision' => ['required', Rule::in(['approve', 'reject'])],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
            'recommendation_letter_file' => [
                $application->status === 'verified_by_dosen' && $request->input('decision') === 'approve' ? 'required' : 'nullable',
                'file',
                'mimes:pdf',
                'max:2048',
            ],
        ]);

        if ($application->status === 'verified_by_dosen') {
            $payload = [
                'status' => $data['decision'] === 'approve' ? 'approved_by_admin' : 'rejected_by_admin',
                'admin_notes' => $data['admin_notes'] ?? null,
            ];

            if ($data['decision'] === 'approve') {
                $payload['recommendation_letter_file'] = $request->file('recommendation_letter_file')
                    ->store('recommendations', 'public');
            }

            $application->update($payload);
        } else {
            if ($data['decision'] === 'approve') {
                if (! $application->acceptance_proof_file) {
                    return back()->withErrors(['decision' => 'Bukti kelolosan (LoA/SK) belum diunggah.']);
                }

                DB::transaction(function () use ($application, $data) {
                    $application->update([
                        'status' => 'awardee_confirmed',
                        'admin_notes' => $data['admin_notes'] ?? $application->admin_notes,
                    ]);
                    $application->user->update(['is_awardee' => true]);
                });
            } else {
                $application->update([
                    'status' => 'rejected_by_admin',
                    'admin_notes' => $data['admin_notes'] ?? $application->admin_notes,
                ]);
            }
        }

        return redirect()->route('verifikasi.akhir')->with('success', 'Keputusan Admin berhasil disimpan.');
    }

    public function downloadRecommendation(Request $request, ScholarshipApplication $application)
    {
        $user = $this->authorizeStudentApplication($request, $application);
        abort_unless(in_array($application->status, ['approved_by_admin', 'loa_submitted', 'awardee_confirmed'], true), 404);
        abort_unless($application->recommendation_letter_file, 404);

        return Storage::disk('public')->download(
            $application->recommendation_letter_file,
            basename($application->recommendation_letter_file)
        );
    }

    private function openScholarships()
    {
        return Scholarship::where('status', 'open')
            ->whereDate('open_date', '<=', today())
            ->whereDate('close_date', '>=', now()->toDateString())
            ->latest()
            ->get();
    }

    private function latestGpa(User $user): ?float
    {
        $score = $user->semesterEvaluations()
            ->whereNotNull('ipk_score')
            ->latest()
            ->value('ipk_score');

        return $score === null ? null : (float) $score;
    }

    private function authorizeStudentApplication(Request $request, ScholarshipApplication $application): User
    {
        $user = $request->user();
        abort_unless($user?->role === 'mahasiswa', 403);
        abort_unless($application->user_id === $user->id, 403);

        return $user;
    }

    private function validateEligibility(
        User $user,
        Scholarship $scholarship,
        ?float $submittedGpa,
        ?ScholarshipApplication $currentApplication = null
    ): float {
        if ($user->is_awardee) {
            throw ValidationException::withMessages([
                'scholarship_id' => 'Awardee tidak dapat mendaftar beasiswa baru.',
            ]);
        }

        if (
            $scholarship->status !== 'open'
            || $scholarship->open_date->gt(today())
            || $scholarship->close_date->lt(today())
        ) {
            throw ValidationException::withMessages([
                'scholarship_id' => 'Pendaftaran beasiswa ini sudah ditutup.',
            ]);
        }

        $gpa = $this->latestGpa($user) ?? $submittedGpa;
        if ($gpa === null || $gpa < (float) $scholarship->min_gpa) {
            throw ValidationException::withMessages([
                'scholarship_id' => $gpa === null
                    ? 'IPK terbaru belum tersedia.'
                    : 'IPK Anda belum memenuhi syarat minimal beasiswa ini.',
            ]);
        }

        $duplicate = ScholarshipApplication::where('user_id', $user->id)
            ->where('scholarship_id', $scholarship->id)
            ->when($currentApplication, fn ($query) => $query->where('id', '!=', $currentApplication->id))
            ->exists();

        if ($duplicate) {
            throw ValidationException::withMessages([
                'scholarship_id' => 'Anda sudah pernah mengajukan beasiswa ini.',
            ]);
        }

        return $gpa;
    }
}