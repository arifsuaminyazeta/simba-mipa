<?php

namespace App\Http\Controllers;

use App\Models\AlumniTracer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlumniTracerController extends Controller
{
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
        $employedResponses = (clone $awardeeAlumni)
            ->whereIn('employment_status', ['bekerja', 'wirausaha'])
            ->count();
        $sharingCount = (clone $awardeeAlumni)->where('ready_for_sharing', true)->count();
        $averageWaitingMonths = (clone $awardeeAlumni)
            ->whereIn('employment_status', ['bekerja', 'wirausaha'])
            ->avg('waiting_months');

        $majorBreakdown = AlumniTracer::query()
            ->join('users', 'users.id', '=', 'alumni_tracers.user_id')
            ->where('users.is_awardee', true)
            ->where('users.academic_status', 'lulus')
            ->selectRaw('users.major, count(*) as total')
            ->groupBy('users.major')
            ->orderByDesc('total')
            ->get();

        return view('tracer.rekap', compact(
            'tracers',
            'filters',
            'totalResponses',
            'employedResponses',
            'sharingCount',
            'averageWaitingMonths',
            'majorBreakdown'
        ));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
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
                'Status Pekerjaan',
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
                    $row = [
                        $tracer->user->name,
                        $tracer->user->nim_nip,
                        $tracer->user->major,
                        'Alumni Awardee',
                        $tracer->employment_status,
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

    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'major' => ['nullable', Rule::in(['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'])],
            'sharing' => ['nullable', Rule::in(['yes', 'no'])],
            'employment_status' => ['nullable', 'string', 'max:50'],
        ]);
    }

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
            ->when($filters['sharing'] ?? null, function ($query, $sharing) {
                $query->where('ready_for_sharing', $sharing === 'yes');
            })
            ->when($filters['employment_status'] ?? null, function ($query, $status) {
                $query->where('employment_status', $status);
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