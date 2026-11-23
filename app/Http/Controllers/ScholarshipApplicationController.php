<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScholarshipApplicationController extends Controller
{
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
                $query->whereHas('user', fn($query) => $query->where('name', 'ilike', "%{$search}%"));
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

        $applications = ScholarshipApplication::with(['user', 'scholarship'])
            ->whereIn('status', [
                'verified_by_dosen',
                'approved_by_admin',
                'rejected_by_admin',
                'loa_submitted',
                'awardee_confirmed',
            ])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', fn($query) => $query->where('name', 'ilike', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $countPending = ScholarshipApplication::whereIn('status', ['verified_by_dosen', 'loa_submitted'])->count();
        $countApproved = ScholarshipApplication::whereIn('status', ['approved_by_admin', 'awardee_confirmed'])->count();
        $countRejected = ScholarshipApplication::where('status', 'rejected_by_admin')->count();

        return view('verifikasi.akhir', compact('applications', 'countPending', 'countApproved', 'countRejected'));
    }

    public function show(Request $request, ScholarshipApplication $application)
    {
        $user = $request->user();
        abort_unless(in_array($user?->role, ['admin', 'dosen_pa'], true), 403);

        $application->load(['user', 'scholarship']);

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
            'recommendation_letter_file' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        if ($application->status === 'verified_by_dosen') {
            $payload = [
                'status' => $data['decision'] === 'approve' ? 'approved_by_admin' : 'rejected_by_admin',
                'admin_notes' => $data['admin_notes'] ?? null,
            ];

            if ($data['decision'] === 'approve' && $request->hasFile('recommendation_letter_file')) {
                $payload['recommendation_letter_file'] = $request->file('recommendation_letter_file')
                    ->store('recommendations', 'public');
            }

            $application->update($payload);
        } else {
            if ($data['decision'] === 'approve') {
                if (! $application->acceptance_proof_file) {
                    return back()->withErrors(['decision' => 'Bukti kelolosan (LoA/SK) belum diunggah.']);
                }

                $application->update([
                    'status' => 'awardee_confirmed',
                    'admin_notes' => $data['admin_notes'] ?? $application->admin_notes,
                ]);
                $application->user->update(['is_awardee' => true]);
            } else {
                $application->update([
                    'status' => 'rejected_by_admin',
                    'admin_notes' => $data['admin_notes'] ?? $application->admin_notes,
                ]);
            }
        }

        return redirect()->route('verifikasi.akhir')->with('success', 'Keputusan Admin berhasil disimpan.');
    }
}