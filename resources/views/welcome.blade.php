@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-blue-50/60 to-transparent py-16 lg:py-24 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center">
        <!-- Badge Info -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100/70 border border-blue-200 text-blue-700 text-xs font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
            <span>Pendaftaran Periode Genap 2026 Dibuka</span>
        </div>

        <h1 class="text-3xl lg:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto leading-tight mb-4">
            Sistem Informasi Pengelolaan Beasiswa Terpadu FMIPA
        </h1>
        <p class="text-sm lg:text-base text-slate-500 max-w-2xl mx-auto mb-8 leading-relaxed">
            Portal resmi pendaftaran, monitoring verifikasi dua tingkat, pelaporan KHS, dan tracking alumni beasiswa Fakultas MIPA Universitas Lampung.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('beasiswa.katalog') }}" class="px-6 py-3 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 shadow-sm shadow-blue-200 transition-all flex items-center gap-2">
                <span>Eksplorasi Beasiswa</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="{{ route('dashboard.admin') }}" class="px-6 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-all">
                Pratinjau Dashboard Admin
            </a>
        </div>
    </div>
</section>

<!-- Fitur Utama -->
<section class="py-16 max-w-7xl mx-auto px-6 lg:px-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-2">Verifikasi 2 Tingkat</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Penyaringan berkas berjenjang melalui Dosen Pembimbing Akademik (PA) sebelum diteruskan ke Subbag Kemahasiswaan.</p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-2">Early Warning System</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Pemantauan otomatis IPK awardee tiap semester dengan notifikasi evaluasi cepat sebelum evaluasi beasiswa.</p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-2">Tracer Study & Alumni</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Pelacakan riwayat kelulusan dan rekam jejak karir bagi penerima program beasiswa FMIPA.</p>
        </div>
    </div>
</section>
@endsection