@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="space-y-8">
    <!-- Header Sambutan -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Halo, Surya! 👋</h1>
            <p class="text-xs text-slate-500 mt-1">Selamat datang di portal SIMBA-MIPA. Pantau status beasiswa dan pengajuan Anda.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                Status: Awardee Aktif
            </span>
        </div>
    </div>

    <!-- Alert Notifikasi Tindakan (KHS) -->
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-4">
        <div class="p-2 bg-blue-600 text-white rounded-xl shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h4 class="text-xs font-bold text-blue-900">Periode Evaluasi KHS Semester Genap 2026/2027</h4>
                <p class="text-[11px] text-blue-700 mt-0.5">Harap unggah KHS terbaru sebelum batas akhir 20 November 2026 untuk monitoring Early Warning System (EWS).</p>
            </div>
            <a href="{{ route('mahasiswa.akademik.upload') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 shrink-0">
                <span>Unggah Sekarang</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>

    <!-- Grid Ringkasan Mahasiswa -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Beasiswa Diterima</p>
            <h3 class="text-lg font-extrabold text-slate-800 mt-1">Bank Indonesia</h3>
            <p class="text-[11px] text-blue-600 font-semibold mt-1">Periode 2026/2027</p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">IPK Terakhir</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">3.96</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1">✓ Memenuhi syarat aman EWS</p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Dosen PA</p>
            <h3 class="text-sm font-bold text-slate-800 mt-1">Dr. Kurniawan, M.Cs.</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-1">Jurusan Ilmu Komputer</p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Semester Berjalan</p>
            <h3 class="text-2xl font-extrabold text-blue-600 mt-1">Semester 5</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-1">T.A. 2026/2027</p>
        </div>
    </div>

    <!-- Riwayat Pengajuan & Verifikasi 2 Tingkat -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Status Pengajuan Beasiswa Anda</h2>
                <p class="text-xs text-slate-400">Tahapan verifikasi berkas oleh Dosen Pembimbing Akademik dan Subbag Kemahasiswaan.</p>
            </div>
            <a href="{{ route('mahasiswa.beasiswa.katalog') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">+ Daftar Beasiswa Baru</a>
        </div>
        <div class="p-6">
            <div class="border border-slate-100 rounded-2xl p-5 bg-slate-50/50">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-200">
                    <div>
                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 mb-1">Beasiswa Bank Indonesia (GenBI)</span>
                        <h3 class="text-base font-bold text-slate-900">Seleksi Awardee Lanjutan Periode 2026</h3>
                        <p class="text-xs text-slate-400">Diajukan pada: 28 Oktober 2026</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 self-start md:self-auto">
                        ✓ Berkas Diterima & Disetujui
                    </span>
                </div>

                <!-- Tracker Step Verifikasi -->
                <div class="pt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0">✓</div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">1. Unggah Berkas</p>
                            <p class="text-[11px] text-slate-400">KRS, Transkrip & Esai lengkap</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0">✓</div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">2. Verifikasi Dosen PA</p>
                            <p class="text-[11px] text-slate-400">Disetujui oleh Dr. Kurniawan</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0">✓</div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">3. Verifikasi Subbag MIPA</p>
                            <p class="text-[11px] text-slate-400">Lolos verifikasi tingkat akhir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection