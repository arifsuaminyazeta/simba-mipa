@extends('layouts.app')

@section('title', 'Status Pendaftaran Beasiswa')

@section('content')
<div class="space-y-8">
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Status Pendaftaran Beasiswa</h1>
            <p class="text-xs text-slate-500 mt-1">Lacak tahapan verifikasi berkas, persetujuan Dosen PA, dan keputusan Subbag Kemahasiswaan FMIPA.</p>
        </div>
        <a href="{{ route('pendaftaran.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 shadow-xs transition-all self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Daftar Beasiswa Baru</span>
        </a>
    </div>

    <!-- Kartu Tracking Berkas Aktif (Prioritas) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                        Periode Genap 2026/2027
                    </span>
                    <span class="text-xs text-slate-400">Diajukan: 28 Oktober 2026</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900">Beasiswa Bank Indonesia (GenBI)</h2>
                <p class="text-xs text-slate-500">Nomor Registrasi: <span class="font-mono font-semibold text-slate-700">REG-FMIPA-2026-0042</span></p>
            </div>
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    Menunggu Verifikasi Subbag
                </span>
            </div>
        </div>

        <!-- Stepper Alur 2 Tingkat -->
        <div class="pt-6">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-5">Progres Verifikasi Berkas Berjenjang</p>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative">

                <!-- Step 1: Berkas Diunggah -->
                <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/60 border border-emerald-100">
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                        ✓
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-900">1. Unggah Berkas</p>
                        <p class="text-[11px] text-emerald-700 font-medium">Selesai diunggah</p>
                        <span class="text-[10px] text-slate-400">28 Okt 2026 · 14:20</span>
                    </div>
                </div>

                <!-- Step 2: Dosen PA -->
                <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/60 border border-emerald-100">
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                        ✓
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-900">2. Review Dosen PA</p>
                        <p class="text-[11px] text-emerald-700 font-medium">Disetujui Dosen PA</p>
                        <span class="text-[10px] text-slate-400">Dr. Kurniawan, M.Cs.</span>
                    </div>
                </div>

                <!-- Step 3: Subbag Kemahasiswaan -->
                <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-50/70 border border-amber-200">
                    <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs font-bold shrink-0">
                        3
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-900">3. Verifikasi Subbag</p>
                        <p class="text-[11px] text-amber-700 font-medium">Sedang Diperiksa</p>
                        <span class="text-[10px] text-slate-400">Estimasi: 3 hari kerja</span>
                    </div>
                </div>

                <!-- Step 4: Penetapan Final -->
                <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200/80 opacity-60">
                    <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-bold shrink-0">
                        4
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">4. Penetapan Awardee</p>
                        <p class="text-[11px] text-slate-400">Menunggu Tahap 3</p>
                        <span class="text-[10px] text-slate-400">Pengumuman SK Dekan</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Semua Pendaftaran -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-800">Riwayat Pengajuan Beasiswa</h3>
                <p class="text-xs text-slate-400">Daftar semua permohonan beasiswa yang pernah kamu daftarkan.</p>
            </div>
            <span class="text-xs font-medium text-slate-500">Total 2 Pengajuan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Program Beasiswa</th>
                        <th class="px-6 py-3.5">Semester Pengajuan</th>
                        <th class="px-6 py-3.5">Tanggal Daftar</th>
                        <th class="px-6 py-3.5">Status Akhir</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Row 1: Aktif -->
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">Beasiswa Bank Indonesia</p>
                            <p class="text-[11px] text-slate-400">Bantuan Biaya UKT & Pelatihan</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">Semester 5 (2026/2027)</td>
                        <td class="px-6 py-4 text-slate-500">28 Oktober 2026</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                Proses Verifikasi
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('pendaftaran.show') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-[11px] hover:bg-slate-50 transition-colors">
                                Lihat Berkas
                            </a>
                        </td>
                    </tr>

                    <!-- Row 2: Riwayat Lalu -->
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">Djarum Beasiswa Plus</p>
                            <p class="text-[11px] text-slate-400">Program Prestasi & Softskills</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">Semester 4 (2025/2026)</td>
                        <td class="px-6 py-4 text-slate-500">12 Mei 2026</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Diterima (Selesai)
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('pendaftaran.show') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-[11px] hover:bg-slate-50 transition-colors">
                                Arsip Berkas
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection