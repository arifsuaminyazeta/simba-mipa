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
        abort_unless(auth()->user()->role === 'admin', 403);

        $scholarships = Scholarship::withCount('applications')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('provider', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        $total = Scholarship::count();

        $active = Scholarship::where('status', 'open')->count();

        $applications = ScholarshipApplication::count();

        return view('beasiswa.index', compact(
            'scholarships',
            'total',
            'active',
            'applications'
        ));
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        return view('beasiswa.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'min_gpa' => 'required|numeric|min:0|max:4',
            'quota' => 'required|integer|min:1',
            'open_date' => 'required|date',
            'close_date' => 'required|date|after_or_equal:open_date',
            'status' => ['required', Rule::in(['open', 'closed'])],
        ]);

        $data['remaining_quota'] = $data['quota'];

        Scholarship::create($data);

        return redirect()
            ->route('demo.beasiswa.index')
            ->with('success', 'Beasiswa berhasil ditambahkan.');
    }

    public function show(Scholarship $scholarship)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $scholarship->loadCount('applications');

        return view('beasiswa.show', compact('scholarship'));
    }

    public function edit(Scholarship $scholarship)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        return view('beasiswa.edit', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'min_gpa' => 'required|numeric|min:0|max:4',
            'quota' => 'required|integer|min:1',
            'open_date' => 'required|date',
            'close_date' => 'required|date|after_or_equal:open_date',
            'status' => ['required', Rule::in(['open', 'closed'])],
        ]);

        $used = $scholarship->quota - $scholarship->remaining_quota;

        if ($data['quota'] < $used) {
            return back()->withErrors([
                'quota' => 'Kuota tidak boleh lebih kecil dari jumlah pendaftar.'
            ])->withInput();
        }

        $data['remaining_quota'] = $data['quota'] - $used;

        $scholarship->update($data);

        return redirect()
            ->route('demo.beasiswa.index')
            ->with('success', 'Beasiswa berhasil diperbarui.');
    }

    public function destroy(Scholarship $scholarship)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        if ($scholarship->applications()->exists()) {
            return back()->with(
                'error',
                'Beasiswa tidak bisa dihapus karena sudah memiliki pendaftar.'
            );
        }

        $scholarship->delete();

        return back()->with('success', 'Beasiswa berhasil dihapus.');
    }
}