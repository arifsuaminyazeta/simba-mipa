<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $scholarships = Scholarship::withCount('applications')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('provider', 'like', "%{$search}%");
                });
            })
            ->when($request->status, fn($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $total = Scholarship::count();
        $active = Scholarship::where('status', 'open')->count();
        $applications = ScholarshipApplication::count();

        return view('beasiswa.index', compact('scholarships', 'total', 'active', 'applications'));
    }

    public function create(Request $request)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        return view('beasiswa.create');
    }

    public function store(Request $request)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $data = $this->validatedData($request);
        $data['remaining_quota'] = $data['quota'];
        Scholarship::create($data);

        return redirect()->route('beasiswa.index')->with('success', 'Beasiswa berhasil ditambahkan.');
    }

    public function show(Request $request, ?Scholarship $scholarship = null)
    {
        $scholarship ??= Scholarship::query()->latest()->first();

        if (! $scholarship) {
            $catalogRoute = $request->user()?->role === 'mahasiswa'
                ? 'mahasiswa.beasiswa.katalog'
                : 'beasiswa.katalog';

            return redirect()->route($catalogRoute)->with('status', 'Belum ada data beasiswa untuk ditampilkan.');
        }

        $scholarship->loadCount('applications');

        return view('beasiswa.show', compact('scholarship'));
    }

    public function edit(Request $request, Scholarship $scholarship)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        return view('beasiswa.edit', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $data = $this->validatedData($request);
        $usedQuota = $scholarship->quota - $scholarship->remaining_quota;

        if ($data['quota'] < $usedQuota) {
            return back()->withErrors([
                'quota' => 'Kuota tidak boleh lebih kecil dari jumlah pendaftar.',
            ])->withInput();
        }

        $data['remaining_quota'] = $data['quota'] - $usedQuota;
        $scholarship->update($data);

        return redirect()->route('beasiswa.index')->with('success', 'Beasiswa berhasil diperbarui.');
    }

    public function destroy(Request $request, Scholarship $scholarship)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        if ($scholarship->applications()->exists()) {
            return back()->with('error', 'Beasiswa tidak bisa dihapus karena sudah memiliki pendaftar.');
        }

        $scholarship->delete();

        return back()->with('success', 'Beasiswa berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', 'max:255'],
            'min_gpa' => ['required', 'numeric', 'min:0', 'max:4'],
            'quota' => ['required', 'integer', 'min:1'],
            'open_date' => ['required', 'date'],
            'close_date' => ['required', 'date', 'after_or_equal:open_date'],
            'status' => ['required', Rule::in(['open', 'closed'])],
        ]);
    }
}
