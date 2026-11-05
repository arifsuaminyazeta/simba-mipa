@extends('layouts.app')

@section('title', 'Rekap Tracer Study')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Alumni &amp; karier</p>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">Tracer Study</h1>
            <p class="text-xs text-slate-500 mt-1">Rekam karier alumni awardee, kelola kontak narasumber, dan ekspor rekapitulasi.</p>
        </div>
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200/80 self-start sm:self-auto">
            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            Data alumni awardee
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Alumni Awardee</p>
                <h2 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalResponses, 0, ',', '.') }}</h2>
                <p class="text-[11px] text-slate-400 mt-1">Sudah mengisi tracer study</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sudah Bekerja</p>
                <h2 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($employedResponses, 0, ',', '.') }}</h2>
                <p class="text-[11px] text-slate-400 mt-1">Memiliki posisi atau tempat kerja</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Siap Berbagi</p>
                <h2 class="text-2xl font-extrabold text-indigo-600 mt-1">{{ number_format($sharingCount, 0, ',', '.') }}</h2>
                <p class="text-[11px] text-slate-400 mt-1">Kontak dapat ditindaklanjuti</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4v-4z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Waktu Tunggu</p>
                <h2 class="text-2xl font-extrabold text-amber-500 mt-1">
                    @if($averageWaitingMonths !== null)
                        {{ number_format((float) $averageWaitingMonths, 1, ',', '.') }} <span class="text-sm font-semibold">bulan</span>
                    @else
                        —
                    @endif
                </h2>
                <p class="text-[11px] text-slate-400 mt-1">Dari alumni yang sudah bekerja</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-5">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-5">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Respons per Jurusan</h2>
                <p class="text-xs text-slate-400 mt-0.5">Sebaran alumni awardee yang telah mengisi tracer study.</p>
            </div>
            <span class="text-[11px] text-slate-400">{{ $majorBreakdown->count() }} jurusan terdata</span>
        </div>

        @if($majorBreakdown->isNotEmpty())
            @php
                $maxMajorCount = max(1, (int) $majorBreakdown->max('total'));
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                @foreach($majorBreakdown as $major)
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-1.5">
                            <span class="text-xs font-semibold text-slate-700">{{ $major->major }}</span>
                            <span class="text-[11px] font-bold text-slate-500">{{ number_format($major->total, 0, ',', '.') }} respons</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full bg-blue-500" style="width: {{ ((int) $major->total / $maxMajorCount) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-xs text-slate-400">Belum ada respons untuk ditampilkan.</p>
        @endif
    </section>

    <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Rekam Karier Alumni Awardee</h2>
                <p class="text-xs text-slate-400 mt-0.5">Kontak hanya ditampilkan untuk alumni yang bersedia menjadi narasumber.</p>
            </div>
            <div class="flex flex-col lg:flex-row gap-2">
            <form method="GET" action="{{ route('tracer.rekap') }}" class="flex flex-col sm:flex-row gap-2">
                <label class="sr-only" for="search">Cari alumni atau pekerjaan</label>
                <input id="search" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama, NIM, pekerjaan..." class="w-full sm:w-56 rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                <label class="sr-only" for="major">Filter jurusan</label>
                <select id="major" name="major" class="rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua jurusan</option>
                    @foreach(['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'] as $major)
                        <option value="{{ $major }}" @selected(($filters['major'] ?? '') === $major)>{{ $major }}</option>
                    @endforeach
                </select>
                <label class="sr-only" for="sharing">Filter kesediaan berbagi</label>
                <select id="sharing" name="sharing" class="rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua kesediaan</option>
                    <option value="yes" @selected(($filters['sharing'] ?? '') === 'yes')>Siap berbagi</option>
                    <option value="no" @selected(($filters['sharing'] ?? '') === 'no')>Belum bersedia</option>
                </select>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">Terapkan</button>
                @if(($filters['search'] ?? null) || ($filters['major'] ?? null) || ($filters['sharing'] ?? null))
                    <a href="{{ route('tracer.rekap') }}" class="inline-flex items-center justify-center px-3 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Reset</a>
                @endif
            </form>
            <a href="{{ route('tracer.rekap.export', request()->only(['search', 'major', 'sharing'])) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 text-xs font-semibold hover:bg-emerald-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h10l4 4v12a2 2 0 01-2 2z"/></svg>
                Ekspor CSV
            </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Alumni</th>
                        <th class="px-6 py-3.5">Pekerjaan</th>
                        <th class="px-5 py-3.5">Lokasi</th>
                        <th class="px-5 py-3.5 text-center">Waktu Tunggu</th>
                        <th class="px-5 py-3.5">Kesediaan Berbagi</th>
                        <th class="px-6 py-3.5 text-right">Kontak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($tracers as $tracer)
                        @php
                            $isEmployed = filled($tracer->company_name) || filled($tracer->job_title);
                            $linkedinHost = $tracer->contact_linkedin ? parse_url($tracer->contact_linkedin, PHP_URL_HOST) : null;
                            $linkedinScheme = $tracer->contact_linkedin ? parse_url($tracer->contact_linkedin, PHP_URL_SCHEME) : null;
                            $linkedinUrl = $linkedinScheme === 'https'
                                && ($linkedinHost === 'linkedin.com' || ($linkedinHost && str_ends_with($linkedinHost, '.linkedin.com')))
                                ? $tracer->contact_linkedin
                                : null;
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900 text-[13px]">{{ $tracer->user->name }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $tracer->user->nim_nip ?: 'NIM belum tersedia' }} · {{ $tracer->user->major }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">{{ $tracer->job_title ?: 'Pekerjaan belum diisi' }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $tracer->company_name ?: 'Tempat kerja belum diisi' }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $tracer->city ?: '—' }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($isEmployed)
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold">{{ $tracer->waiting_months }} bulan</span>
                                @else
                                    <span class="text-slate-400">Belum bekerja</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($tracer->ready_for_sharing)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Siap berbagi
                                    </span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-semibold">Belum bersedia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($tracer->ready_for_sharing && $linkedinUrl)
                                    <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-blue-200 bg-blue-50 text-blue-700 font-semibold text-[11px] hover:bg-blue-100 transition-colors">
                                        LinkedIn
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6L10 14M5 7H4a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1v-1"/></svg>
                                    </a>
                                @elseif($tracer->ready_for_sharing && $tracer->contact_linkedin)
                                    <span class="text-[11px] text-slate-500 break-all">{{ $tracer->contact_linkedin }}</span>
                                @elseif(!$tracer->ready_for_sharing)
                                    <span class="text-[11px] text-slate-400">Belum memberi izin</span>
                                @else
                                    <span class="text-[11px] text-slate-400">Tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="mx-auto w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum ada data tracer study</p>
                                <p class="text-xs text-slate-400 mt-1">Data alumni akan muncul di sini setelah respons tracer study tersedia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tracers->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $tracers->links() }}</div>
        @endif
    </section>
</div>
@endsection