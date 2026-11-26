<?php

namespace App\Http\Controllers;

use App\Models\AlumniTracer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlumniTracerController extends Controller
{
    private const MAJORS = ['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'];

    private const EMPLOYMENT_STATUSES = [
        'bekerja' => 'Bekerja',
        'studi_lanjut' => 'Studi Lanjut',
        'wirausaha' => 'Wirausaha',
        'mencari_kerja' => 'Mencari Kerja',
    ];

    public function publicIndex(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'major' => ['nullable', Rule::in(self::MAJORS)],
        ]);

        $tracers = AlumniTracer::query()
            ->where('ready_for_sharing', true)
            ->whereHas('user', function ($query) {
                $query->where('is_awardee', true)
                    ->where('academic_status', 'lulus');
            })
            ->with('user')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'ilike', "%{$search}%")
                            ->orWhere('major', 'ilike', "%{$search}%");
                    })->orWhere('company_name', 'ilike', "%{$search}%")
                        ->orWhere('job_title', 'ilike', "%{$search}%")
                        ->orWhere('city', 'ilike', "%{$search}%");
                });
            })
            ->when($filters['major'] ?? null, function ($query, string $major) {
                $query->whereHas('user', fn ($userQuery) => $userQuery->where('major', $major));
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('tracer.index', [
            'tracers' => $tracers,
            'filters' => $filters,
            'majors' => self::MAJORS,
            'employmentStatuses' => self::EMPLOYMENT_STATUSES,
        ]);
    }

    public function index(Request $request)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $filters = $this->validatedFilters($request);
        $tracers = $this->filteredQuery($filters)
            ->with('user')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $awardeeAlumni = AlumniTracer::query()->whereHas('user', function ($query) {
            $query->where('is_awardee', true)->where('academic_status', 'lulus');
        });

        $totalResponses = (clone $awardeeAlumni)->count();
        $employedResponses = (clone $awardeeAlumni)->where(function ($query) {
            $query->where('employment_status', 'bekerja')
                ->orWhere(function ($legacyQuery) {
                    $legacyQuery->whereNull('employment_status')
                        ->where(function ($filledQuery) {
                            $filledQuery->whereNotNull('company_name')->where('company_name', '!=', '')
                                ->orWhere(function ($jobQuery) {
                                    $jobQuery->whereNotNull('job_title')->where('job_title', '!=', '');
                                });
                        });
                });
        })->count();
        $sharingCount = (clone $awardeeAlumni)->where('ready_for_sharing', true)->count();
        $averageWaitingMonths = (clone $awardeeAlumni)
            ->whereNotNull('waiting_months')
            ->avg('waiting_months');

        $majorBreakdown = AlumniTracer::query()
            ->join('users', 'users.id', '=', 'alumni_tracers.user_id')
            ->where('users.is_awardee', true)
            ->where('users.academic_status', 'lulus')
            ->selectRaw('users.major, count(*) as total')
            ->groupBy('users.major')
            ->orderByDesc('total')
            ->get();

        return view('tracer.rekap', [
            'tracers' => $tracers,
            'filters' => $filters,
            'majors' => self::MAJORS,
            'employmentStatuses' => self::EMPLOYMENT_STATUSES,
            'totalResponses' => $totalResponses,
            'employedResponses' => $employedResponses,
            'sharingCount' => $sharingCount,
            'averageWaitingMonths' => $averageWaitingMonths,
            'majorBreakdown' => $majorBreakdown,
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->user();
        [$isEligible, $lockReason] = $this->checkTracerEligibility($user);

        $tracer = $user
            ? AlumniTracer::query()->where('user_id', $user->id)->first()
            : null;

        return view('tracer.form', [
            'tracer' => $tracer,
            'isEligible' => $isEligible,
            'lockReason' => $lockReason,
            'employmentStatuses' => self::EMPLOYMENT_STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        [$isEligible, $lockReason] = $this->checkTracerEligibility($user);

        if (! $isEligible) {
            return redirect()
                ->route('tracer.form')
                ->with('error', $lockReason);
        }

        $validated = $request->validate([
            'employment_status' => ['required', Rule::in(array_keys(self::EMPLOYMENT_STATUSES))],
            'company_name' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:120'],
            'waiting_months' => ['nullable', 'integer', 'min:0', 'max:120'],
            'contact_linkedin' => ['nullable', 'url', 'max:255'],
            'ready_for_sharing' => ['required', 'boolean'],
        ]);

        AlumniTracer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'employment_status' => $validated['employment_status'],
                'company_name' => $validated['company_name'] ?? null,
                'job_title' => $validated['job_title'] ?? null,
                'city' => $validated['city'] ?? null,
                'waiting_months' => $validated['waiting_months'] ?? null,
                'contact_linkedin' => $validated['contact_linkedin'] ?? null,
                'ready_for_sharing' => $request->boolean('ready_for_sharing'),
            ]
        );

        return redirect()
            ->route('tracer.form')
            ->with('success', 'Data tracer study Anda berhasil disimpan.');
    }

    public function export(Request $request)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $query = $this->filteredQuery($this->validatedFilters($request))->with('user');

        return response()->streamDownload(function () use ($query): void {
            $output = fopen('php://output', 'w');

            if ($output === false) {
                throw new \RuntimeException('Tidak dapat membuka output ekspor tracer study.');
            }

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, [
                'Nama Alumni',
                'NIM',
                'Jurusan',
                'Status Awardee',
                'Status Aktivitas',
                'Jabatan',
                'Perusahaan/Instansi',
                'Kota',
                'Waktu Tunggu (bulan)',
                'Bersedia Menjadi Narasumber',
                'Kontak LinkedIn',
            ], ',', '"', '');

            $query->orderBy('id')->chunk(200, function ($tracers) use ($output): void {
                foreach ($tracers as $tracer) {
                    $contact = $tracer->ready_for_sharing ? $tracer->contact_linkedin : '';
                    $statusLabel = self::EMPLOYMENT_STATUSES[$tracer->employment_status] ?? ($tracer->employment_status ?: '-');
                    $row = [
                        $tracer->user->name,
                        $tracer->user->nim_nip,
                        $tracer->user->major,
                        'Alumni Awardee',
                        $statusLabel,
                        $tracer->job_title,
                        $tracer->company_name,
                        $tracer->city,
                        $tracer->waiting_months,
                        $tracer->ready_for_sharing ? 'Ya' : 'Tidak',
                        $contact,
                    ];

                    fputcsv($output, array_map($this->safeCsvCell(...), $row), ',', '"', '');
                }
            });

            fclose($output);
        }, 'rekap-tracer-study-alumni-awardee-'.now()->format('Ymd-His').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * @return array{0: bool, 1: string|null}
     */
    private function checkTracerEligibility(?User $user): array
    {
        if (! $user || $user->role !== 'mahasiswa') {
            return [false, 'Formulir tracer study hanya dapat diisi oleh akun Mahasiswa Alumni Awardee.'];
        }

        if ($user->academic_status !== 'lulus') {
            return [false, 'Formulir tracer study terkunci karena status akademik Anda saat ini bukan "lulus".'];
        }

        if (! $user->is_awardee) {
            return [false, 'Formulir tracer study terkunci karena akun Anda tidak tercatat sebagai penerima beasiswa (awardee).'];
        }

        return [true, null];
    }

    /**
     * @return array{search?: string|null, major?: string|null, employment_status?: string|null, sharing?: string|null}
     */
    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'major' => ['nullable', Rule::in(self::MAJORS)],
            'employment_status' => ['nullable', Rule::in(array_keys(self::EMPLOYMENT_STATUSES))],
            'sharing' => ['nullable', Rule::in(['yes', 'no'])],
        ]);
    }

    /**
     * @param  array{search?: string|null, major?: string|null, employment_status?: string|null, sharing?: string|null}  $filters
     * @return Builder<AlumniTracer>
     */
    private function filteredQuery(array $filters): Builder
    {
        return AlumniTracer::query()
            ->whereHas('user', function ($query) {
                $query->where('is_awardee', true)->where('academic_status', 'lulus');
            })
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%")
                            ->orWhere('nim_nip', 'ilike', "%{$search}%")
                            ->orWhere('major', 'ilike', "%{$search}%");
                    })->orWhere('company_name', 'ilike', "%{$search}%")
                        ->orWhere('job_title', 'ilike', "%{$search}%")
                        ->orWhere('city', 'ilike', "%{$search}%");
                });
            })
            ->when($filters['major'] ?? null, function ($query, $major) {
                $query->whereHas('user', fn ($query) => $query->where('major', $major));
            })
            ->when($filters['employment_status'] ?? null, function ($query, $status) {
                $query->where('employment_status', $status);
            })
            ->when($filters['sharing'] ?? null, function ($query, $sharing) {
                $query->where('ready_for_sharing', $sharing === 'yes');
            });
    }

    private function safeCsvCell(mixed $value): string|int|float|null
    {
        if (! is_string($value) || $value === '') {
            return $value;
        }

        return preg_match('/^[\s]*[=+\-@]/u', $value) === 1 ? "'".$value : $value;
    }
}
