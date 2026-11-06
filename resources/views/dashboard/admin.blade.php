@extends('layouts.app')

@section('title', 'Dashboard Administrator')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Ringkasan Sistem Beasiswa FMIPA</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau status pendaftar, proses verifikasi berjenjang, dan evaluasi KHS awardee.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200/80">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                T.A. 2026/2027 Ganjil
            </span>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Pendaftar</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-1">184</h3>
                <p class="text-[11px] text-emerald-600 font-semibold mt-1">↑ 12% dari semester lalu</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Verifikasi Akhir</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-1">42</h3>
                <p class="text-[11px] text-amber-600 font-semibold mt-1">Menunggu approval subbag</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Peringatan EWS</p>
                <h3 class="text-2xl font-extrabold text-rose-600 mt-1">7</h3>
                <p class="text-[11px] text-rose-500 font-semibold mt-1">IPK di bawah batas syarat</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Awardee Aktif</p>
                <h3 class="text-2xl font-extrabold text-blue-600 mt-1">112</h3>
                <p class="text-[11px] text-slate-400 font-medium mt-1">Tersebar di 5 Jurusan</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
            </div>
        </div>
    </div>

    <!-- Tabel Verifikasi -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Menunggu Verifikasi Akhir (Subbag)</h2>
                <p class="text-xs text-slate-400">Berkas yang sudah lolos seleksi awal dari Dosen Pembimbing Akademik.</p>
            </div>
            <a href="{{ route('verifikasi.akhir') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Mahasiswa</th>
                        <th class="px-6 py-3.5">Program Beasiswa</th>
                        <th class="px-6 py-3.5">IPK Terakhir</th>
                        <th class="px-6 py-3.5">Status Dosen PA</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">Ahmad Fauzi</p>
                            <p class="text-[11px] text-slate-400">2217051001 · S1 Ilmu Komputer</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">Beasiswa Bank Indonesia</td>
                        <td class="px-6 py-4 font-bold text-blue-700">3.88</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Disetujui PA
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('verifikasi.detail') }}" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-medium text-[11px] hover:bg-blue-700">Periksa</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">Lestari Putri</p>
                            <p class="text-[11px] text-slate-400">2317041020 · S1 Fisika</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">Djarum Beasiswa Plus</td>
                        <td class="px-6 py-4 font-bold text-blue-700">3.65</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Disetujui PA
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('verifikasi.detail') }}" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-medium text-[11px] hover:bg-blue-700">Periksa</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection