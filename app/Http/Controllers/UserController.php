<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const MAJORS = ['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'];

    public function index(Request $request)
    {
        $this->ensureAdmin($request);

        $lecturers = User::query()
            ->where('role', 'dosen')
            ->withCount([
                'advisees as active_advisees_count' => fn ($query) => $query
                    ->where('role', 'mahasiswa')
                    ->where('academic_status', 'aktif'),
            ])
            ->orderBy('major')
            ->orderBy('name')
            ->paginate(10);

        $activeStudentCount = User::query()
            ->where('role', 'mahasiswa')
            ->where('academic_status', 'aktif')
            ->count();
        $assignedStudentCount = User::query()
            ->where('role', 'mahasiswa')
            ->where('academic_status', 'aktif')
            ->whereNotNull('dosen_pa_id')
            ->count();
        $unassignedStudentCount = $activeStudentCount - $assignedStudentCount;

        return view('users.index', compact(
            'lecturers',
            'activeStudentCount',
            'assignedStudentCount',
            'unassignedStudentCount'
        ));
    }

    public function create(Request $request)
    {
        $this->ensureAdmin($request);

        return view('users.create', [
            'lecturer' => null,
            'majors' => self::MAJORS,
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nim_nip' => ['required', 'string', 'max:255', 'unique:users,nim_nip'],
            'major' => ['required', Rule::in(self::MAJORS)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            ...$data,
            'role' => 'dosen',
            'academic_status' => 'aktif',
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun Dosen PA berhasil dibuat.');
    }

    public function edit(Request $request, User $user)
    {
        $this->ensureAdmin($request);
        $this->ensureLecturer($user);

        return view('users.create', [
            'lecturer' => $user,
            'majors' => self::MAJORS,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->ensureAdmin($request);
        $this->ensureLecturer($user);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'nim_nip' => ['required', 'string', 'max:255', Rule::unique('users', 'nim_nip')->ignore($user->id)],
            'major' => ['required', Rule::in(self::MAJORS)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun Dosen PA berhasil diperbarui.');
    }

    public function advisees(Request $request, User $dosen)
    {
        $this->ensureAdmin($request);
        $this->ensureLecturer($dosen);

        $students = User::query()
            ->where('role', 'mahasiswa')
            ->where('academic_status', 'aktif')
            ->with('academicAdvisor')
            ->orderBy('major')
            ->orderBy('name')
            ->get();

        $assignedStudentIds = $dosen->advisees()
            ->where('role', 'mahasiswa')
            ->where('academic_status', 'aktif')
            ->pluck('id')
            ->all();

        return view('users.advisees', compact('dosen', 'students', 'assignedStudentIds'));
    }

    public function updateAdvisees(Request $request, User $dosen)
    {
        $this->ensureAdmin($request);
        $this->ensureLecturer($dosen);

        $validated = $request->validate([
            'student_ids' => ['sometimes', 'array'],
            'student_ids.*' => [
                'integer',
                'distinct',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'mahasiswa')
                        ->where('academic_status', 'aktif');
                }),
            ],
        ]);

        DB::transaction(function () use ($dosen, $validated): void {
            User::query()
                ->where('dosen_pa_id', $dosen->id)
                ->where('role', 'mahasiswa')
                ->where('academic_status', 'aktif')
                ->update(['dosen_pa_id' => null]);

            if (! empty($validated['student_ids'])) {
                User::query()
                    ->whereIn('id', $validated['student_ids'])
                    ->where('role', 'mahasiswa')
                    ->where('academic_status', 'aktif')
                    ->update(['dosen_pa_id' => $dosen->id]);
            }
        });

        return redirect()
            ->route('users.advisees', $dosen)
            ->with('success', 'Pemetaan mahasiswa bimbingan berhasil diperbarui.');
    }

    private function ensureAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'admin', 403);
    }

    private function ensureLecturer(User $user): void
    {
        abort_unless($user->role === 'dosen', 404);
    }
}
