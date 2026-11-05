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
        $filters = $this->validatedFilters($request);
        $tracers = $this->filteredQuery($filters)
            ->with('user')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $awardeeAlumni = AlumniTracer::query()->whereHas('user', function ($query) {
            $query->where('is_awardee', true)->where('academic_status', 'alumni');
        });

        $totalResponses = (clone $awardeeAlumni)->count();
        $employedResponses = (clone $awardeeAlumni)->where(function ($query) {
            $query->whereNotNull('company_name')->where('company_name', '!=', '')
                ->orWhere(function ($query) {
                    $query->whereNotNull('job_title')->where('job_title', '!=', '');
                });
        })->count();
        $sharingCount = (clone $awardeeAlumni)->where('ready_for_sharing', true)->count();
        $averageWaitingMonths = (clone $awardeeAlumni)->where(function ($query) {
            $query->whereNotNull('company_name')->where('company_name', '!=', '')
                ->orWhere(function ($query) {
                    $query->whereNotNull('job_title')->where('job_title', '!=', '');
                });
        })->avg('waiting_months');

        $majorBreakdown = AlumniTracer::query()
            ->join('users', 'users.id', '=', 'alumni_tracers.user_id')
            ->where('users.is_awardee', true)
            ->where('users.academic_status', 'alumni')
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request)
    {
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
     * @return array{search?: string|null, major?: string|null, sharing?: string|null}
     */
    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'major' => ['nullable', Rule::in(['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'])],
            'sharing' => ['nullable', Rule::in(['yes', 'no'])],
        ]);
    }

    /**
     * @param  array{search?: string|null, major?: string|null, sharing?: string|null}  $filters
     * @return Builder<AlumniTracer>
     */
    private function filteredQuery(array $filters): Builder
    {
        return AlumniTracer::query()
            ->whereHas('user', function ($query) {
                $query->where('is_awardee', true)->where('academic_status', 'alumni');
            })
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('nim_nip', 'like', "%{$search}%")
                            ->orWhere('major', 'like', "%{$search}%");
                    })->orWhere('company_name', 'like', "%{$search}%")
                        ->orWhere('job_title', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when($filters['major'] ?? null, function ($query, $major) {
                $query->whereHas('user', fn ($query) => $query->where('major', $major));
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
