<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScholarshipApplicationController extends Controller
{
    public function dosenIndex(Request $request)
    {
        abort_unless($request->user()?->role === 'dosen', 403);

        $applications = ScholarshipApplication::with(['user', 'scholarship'])
            ->where('status', 'pending')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', fn($query) => $query->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10);

        $countPending = ScholarshipApplication::where('status', 'pending')->count();
        $countVerified = ScholarshipApplication::where('status', 'verified_by_dosen')->count();
        $countRejected = ScholarshipApplication::where('status', 'rejected_by_dosen')->count();

        return view('verifikasi.awal', compact('applications', 'countPending', 'countVerified', 'countRejected'));
    }

    public function adminIndex(Request $request)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $applications = ScholarshipApplication::with(['user', 'scholarship'])
            ->whereIn('status', ['verified_by_dosen', 'approved_by_admin', 'rejected_by_admin'])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', fn($query) => $query->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10);

        $countPending = ScholarshipApplication::where('status', 'verified_by_dosen')->count();
        $countApproved = ScholarshipApplication::where('status', 'approved_by_admin')->count();
        $countRejected = ScholarshipApplication::where('status', 'rejected_by_admin')->count();

        return view('verifikasi.akhir', compact('applications', 'countPending', 'countApproved', 'countRejected'));
    }

    public function show(Request $request, ScholarshipApplication $application)
    {
        abort_unless(in_array($request->user()?->role, ['admin', 'dosen'], true), 403);

        $application->load(['user', 'scholarship']);

        return view('verifikasi.detail', compact('application'));
    }

    public function verifyByDosen(Request $request, ScholarshipApplication $application)
    {
        abort_unless($request->user()?->role === 'dosen', 403);
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
        abort_unless($application->status === 'verified_by_dosen', 422);

        $data = $request->validate([
            'decision' => ['required', Rule::in(['approve', 'reject'])],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($data['decision'] === 'approve') {
            if (! $application->acceptance_proof_file) {
                return back()->withErrors(['decision' => 'Bukti kelolosan belum diunggah.']);
            }

            $application->user->update(['is_awardee' => true]);
            $application->update(['status' => 'approved_by_admin']);
        } else {
            $application->update(['status' => 'rejected_by_admin']);
        }

        if (! empty($data['admin_notes'])) {
            $application->update([
                'dosen_notes' => trim(($application->dosen_notes ?? '')."\n\nCatatan Admin: ".$data['admin_notes']),
            ]);
        }

        return redirect()->route('verifikasi.akhir')->with('success', 'Keputusan Admin berhasil disimpan.');
    }
}
