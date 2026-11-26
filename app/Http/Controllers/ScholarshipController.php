<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScholarshipController extends Controller
{
    public function catalog(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['open', 'closed'])],
        ]);

        $scholarships = Scholarship::query()
            ->withCount([
                'applications',
                'applications as awardees_count' => fn ($query) => $query->where('status', 'approved_by_admin'),
            ])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('provider', 'ilike', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->orderByRaw("CASE WHEN status = 'open' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('beasiswa.katalog', compact('scholarships', 'filters'));
    }

    public function index(Request $request)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $scholarships = Scholarship::query()
            ->withCount([
                'applications',
                'applications as awardees_count' => fn ($query) => $query->where('status', 'approved_by_admin'),
            ])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('provider', 'ilike', "%{$search}%");
                });
            })
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
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

        $scholarship->loadCount([
            'applications',
            'applications as awardees_count' => fn ($query) => $query->where('status', 'approved_by_admin'),
        ]);

        return view('beasiswa.show', compact('scholarship'));
    }

    public function edit(Request $request, Scholarship $scholarship)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $scholarship->loadCount([
            'applications as awardees_count' => fn ($query) => $query->where('status', 'approved_by_admin'),
        ]);

        return view('beasiswa.edit', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $data = $this->validatedData($request);
        $awardeesCount = $scholarship->applications()
            ->where('status', 'approved_by_admin')
            ->count();

        if ($data['quota'] !== null && $data['quota'] < $awardeesCount) {
            return back()->withErrors([
                'quota' => "Kuota tidak boleh lebih kecil dari jumlah awardee terkonfirmasi ({$awardeesCount}).",
            ])->withInput();
        }

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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'registration_url' => ['nullable', 'url', 'max:255'],
            'min_gpa' => ['required', 'numeric', 'min:0', 'max:4'],
            'quota' => ['nullable', 'integer', 'min:1'],
            'open_date' => ['required', 'date'],
            'close_date' => ['required', 'date', 'after_or_equal:open_date'],
            'status' => ['required', Rule::in(['open', 'closed'])],
        ]);

        $validated['quota'] = ($validated['quota'] ?? null) !== null && $validated['quota'] !== ''
            ? (int) $validated['quota']
            : null;

        return $validated;
    }
}