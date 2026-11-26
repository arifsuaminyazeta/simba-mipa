@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')

@section('title', $scholarship->name)

@section('content')
@php
    $authUser = auth()->user();
    $isRecommendationLocked = $authUser && ($authUser->is_awardee === true || $authUser->academic_status === 'lulus');
    $awardeesCount = (int) ($scholarship->awardees_count ?? 0);
    $remainingQuota = $scholarship->quota !== null
        ? max(0, $scholarship->quota - $awardeesCount)
        : null;
    $isOpen = $scholarship->status === 'open';
    $backRoute = $authUser?->role === 'admin'
        ? route('beasiswa.index')
        : ($authUser?->role === 'mahasiswa' ? route('mahasiswa.beasiswa.katalog') : route('beasiswa.katalog'));
@endphp

<div class="max-w-5xl mx-auto px-6 py-8 space-y-6">
    <div>
        <a href="{{ $backRoute }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-blue-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Katalog Beasiswa
        </a>
    </div>

    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-100">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $isOpen ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                    {{ $isOpen ? 'Pendaftaran Dibuka' : 'Pendaftaran Ditutup' }}
                </span>
                <span class="text-xs text-slate-500">
                    Periode: <strong>{{ $scholarship->open_date->format('d F Y') }}</strong> – <strong>{{ $scholarship->close_date->format('d F Y') }}</strong>
                </span>
            </div>

            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $scholarship->name }}</h1>
            <p class="text-sm font-semibold text-blue-600 mt-1">{{ $scholarship->provider }}</p>
        </div>

        <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-4">
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Deskripsi &amp; Persyaratan</h2>
                <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $scholarship->description ?: 'Belum ada deskripsi rinci yang ditambahkan untuk program beasiswa ini. Silakan periksa portal resmi penyelenggara atau hubungi bagian Kemahasiswaan FMIPA.' }}
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-5 space-y-3 text-xs">
                    <h3 class="font-bold text-slate-800 text-sm">Ringkasan Program</h3>
                    <div class="flex justify-between py-2 border-b border-slate-200/70">
                        <span class="text-slate-500">Minimal IPK</span>
                        <span class="font-bold text-slate-900">{{ number_format($scholarship->min_gpa, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-200/70">
                        <span class="text-slate-500">Kuota Penerima</span>
                        <span class="font-bold text-slate-900">
                            {{ $scholarship->quota === null ? 'Tanpa batas' : $scholarship->quota . ' orang' }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-200/70">
                        <span class="text-slate-500">Sisa Kuota</span>
                        <span class="font-bold text-blue-700">
                            {{ $scholarship->quota === null ? 'Tanpa batas' : $remainingQuota . ' orang' }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-slate-500">Total Pengajuan</span>
                        <span class="font-semibold text-slate-700">{{ $scholarship->applications_count ?? 0 }} pengajuan</span>
                    </div>
                </div>

                @if($isRecommendationLocked)
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-xs text-amber-800">
                        @if($authUser->academic_status === 'lulus')
                            Pengajuan surat rekomendasi dikunci karena status akademik Anda sudah <strong>Lulus</strong>.
                        @else
                            Pengajuan surat rekomendasi dikunci karena Anda tercatat sebagai <strong>Awardee Aktif</strong>.
                        @endif
                    </div>
                @endif

                <div class="flex flex-col gap-2.5">
                    @if($scholarship->registration_url)
                        <a href="{{ $scholarship->registration_url }}" target="_blank" rel="noopener noreferrer"
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors">
                            <span>Daftar di Portal Penyelenggara</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6L10 14M5 7H4a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1v-1"/></svg>
                        </a>
                    @endif

                    @if($isOpen && ! $isRecommendationLocked)
                        @if($authUser && $authUser->role === 'mahasiswa')
                            <a href="{{ route('mahasiswa.pendaftaran.create', ['scholarship_id' => $scholarship->id]) }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-blue-200 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition-colors">
                                Ajukan Surat Rekomendasi FMIPA
                            </a>
                        @elseif(! $authUser)
                            <a href="{{ route('login') }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors">
                                Masuk untuk Ajukan Rekomendasi
                            </a>
                        @endif
                    @elseif(! $isOpen)
                        <button type="button" disabled
                                class="w-full px-4 py-3 rounded-xl bg-slate-100 text-slate-400 text-xs font-bold cursor-not-allowed">
                            Pendaftaran Sudah Ditutup
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
