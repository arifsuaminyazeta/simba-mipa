<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::query()
            ->with('creator')
            ->where('is_active', true)
            ->latest()
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function manage(Request $request)
    {
        $this->ensureAdmin($request);

        $announcements = Announcement::query()
            ->with('creator')
            ->latest()
            ->paginate(10);

        return view('announcements.manage', compact('announcements'));
    }

    public function create(Request $request)
    {
        $this->ensureAdmin($request);

        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request);

        Announcement::create([
            ...$this->validatedData($request),
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('announcements.manage')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Request $request, Announcement $announcement)
    {
        $this->ensureAdmin($request);

        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->ensureAdmin($request);
        $announcement->update($this->validatedData($request));

        return redirect()
            ->route('announcements.manage')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Request $request, Announcement $announcement)
    {
        $this->ensureAdmin($request);
        $announcement->delete();

        return redirect()
            ->route('announcements.manage')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    /**
     * @return array{title: string, content: string, is_active: bool}
     */
    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:20000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        return [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ];
    }

    private function ensureAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'admin', 403);
    }
}
