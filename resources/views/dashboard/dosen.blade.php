@extends('layouts.app')

@section('title', 'Dashboard Dosen Pembimbing Akademik')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Portal Dosen Pembimbing Akademik</h1>
            <p class="text-xs text-slate-500 mt-1">Verifikasi berkas rekomendasi beasiswa dan pantau stabilitas IPK mahasiswa bimbingan Anda.</p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-semibold border border-indigo-200">
            <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
            Jurusan Ilmu Komputer
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Perlu Verifikasi Awal</p>
            <p class="text-2xl font-extrabold text-amber-600 mt-1">3 Mahasiswa</p>
            <p class="text-[11px] text-slate-400 mt-1">Menunggu persetujuan Anda</p>
        </div>
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Mahasiswa Bimbingan</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">28 Orang</p>
            <p class="text-[11px] text-slate-400 mt-1">Total mahasiswa bimbingan PA</p>
        </div>
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Peringatan EWS Bimbingan</p>
            <p class="text-2xl font-extrabold text-rose-600 mt-1">1 Mahasiswa</p>
            <p class="text-[11px] text-rose-500 font-semibold mt-1">IPK di bawah 3.00</p>
        </div>
    </div>

    <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Pengajuan Rekomendasi Beasiswa Masuk</h2>
                <p class="text-xs text-slate-400">Verifikasi kelayakan akademik sebelum diteruskan ke Subbag Kemahasiswaan FMIPA.</p>
            </div>
            <a href="{{ route('verifikasi.awal') }}" class="shrink-0 text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Mahasiswa Bimbingan</th>
                        <th class="px-6 py-3.5">Beasiswa</th>
                        <th class="px-6 py-3.5">IPK</th>
                        <th class="px-6 py-3.5">Dokumen</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">M. Surya Gymnastyar</p>
                            <p class="text-[11px] text-slate-400">2417051000 · Semester 5</p>
                        </td>
                        <td class="px-6 py-4">Beasiswa Bank Indonesia</td>
                        <td class="px-6 py-4 font-bold text-emerald-600">3.96</td>
                        <td class="px-6 py-4 text-blue-600">Transkrip_Surya.pdf</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('verifikasi.awal') }}" class="inline-flex px-4 py-1.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">Verifikasi</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">Fajar Pratama</p>
                            <p class="text-[11px] text-slate-400">2317051042 · Semester 5</p>
                        </td>
                        <td class="px-6 py-4">Djarum Beasiswa Plus</td>
                        <td class="px-6 py-4 font-bold text-blue-600">3.40</td>
                        <td class="px-6 py-4 text-blue-600">Transkrip_Fajar.pdf</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('verifikasi.awal') }}" class="inline-flex px-4 py-1.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">Verifikasi</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
