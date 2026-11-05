@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Verifikasi Awal')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800">Verifikasi Berkas Mahasiswa</h1>
        <p class="text-sm text-slate-500 mt-1">
            Periksa kelengkapan berkas pendaftaran beasiswa mahasiswa bimbingan.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
            <h2 class="text-3xl font-bold text-amber-500 mt-2">{{ $countPending }}</h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Terverifikasi</p>
            <h2 class="text-3xl font-bold text-emerald-600 mt-2">{{ $countVerified }}</h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Ditolak</p>
            <h2 class="text-3xl font-bold text-red-500 mt-2">{{ $countRejected }}</h2>
        </div>

    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5">

        <form method="GET" class="mb-5 flex gap-3">

            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama mahasiswa..."
                   class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm">

            <button class="bg-blue-600 text-white px-5 rounded-xl text-sm font-semibold">
                Cari
            </button>

        </form>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-500 uppercase">
                        <th class="px-3 py-4">No</th>
                        <th class="px-3 py-4">Mahasiswa</th>
                        <th class="px-3 py-4">Beasiswa</th>
                        <th class="px-3 py-4">IPK</th>
                        <th class="px-3 py-4">Status</th>
                        <th class="px-3 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($applications as $item)

                    <tr class="hover:bg-slate-50">

                        <td class="px-3 py-4">
                            {{ $applications->firstItem() + $loop->index }}
                        </td>

                        <td class="px-3 py-4">
                            <p class="font-semibold text-slate-800">
                                {{ $item->user->name }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $item->user->email }}
                            </p>
                        </td>

                        <td class="px-3 py-4 text-slate-600">
                            {{ $item->scholarship->name }}
                        </td>

                        <td class="px-3 py-4 font-semibold">
                            {{ number_format($item->gpa_score, 2) }}
                        </td>

                        <td class="px-3 py-4">
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                Menunggu
                            </span>
                        </td>

                        <td class="px-3 py-4 text-center">
                            <a href="{{ route('verifikasi.detail', $item->id) }}"
                               class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">
                                Periksa Berkas
                            </a>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center py-12 text-slate-400">
                            Tidak ada berkas yang menunggu verifikasi.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-5">
            {{ $applications->links() }}
        </div>

    </div>

=======
@section('title', 'Verifikasi Berkas Mahasiswa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 mb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Verifikasi Berkas Rekomendasi</h1>
            <p class="text-xs text-slate-500 mt-1">Periksa kelayakan berkas akademik mahasiswa bimbingan Anda sebelum diteruskan ke Subbag Kemahasiswaan FMIPA.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                3 Menunggu Review
            </span>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-4 flex flex-col md:flex-row items-center justify-between gap-3 shadow-xs">
        <div class="relative w-full md:w-80">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" placeholder="Cari nama atau NPM bimbingan..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 placeholder-slate-400">
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <select class="w-full md:w-48 px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-blue-600">
                <option value="">Semua Beasiswa</option>
                <option value="bi">Bank Indonesia</option>
                <option value="djarum">Djarum Beasiswa Plus</option>
                <option value="alumni">Subsidi Alumni FMIPA</option>
            </select>
        </div>
    </div>

    <!-- Tabel Pengajuan Masuk -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Mahasiswa</th>
                        <th class="px-6 py-3.5">Program Beasiswa</th>
                        <th class="px-6 py-3.5">IPK Kumulatif</th>
                        <th class="px-6 py-3.5">Kelengkapan Berkas</th>
                        <th class="px-6 py-3.5">Tanggal Ajuan</th>
                        <th class="px-6 py-3.5 text-right">Aksi Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">

                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">M. Surya Gymnastyar</p>
                            <p class="text-[11px] text-slate-400">2417051011 · S1 Ilmu Komputer</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800">Beasiswa Bank Indonesia</span>
                            <p class="text-[10px] text-blue-600 font-medium">Jalur Prestasi Akademik</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                3.96
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                KHS_Surya.pdf
                            </a>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-[11px]">02 Nov 2026</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" class="px-3.5 py-1.5 rounded-xl border border-emerald-300 bg-white hover:bg-emerald-50 text-emerald-600 font-semibold text-[11px] transition-all shadow-xs">
                                    Setujui
                                </button>
                                <button type="button" class="px-3.5 py-1.5 rounded-xl border border-slate-200 hover:border-rose-200 hover:bg-rose-50 text-rose-600 font-semibold text-[11px] transition-all">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">Zahira Adiah Safa</p>
                            <p class="text-[11px] text-slate-400">2417051012 · S1 Ilmu Komputer</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800">Djarum Beasiswa Plus</span>
                            <p class="text-[10px] text-blue-600 font-medium">Prestasi & Karakter</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                3.82
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                KHS_Zahira.pdf
                            </a>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-[11px]">03 Nov 2026</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" class="px-3.5 py-1.5 rounded-xl border border-emerald-300 bg-white hover:bg-emerald-50 text-emerald-600 font-semibold text-[11px] transition-all shadow-xs">
                                    Setujui
                                </button>
                                <button type="button" class="px-3.5 py-1.5 rounded-xl border border-slate-200 hover:border-rose-200 hover:bg-rose-50 text-rose-600 font-semibold text-[11px] transition-all">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">Muhamad Arif</p>
                            <p class="text-[11px] text-slate-400">2417051045 · S1 Ilmu Komputer</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800">Subsidi UKT Ikatan Alumni FMIPA</span>
                            <p class="text-[10px] text-slate-500 font-medium">Bantuan Finansial</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                3.45
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                KHS_Arif.pdf
                            </a>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-[11px]">04 Nov 2026</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" class="px-3.5 py-1.5 rounded-xl border border-emerald-300 bg-white hover:bg-emerald-50 text-emerald-600 font-semibold text-[11px] transition-all shadow-xs">
                                    Setujui
                                </button>
                                <button type="button" class="px-3.5 py-1.5 rounded-xl border border-slate-200 hover:border-rose-200 hover:bg-rose-50 text-rose-600 font-semibold text-[11px] transition-all">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
>>>>>>> b4c6963906172a967ddd1282b55f9904310ba510
</div>
@endsection