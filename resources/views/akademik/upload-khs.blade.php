@extends('layouts.app')

@section('title', 'Pelaporan KHS & Evaluasi IPK')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Unggah KHS & Monitoring IPK</h1>
            <p class="text-xs text-slate-500 mt-1">Pelaporan capaian akademik berkala untuk evaluasi keberlanjutan beasiswa (Early Warning System).</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Status Akademik: Aman (EWS Normal)
            </span>
        </div>
    </div>

    <!-- Banner Ringkasan Standar EWS Beasiswa Aktif -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Beasiswa Aktif</p>
            <h3 class="text-base font-bold text-slate-800 mt-1">Bank Indonesia (GenBI)</h3>
            <p class="text-[11px] text-blue-600 font-medium mt-1">Wajib lapor tiap semester</p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Batas Minimal IPK (Ambang Batas)</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">3.00</h3>
            <p class="text-[11px] text-amber-600 font-medium mt-1">IPK &lt; 3.00 memicu peringatan Dosen PA</p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">IPK Kumulatif Saat Ini</p>
            <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">3.96</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1">✓ Di atas ambang batas syarat</p>
        </div>
    </div>

    <!-- Form Unggah KHS Semester Berjalan -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
        <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-6">
            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Form Laporan KHS Baru</h3>
                <p class="text-[11px] text-slate-400">Masukkan nilai resmi sesuai Kartu Hasil Studi yang telah divalidasi pembimbing akademik.</p>
            </div>
        </div>

        <form action="{{ route('mahasiswa.akademik.upload') }}" method="GET" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Pilih Semester Dilaporkan <span class="text-rose-500">*</span></label>
                    <select class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                        <option value="5" selected>Semester 5 (Ganjil 2026/2027)</option>
                        <option value="4">Semester 4 (Genap 2025/2026)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Indeks Prestasi Semester (IPS) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" min="0" max="4.00" placeholder="Contoh: 3.85" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Indeks Prestasi Kumulatif (IPK) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" min="0" max="4.00" placeholder="Contoh: 3.96" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                </div>
            </div>

            <!-- Upload File KHS PDF -->
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-blue-400 transition-colors bg-slate-50/50">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </div>
                <p class="text-xs font-bold text-slate-800 mb-1">Pilih atau seret berkas KHS resmi (PDF)</p>
                <p class="text-[11px] text-slate-400 mb-3">Ukuran maksimal file 2 MB. Pastikan barcode atau tanda tangan sah terlihat jelas.</p>
                <label class="inline-flex cursor-pointer px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-all shadow-xs">
                    <span>Jelajahi File Komputer</span>
                    <input type="file" accept=".pdf" class="hidden">
                </label>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 shadow-sm shadow-blue-200 transition-all flex items-center gap-2">
                    <span>Simpan & Kirim KHS</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Pelaporan KHS Terdahulu -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-800">Riwayat Nilai Semester & Berkas KHS</h3>
                <p class="text-xs text-slate-400">Rekam jejak evaluasi akademik yang telah diperiksa oleh Dosen PA.</p>
            </div>
            <span class="text-xs font-medium text-slate-500">4 Semester Terlaporkan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Semester</th>
                        <th class="px-6 py-3.5">Tahun Ajaran</th>
                        <th class="px-6 py-3.5">IPS</th>
                        <th class="px-6 py-3.5">IPK</th>
                        <th class="px-6 py-3.5">Status EWS</th>
                        <th class="px-6 py-3.5 text-right">Berkas KHS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">Semester 4</td>
                        <td class="px-6 py-4 text-slate-500">2025/2026 Genap</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">4.00</td>
                        <td class="px-6 py-4 font-bold text-emerald-600">3.96</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Normal / Aman
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="text-blue-600 hover:underline font-medium text-[11px] inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                KHS_Sem4.pdf
                            </a>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">Semester 3</td>
                        <td class="px-6 py-4 text-slate-500">2025/2026 Ganjil</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">3.92</td>
                        <td class="px-6 py-4 font-bold text-emerald-600">3.94</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Normal / Aman
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="text-blue-600 hover:underline font-medium text-[11px] inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                KHS_Sem3.pdf
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection