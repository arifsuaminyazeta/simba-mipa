<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const MAJORS = ['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'];

    private const ACADEMIC_STATUSES = ['aktif', 'cuti', 'lulus'];

    public function index(Request $request)
    {
        $this->ensureAdmin($request);

        $filters = $request->validate([
            'tab' => ['nullable', Rule::in(['dosen_pa', 'mahasiswa'])],
            'search' => ['nullable', 'string', 'max:100'],
            'major' => ['nullable', Rule::in(self::MAJORS)],
            'academic_status' => ['nullable', Rule::in(self::ACADEMIC_STATUSES)],
        ]);

        $hasStudentFilter = filled($filters['search'] ?? null)
            || filled($filters['major'] ?? null)
            || filled($filters['academic_status'] ?? null)
            || $request->filled('students_page');

        $activeTab = $filters['tab'] ?? ($hasStudentFilter ? 'mahasiswa' : 'dosen_pa');

        $lecturers = User::query()
            ->where('role', 'dosen_pa')
            ->withCount([
                'advisees as active_advisees_count' => fn ($query) => $query
                    ->where('role', 'mahasiswa')
                    ->where('academic_status', 'aktif'),
            ])
            ->orderBy('major')
            ->orderBy('name')
            ->paginate(10, ['*'], 'lecturers_page')
            ->withQueryString();

        $students = User::query()
            ->where('role', 'mahasiswa')
            ->with('academicAdvisor')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'ilike', "%{$search}%")
                        ->orWhere('nim_nip', 'ilike', "%{$search}%");
                });
            })
            ->when($filters['major'] ?? null, fn ($query, string $major) => $query->where('major', $major))
            ->when($filters['academic_status'] ?? null, fn ($query, string $status) => $query->where('academic_status', $status))
            ->orderBy('major')
            ->orderBy('name')
            ->paginate(10, ['*'], 'students_page')
            ->withQueryString();

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
        $totalLecturerCount = User::query()->where('role', 'dosen_pa')->count();
        $totalStudentCount = User::query()->where('role', 'mahasiswa')->count();

        $studentQuery = User::query()
            ->where('role', 'mahasiswa')
            ->with('academicAdvisor');

        if ($search = trim((string) $request->query('search'))) {
            $studentQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('nim_nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($category = $request->query('student_category')) {
            $studentQuery->when($category === 'umum', fn ($query) => $query
                ->where('academic_status', 'aktif')
                ->where('is_awardee', false))
                ->when($category === 'awardee', fn ($query) => $query
                    ->where('academic_status', 'aktif')
                    ->where('is_awardee', true))
                ->when($category === 'alumni_awardee', fn ($query) => $query
                    ->where('academic_status', 'lulus')
                    ->where('is_awardee', true));
        }

        $students = $studentQuery
            ->orderBy('major')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact(
            'lecturers',
            'activeStudentCount',
            'assignedStudentCount',
            'unassignedStudentCount',
            'students'
        ));
    }

    public function editStudent(Request $request, User $student)
    {
        $this->ensureAdmin($request);
        abort_unless($student->role === 'mahasiswa', 404);

        $advisors = User::query()
            ->where('role', 'dosen_pa')
            ->where('is_active', true)
            ->orderBy('major')
            ->orderBy('name')
            ->get();

        $category = $student->academic_status === 'lulus'
            ? ($student->is_awardee ? 'alumni_awardee' : 'umum')
            : ($student->is_awardee ? 'awardee' : 'umum');

        return view('users.edit-student', compact('student', 'advisors', 'category'));
    }

    public function updateStudent(Request $request, User $student)
    {
        $this->ensureAdmin($request);
        abort_unless($student->role === 'mahasiswa', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->id)],
            'nim_nip' => ['required', 'string', 'max:255', Rule::unique('users', 'nim_nip')->ignore($student->id)],
            'major' => ['required', Rule::in(self::MAJORS)],
            'phone' => ['nullable', 'string', 'max:30'],
            'student_category' => ['required', Rule::in(['umum', 'awardee', 'alumni_awardee'])],
            'dosen_pa_id' => ['nullable', 'integer', Rule::exists('users', 'id')->where(fn ($query) => $query
                ->where('role', 'dosen_pa')
                ->where('is_active', true))],
            'is_active' => ['sometimes', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $category = $data['student_category'];
        unset($data['student_category']);

        $data['academic_status'] = $category === 'alumni_awardee' ? 'lulus' : 'aktif';
        $data['is_awardee'] = $category !== 'umum';
        $data['dosen_pa_id'] = $category === 'alumni_awardee'
            ? null
            : ($data['dosen_pa_id'] ?? null);
        $data['is_active'] = $request->boolean('is_active');

        $student->update($data);

        return redirect()
            ->route('users.index', ['student_category' => $category])
            ->with('success', 'Data dan status mahasiswa berhasil diperbarui.');
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
            'phone' => ['nullable', 'string', 'max:30'],
            'is_active' => ['sometimes', 'boolean'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            ...$data,
            'role' => 'dosen_pa',
            'academic_status' => null,
            'is_awardee' => false,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
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
            'phone' => ['nullable', 'string', 'max:30'],
            'is_active' => ['sometimes', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        if ($request->has('is_active')) {
            $data['is_active'] = $request->boolean('is_active');
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun Dosen PA berhasil diperbarui.');
    }

    public function updateAcademicStatus(Request $request, User $user)
    {
        $this->ensureAdmin($request);
        abort_unless($user->role === 'mahasiswa', 404);

        $validated = $request->validate([
            'academic_status' => ['required', Rule::in(self::ACADEMIC_STATUSES)],
        ]);

        $user->update([
            'academic_status' => $validated['academic_status'],
        ]);

        return redirect()
            ->back()
            ->with('success', "Status akademik {$user->name} berhasil diubah menjadi {$validated['academic_status']}.");
    }

    public function toggleActive(Request $request, User $user)
    {
        $this->ensureAdmin($request);

        if ($request->user()->id === $user->id) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $newStatus = ! (bool) $user->is_active;

        $user->update([
            'is_active' => $newStatus,
        ]);

        $statusLabel = $newStatus ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->back()
            ->with('success', "Akun {$user->name} berhasil {$statusLabel}.");
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
        abort_unless($user->role === 'dosen_pa', 404);
    }
}