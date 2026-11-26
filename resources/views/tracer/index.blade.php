@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')

@section('title', 'Direktori Alumni Beasiswa')

@section('content')
@php
    $statusBadgeClasses = [
        'bekerja' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'studi_lanjut' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'wirausaha' => 'bg-amber-50 text-amber-700 border-amber-200',
        'mencari_kerja' => 'bg-slate-100 text-slate-600 border-slate-200',
    ];
@endphp

<div class="w-full">
    <section class="bg-white border-b border-slate-200/80 py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Jejaring Awardee FMIPA
                    </span>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Direktori Alumni Penerima Beasiswa</h1>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Temukan alumni awardee FMIPA Unila yang bersedia berbagi pengalaman dan mentoring melalui jaringan profesional mereka.
                    </p>
                </div>
                @auth
                    @if(auth()->user()->role === 'mahasiswa')
                        <a href="{{ route('tracer.form') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors shrink-0">
                            Isi / Perbarui Tracer Study
                        </a>
                    @endif
                @endauth
            </div>

            <form method="GET" action="{{ route('tracer.index') }}" class="bg-slate-50 border border-slate-200 rounded-2xl p-4 grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-6 relative">
                    <label for="search" class="sr-only">Cari alumni, instansi, jabatan, atau kota</label>
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama alumni, jabatan, instansi, atau kota..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 placeholder-slate-400">
                </div>
                <div class="md:col-span-3">
                    <label for="major" class="sr-only">Filter jurusan</label>
                    <select id="major" name="major" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        <option value="">Semua Jurusan</option>
                        @foreach($majors as $major)
                            <option value="{{ $major }}" @selected(($filters['major'] ?? '') === $major)>{{ $major }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3 flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">Cari Alumni</button>
                    @if(($filters['search'] ?? null) || ($filters['major'] ?? null))
                        <a href="{{ route('tracer.index') }}" class="px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-xs font-semibold hover:bg-slate-100">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tracers as $tracer)
                @php
                    $nameParts = preg_split('/\s+/', trim($tracer->user->name)) ?: [];
                    $initials = strtoupper(
                        substr($nameParts[0] ?? 'A', 0, 1) .
                        substr($nameParts[1] ?? ($nameParts[0] ?? 'L'), 0, 1)
                    );
                    $statusKey = $tracer->employment_status;
                    $statusLabel = $employmentStatuses[$statusKey] ?? 'Alumni Awardee';
                    $statusClass = $statusBadgeClasses[$statusKey] ?? 'bg-blue-50 text-blue-700 border-blue-200';
                    $linkedinUrl = filter_var($tracer->contact_linkedin, FILTER_VALIDATE_URL) ? $tracer->contact_linkedin : null;
                @endphp
                <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-base shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-900 text-sm truncate">{{ $tracer->user->name }}</h3>
                                <p class="text-[11px] text-slate-500 font-medium">{{ $tracer->user->major ?: 'FMIPA Unila' }}</p>
                            </div>
                        </div>

                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                            <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200/60">
                                Siap Berbagi
                            </span>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100 text-xs space-y-1 mb-6">
                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Aktivitas / Karir Saat Ini</p>
                            <p class="font-bold text-slate-800">{{ $tracer->job_title ?: $statusLabel }}</p>
                            <p class="text-[11px] text-slate-500">
                                {{ $tracer->company_name ?: 'Instansi belum dicantumkan' }}
                                @if($tracer->city)
                                    · {{ $tracer->city }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-400">Kontak Profesional:</span>
                        @if($linkedinUrl)
                            <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 font-semibold text-[11px] hover:bg-blue-100 transition-colors">
                                LinkedIn
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6L10 14M5 7H4a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1v-1"/></svg>
                            </a>
                        @else
                            <span class="text-[11px] text-slate-400">Tautan belum diisi</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3 bg-white border border-slate-200 rounded-2xl p-12 text-center">
                    <p class="text-sm font-semibold text-slate-700">Belum ada alumni yang ditampilkan</p>
                    <p class="text-xs text-slate-400 mt-1">Alumni awardee yang telah lulus dan memilih opsi bersedia berbagi akan muncul di direktori ini.</p>
                </div>
            @endforelse
        </div>

        @if($tracers->hasPages())
            <div class="mt-8">
                {{ $tracers->links() }}
            </div>
        @endif
    </section>
</div>
@endsection
