@extends('layouts.app')

@section('title', 'Monitoring EWS Bimbingan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 mb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Early Warning System (EWS) Akademik</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau tren dan stabilitas IPK mahasiswa bimbingan penerima beasiswa untuk mencegah sanksi evaluasi mitra.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200/80">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Ambang Batas Minimum: IPK 3.00
            </span>
        </div>
    </div>

    <!-- Ringkasan Status EWS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Aman</p>
                <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">26 Mahasiswa</h3>
                <p class="text-[11px] text-slate-400 mt-1">IPK &ge; 3.25 (Stabil/Meningkat)</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peringatan / Warning</p>
                <h3 class="text-2xl font-extrabold text-amber-500 mt-1">1 Mahasiswa</h3>
                <p class="text-[11px] text-slate-400 mt-1">3.00 &le; IPK &lt; 3.20 (Tren Menurun)</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kritis / Bahaya</p>
                <h3 class="text-2xl font-extrabold text-rose-600 mt-1">1 Mahasiswa</h3>
                <p class="text-[11px] text-rose-500 mt-1 font-semibold">IPK &lt; 3.00 (Butuh Evaluasi)</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </div>
    </div>

    <!-- Tabel Monitoring Mahasiswa Bimbingan -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden mt-8">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Daftar Mahasiswa Bimbingan Penerima Beasiswa</h2>
                <p class="text-xs text-slate-400 mt-0.5">Evaluasi riwayat KHS Semester Ganjil 2026/2027.</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-lg bg-slate-100 text-slate-600">Total: 28 Mahasiswa</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5 w-1/4">Mahasiswa</th>
                        <th class="px-6 py-3.5 w-1/4">Program Beasiswa</th>
                        <th class="px-4 py-3.5 text-center">IP Lalu</th>
                        <th class="px-4 py-3.5 text-center">IPK</th>
                        <th class="px-6 py-3.5 text-center">Indikator EWS</th>
                        <th class="px-6 py-3.5 text-center">Tindakan Dosen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">

                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 text-[13px]">M. Surya Gymnastyar</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">2417051011 · Semester 5</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 text-xs">Beasiswa Bank Indonesia</span>
                            <p class="text-[10px] text-blue-600">Reguler S1</p>
                        </td>
                        <td class="px-4 py-4 text-center text-slate-600 font-medium">3.94</td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                3.96
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                Aman &amp; Stabil
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center">
                                <button type="button" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-[11px] transition-all shadow-xs">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Lihat KHS</span>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 text-[13px]">FX Novryandhika W.</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">2457051011 · Semester 5</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 text-xs">Djarum Beasiswa Plus</span>
                            <p class="text-[10px] text-blue-600">Prestasi &amp; Karakter</p>
                        </td>
                        <td class="px-4 py-4 text-center text-slate-600 font-medium">3.30</td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                3.12
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span> 
                                Tren Menurun
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center">
                                <button type="button" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-amber-200 bg-amber-50/50 hover:bg-amber-100/60 text-amber-800 font-semibold text-[11px] transition-all shadow-xs">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>Kirim Peringatan</span>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 text-[13px]">Rizky Ramadhan</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">2317051088 · Semester 5</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 text-xs">Beasiswa Bank Indonesia</span>
                            <p class="text-[10px] text-slate-400">Reguler S1</p>
                        </td>
                        <td class="px-4 py-4 text-center text-slate-600 font-medium">3.05</td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                2.88
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span>
                                Di Bawah Batas
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center">
                                <button type="button" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-rose-200 bg-rose-50/50 hover:bg-rose-100/60 text-rose-700 font-semibold text-[11px] transition-all shadow-xs">
                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Konseling PA</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection