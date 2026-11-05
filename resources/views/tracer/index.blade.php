@extends('layouts.guest')

@section('title', 'Direktori Alumni Beasiswa')

@section('content')
<div class="w-full">
    <!-- Header & Filter Box -->
    <section class="bg-white border-b border-slate-200/80 py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="max-w-2xl mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Jejaring Awardee FMIPA
                </span>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Direktori Alumni Penerima Beasiswa</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Temukan alumni penerima beasiswa FMIPA Unila dan hubungi via media sosial untuk tanya pengalaman atau bimbingan.
                </p>
            </div>

            <!-- Form Pencarian & Filter -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-6 relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" placeholder="Cari nama alumni atau tempat kerja..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 placeholder-slate-400">
                </div>
                <div class="md:col-span-3">
                    <select class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        <option value="">Semua Program Beasiswa</option>
                        <option value="bi">Bank Indonesia (GenBI)</option>
                        <option value="kip">KIP-Kuliah</option>
                        <option value="djarum">Djarum Beasiswa Plus</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <select class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        <option value="">Semua Jurusan</option>
                        <option value="ilkom">Ilmu Komputer</option>
                        <option value="matematika">Matematika</option>
                        <option value="fisika">Fisika</option>
                        <option value="kimia">Kimia</option>
                        <option value="biologi">Biologi</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Grid Card Alumni -->
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-base shrink-0">
                            RA
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Rian Anggara, S.Kom.</h3>
                            <p class="text-[11px] text-slate-500 font-medium">S1 Ilmu Komputer · Lulus 2025</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                            Beasiswa Bank Indonesia
                        </span>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-1 mb-6">
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Karir Saat Ini</p>
                        <p class="font-bold text-slate-800">Software Engineer</p>
                        <p class="text-[11px] text-slate-500">PT Telkom Indonesia · Jakarta</p>
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-[11px] text-slate-400">Tanya Pengalaman:</span>
                    <div class="flex items-center gap-2">
                        <a href="https://linkedin.com" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 font-medium text-[11px] hover:bg-blue-100">LinkedIn</a>
                        <a href="https://instagram.com" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-700 font-medium text-[11px] hover:bg-slate-200">Instagram</a>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-base shrink-0">
                            SN
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Siti Nurhaliza, S.Si.</h3>
                            <p class="text-[11px] text-slate-500 font-medium">S1 Matematika · Lulus 2024</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                            Djarum Beasiswa Plus
                        </span>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-1 mb-6">
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Karir Saat Ini</p>
                        <p class="font-bold text-slate-800">Data Analyst</p>
                        <p class="text-[11px] text-slate-500">Bank Central Asia (BCA) · Jakarta</p>
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-[11px] text-slate-400">Tanya Pengalaman:</span>
                    <a href="https://linkedin.com" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 font-medium text-[11px] hover:bg-blue-100">LinkedIn</a>
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-sky-600 text-white flex items-center justify-center font-bold text-base shrink-0">
                            DF
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Dimas Fajar, S.Si.</h3>
                            <p class="text-[11px] text-slate-500 font-medium">S1 Kimia · Lulus 2025</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200/60">
                            Beasiswa KIP-Kuliah
                        </span>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-1 mb-6">
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Karir Saat Ini</p>
                        <p class="font-bold text-slate-800">Quality Control</p>
                        <p class="text-[11px] text-slate-500">PT Kalbe Farma Tbk · Bekasi</p>
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-[11px] text-slate-400">Tanya Pengalaman:</span>
                    <div class="flex items-center gap-2">
                        <a href="https://linkedin.com" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 font-medium text-[11px] hover:bg-blue-100">LinkedIn</a>
                        <a href="https://instagram.com" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-700 font-medium text-[11px] hover:bg-slate-200">Instagram</a>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection