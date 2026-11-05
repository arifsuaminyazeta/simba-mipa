@extends('layouts.guest')

@section('title', 'Pengumuman Beasiswa')

@section('content')
<div class="w-full">
    <section class="bg-white border-b border-slate-200/80 py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    Pusat Informasi Resmi
                </span>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Pengumuman & Edaran</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Pemberitahuan terkini terkait hasil verifikasi, jadwal seleksi wawancara, dan ketentuan pelaporan akademik beasiswa.
                </p>
            </div>
        </div>
    </section>

    <!-- List Pengumuman -->
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        <div class="space-y-4">

            <article class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs hover:border-blue-300 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2 max-w-3xl">
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                            Hasil Seleksi
                        </span>
                        <span class="text-[11px] text-slate-400">04 November 2026 · Subbag Kemahasiswaan</span>
                    </div>
                    <h2 class="text-base font-bold text-slate-900 hover:text-blue-600 transition-colors">
                        Hasil Verifikasi Tingkat Akhir Penerima Beasiswa Bank Indonesia Tahap II 2026
                    </h2>
                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                        Berdasarkan hasil rapat pimpinan Dekanat FMIPA dan Tim Seleksi Bank Indonesia Lampung, berikut daftar nama mahasiswa yang dinyatakan lolos verifikasi akhir dan berhak mengikuti pembekalan.
                    </p>
                </div>
                <div class="shrink-0 flex items-center gap-2">
                    <a href="#" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-all">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh SK (PDF)</span>
                    </a>
                </div>
            </article>

            <article class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs hover:border-blue-300 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2 max-w-3xl">
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                            Penting / EWS
                        </span>
                        <span class="text-[11px] text-slate-400">01 November 2026 · Akademik</span>
                    </div>
                    <h2 class="text-base font-bold text-slate-900 hover:text-blue-600 transition-colors">
                        Batas Akhir Unggah KHS & Evaluasi IPK Awardee Semester Ganjil 2026/2027
                    </h2>
                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                        Diberitahukan kepada seluruh penerima beasiswa aktif untuk segera mengunggah KHS semester berjalan paling lambat 20 November 2026 sebagai syarat evaluasi Early Warning System (EWS).
                    </p>
                </div>
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ route('akademik.upload') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 hover:bg-blue-600 hover:text-white text-xs font-semibold transition-all">
                        <span>Unggah KHS</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </article>

            <article class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs hover:border-blue-300 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2 max-w-3xl">
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                            Agenda Seleksi
                        </span>
                        <span class="text-[11px] text-slate-400">28 Oktober 2026 · Tim Beasiswa</span>
                    </div>
                    <h2 class="text-base font-bold text-slate-900 hover:text-blue-600 transition-colors">
                        Jadwal Wawancara Tatap Muka Calon Penerima Beasiswa Djarum Plus 2026
                    </h2>
                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                        Mahasiswa yang lolos seleksi berkas tingkat Dosen PA diwajibkan hadir pada sesi wawancara di Gedung Dekanat Lantai 2 sesuai jadwal terlampir.
                    </p>
                </div>
                <div class="shrink-0 flex items-center gap-2">
                    <a href="#" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-all">
                        <span>Lihat Jadwal</span>
                    </a>
                </div>
            </article>

        </div>
    </section>
</div>
@endsection