@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Beasiswa')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('pendaftaran.index') }}" class="text-xs font-semibold text-blue-600 hover:underline flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Status Pendaftaran
                </a>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Formulir Pengajuan Beasiswa</h1>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi data dan dokumen persyaratan untuk diteruskan ke Dosen PA dan Subbag Kemahasiswaan.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200">
                Tahap 1: Verifikasi Berkas
            </span>
        </div>
    </div>

    <form action="{{ route('pendaftaran.index') }}" method="GET" class="space-y-6">
        <!-- 1. Bagian Identitas Akademik Terverifikasi (Readonly) -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                    01
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Data Akademik Pemohon (Tersinkronisasi SSO)</h3>
                    <p class="text-[11px] text-slate-400">Data berikut diambil otomatis dari pangkalan data akademik FMIPA Unila.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Nama Lengkap Mahasiswa</label>
                    <input type="text" value="M. Surya Gymnastyar" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Nomor Pokok Mahasiswa (NPM)</label>
                    <input type="text" value="2417051000" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-mono font-medium cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Program Studi</label>
                    <input type="text" value="S1 Ilmu Komputer" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Semester Aktif</label>
                    <input type="text" value="Semester 5 (Ganjil 2026/2027)" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">IPK Kumulatif Terakhir</label>
                    <input type="text" value="3.96" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-emerald-600 font-bold cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Dosen Pembimbing Akademik (PA)</label>
                    <input type="text" value="Dr. Kurniawan, M.Cs." readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-blue-700 font-semibold cursor-not-allowed">
                </div>
            </div>
        </div>

        <!-- 2. Pemilihan Program Beasiswa -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                    02
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Pilihan Beasiswa</h3>
                    <p class="text-[11px] text-slate-400">Pilih program beasiswa yang sedang membuka kuota pendaftaran.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Program Beasiswa yang Dilamar <span class="text-rose-500">*</span></label>
                    <select class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                        <option value="bi" selected>Beasiswa Bank Indonesia (GenBI) — Kuota: 30 Mahasiswa</option>
                        <option value="djarum">Djarum Beasiswa Plus — Kuota: 15 Mahasiswa</option>
                        <option value="pertamina">Beasiswa Pertamina Sobat Bumi — Kuota: 10 Mahasiswa</option>
                    </select>
                </div>

                <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-100 text-xs text-blue-800 space-y-1">
                    <p class="font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Syarat Khusus Beasiswa Bank Indonesia:
                    </p>
                    <ul class="list-disc list-inside text-[11px] text-blue-700 space-y-0.5 ml-1">
                        <li>IPK minimal 3.00 (skala 4.00)</li>
                        <li>Telah menyelesaikan minimal 40 SKS</li>
                        <li>Tidak sedang menerima beasiswa lain dari instansi manapun</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 3. Unggah Berkas Persyaratan (PDF) -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                    03
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Unggah Dokumen Berkas</h3>
                    <p class="text-[11px] text-slate-400">Format yang diterima adalah PDF dengan ukuran maksimal 2 MB per file.</p>
                </div>
            </div>

            <div class="space-y-5">
                <!-- File 1: Transkrip / KHS -->
                <div class="border border-slate-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-0.5">
                        <p class="text-xs font-bold text-slate-800">1. Transkrip Nilai / KHS Kumulatif Terakhir <span class="text-rose-500">*</span></p>
                        <p class="text-[11px] text-slate-400">KHS resmi berbarcode atau bertandatangan Dosen PA.</p>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <label class="cursor-pointer px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold flex items-center gap-2 transition-all">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span>Pilih Berkas PDF</span>
                            <input type="file" accept=".pdf" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- File 2: Surat Pernyataan Bebas Beasiswa -->
                <div class="border border-slate-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <p class="text-xs font-bold text-slate-800">2. Surat Pernyataan Tidak Menerima Beasiswa Lain <span class="text-rose-500">*</span></p>
                            <a href="#" class="text-[10px] text-blue-600 font-semibold hover:underline flex items-center gap-0.5">
                                [Unduh Template]
                            </a>
                        </div>
                        <p class="text-[11px] text-slate-400">Bermaterai Rp 10.000 dan ditandatangani pemohon.</p>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <label class="cursor-pointer px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold flex items-center gap-2 transition-all">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span>Pilih Berkas PDF</span>
                            <input type="file" accept=".pdf" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- File 3: Esai Motivasi -->
                <div class="border border-slate-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-0.5">
                        <p class="text-xs font-bold text-slate-800">3. Esai Motivasi / Rencana Kontribusi Sosial <span class="text-rose-500">*</span></p>
                        <p class="text-[11px] text-slate-400">Maksimal 2 halaman A4 font Times New Roman 12.</p>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <label class="cursor-pointer px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold flex items-center gap-2 transition-all">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span>Pilih Berkas PDF</span>
                            <input type="file" accept=".pdf" class="hidden">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Pernyataan Kejujuran & Submit -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" required class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <span class="text-xs text-slate-600 leading-snug">
                    Saya menyatakan bahwa seluruh berkas yang diunggah adalah sah dan benar. Jika terbukti ada manipulasi, saya bersedia menerima sanksi akademik sesuai aturan FMIPA Unila.
                </span>
            </label>

            <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 shadow-sm shadow-blue-200 shrink-0 flex items-center gap-2 transition-all">
                <span>Kirim Pengajuan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </form>
</div>
@endsection