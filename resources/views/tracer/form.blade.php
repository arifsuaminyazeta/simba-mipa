@extends('layouts.app')

@section('title', 'Kuesioner Tracer Alumni Beasiswa')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Formulir Tracer Alumni Beasiswa</h1>
            <p class="text-xs text-slate-500 mt-1">Bantu adik tingkat menemukan rekam jejak Anda dan dukung akreditasi beasiswa FMIPA Unila.</p>
        </div>
        <a href="{{ route('tracer.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition-all">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Lihat Direktori Publik</span>
        </a>
    </div>

    <form action="{{ route('tracer.index') }}" method="GET" class="space-y-6">
        <!-- 1. Data Riwayat Kelulusan -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                    01
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Riwayat Awardee & Akademik</h3>
                    <p class="text-[11px] text-slate-400">Informasi program beasiswa yang pernah didapatkan selama masa studi.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Program Beasiswa Pernah Diterima <span class="text-rose-500">*</span></label>
                    <input type="text" value="Beasiswa Bank Indonesia (GenBI)" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-semibold cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Tahun / Periode Menerima Beasiswa</label>
                    <input type="text" value="2025 - 2026" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Status Saat Ini <span class="text-rose-500">*</span></label>
                    <select class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                        <option value="bekerja" selected>Bekerja Penuh Waktu (Full-time)</option>
                        <option value="wirausaha">Wirausaha / Founder</option>
                        <option value="studi">Melanjutkan Studi (S2)</option>
                        <option value="mencari">Sedang Mencari Peluang Kerja</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Tahun Kelulusan / Wisuda</label>
                    <input type="text" placeholder="Contoh: 2026" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                </div>
            </div>
        </div>

        <!-- 2. Profil Pekerjaan & Instansi -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                    02
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Aktivitas Karir Saat Ini</h3>
                    <p class="text-[11px] text-slate-400">Data perusahaan atau instansi tempat Anda berkiprah saat ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Nama Perusahaan / Institusi <span class="text-rose-500">*</span></label>
                    <input type="text" placeholder="Contoh: PT Telkom Indonesia" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Posisi / Jabatan Pekerjaan <span class="text-rose-500">*</span></label>
                    <input type="text" placeholder="Contoh: Junior Software Engineer" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Lokasi Kerja (Kota / Negara)</label>
                    <input type="text" placeholder="Contoh: Jakarta Selatan, DKI Jakarta" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                </div>
            </div>
        </div>

        <!-- 3. Tautan Media Sosial & Kontak Publik -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                    03
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Tautan Kontak & Mentoring</h3>
                    <p class="text-[11px] text-slate-400">Beri akses media sosial agar adik tingkat FMIPA dapat menghubungi untuk konsultasi beasiswa.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">URL Profil LinkedIn</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs font-mono">https://</span>
                        <input type="text" placeholder="linkedin.com/in/username" class="w-full pl-16 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Username Instagram (Opsional)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs font-mono">@</span>
                        <input type="text" placeholder="username" class="w-full pl-8 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 shadow-sm shadow-blue-200 transition-all flex items-center gap-2">
                <span>Perbarui Data Tracer</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </form>
</div>
@endsection