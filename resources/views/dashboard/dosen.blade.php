@extends('layouts.app')

@section('title', 'Dashboard Dosen Pembimbing Akademik')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Portal Dosen Pembimbing Akademik</h1>
            <p class="text-xs text-slate-500 mt-1">Verifikasi berkas rekomendasi beasiswa dan pantau stabilitas IPK mahasiswa bimbingan Anda.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-semibold border border-indigo-200">
                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                Jurusan Ilmu Komputer
            </span>
        </div>
    </div>

    <!-- Metrik Dosen PA -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Perlu Verifikasi Awal</p>
                <h3 class="text-2xl font-extrabold text-amber-600 mt-1">3 Mahasiswa</h3>
                <p class="text-[11px] text-slate-400 mt-1">Menunggu persetujuan Anda</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Mahasiswa Bimbingan</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-1">28 Orang</h3>
                <p class="text-[11px] text-slate-400 mt-1">Total mahasiswa bimbingan PA</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Peringatan EWS Bimbingan</p>
                <h3 class="text-2xl font-extrabold text-rose-600 mt-1">1 Mahasiswa</h3>
                <p class="text-[11px] text-rose-500 font-semibold mt-1">IPK &lt; 3.00 (Butuh evaluasi)</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
    </div>

    <!-- Daftar Berkas Menunggu Verifikasi Dosen PA -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Pengajuan Rekomendasi Beasiswa Masuk</h2>
                <p class="text-xs text-slate-400">Verifikasi kelayakan akademik sebelum diteruskan ke Subbag Kemahasiswaan FMIPA.</p>
            </div>
            <a href="{{ route('verifikasi.awal') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Mahasiswa Bimbingan</th>
                        <th class="px-6 py-3.5">Beasiswa yang Diajukan</th>
                        <th class="px-6 py-3.5">IPK Kumulatif</th>
                        <th class="px-6 py-3.5">Dokumen</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">M. Surya Gymnastyar</p>
                            <p class="text-[11px] text-slate-400">2417051011 · Semester 5</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">Beasiswa Bank Indonesia</td>
                        <td class="px-6 py-4 font-bold text-emerald-600">3.96</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-blue-600 font-medium hover:underline cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                KHS_Surya.pdf
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('verifikasi.awal') }}" class="inline-flex items-center justify-center px-4 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[11px] transition-colors shadow-xs">
                                Verifikasi
                            </a>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">Zahira Adiah Safa</p>
                            <p class="text-[11px] text-slate-400">2417051012 · Semester 5</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">Djarum Beasiswa Plus</td>
                        <td class="px-6 py-4 font-bold text-blue-600">3.82</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-blue-600 font-medium hover:underline cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                KHS_Zahira.pdf
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('verifikasi.awal') }}" class="inline-flex items-center justify-center px-4 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[11px] transition-colors shadow-xs">
                                Verifikasi
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection