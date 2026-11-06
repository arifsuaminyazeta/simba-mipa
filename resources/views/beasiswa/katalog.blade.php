<!-- @extends(request()->is('beasiswa*') ? 'layouts.app' : 'layouts.guest') -->
@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')
@section('title', 'Katalog Beasiswa')

@section('content')
<div class="w-full">
    <section class="bg-white border-b border-slate-200/80 py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="max-w-2xl mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Peluang Pendanaan Mahasiswa
                </span>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Katalog Beasiswa FMIPA</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Eksplorasi berbagai program beasiswa aktif dari instansi pemerintah, mitra industri, dan yayasan untuk mahasiswa FMIPA Unila.
                </p>
            </div>

            <!-- Filter Bar -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-6 relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" placeholder="Cari nama beasiswa atau mitra penyelenggara..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 placeholder-slate-400">
                </div>
                <div class="md:col-span-3">
                    <select class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        <option value="">Semua Kategori</option>
                        <option value="prestasi">Prestasi Akademik</option>
                        <option value="ekonomi">Bantuan Finansial / UKT</option>
                        <option value="swasta">Mitra Korporasi / BUMN</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <select class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        <option value="">Status Pendaftaran</option>
                        <option value="open">Sedang Dibuka</option>
                        <option value="upcoming">Segera Dibuka</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Grid Kartu Beasiswa -->
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col justify-between hover:border-blue-300 transition-all">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                            Pendaftaran Dibuka
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium">Batas: 25 Nov 2026</span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base mb-1.5 leading-snug">Beasiswa Bank Indonesia (GenBI)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Dukungan pembiayaan pendidikan dan wadah pengembangan kepemimpinan komunitas Generasi Baru Indonesia.
                    </p>

                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-2 mb-6">
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Minimal IPK:</span>
                            <span class="font-bold text-slate-700">3.00</span>
                        </div>
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Semester:</span>
                            <span class="font-bold text-slate-700">3 atau 5</span>
                        </div>
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Bantuan Biaya:</span>
                            <span class="font-bold text-blue-700">Rp 1.000.000 / bln</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('beasiswa.show') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
                        Detail Syarat
                    </a>
                    <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors shadow-xs">
                        <span>Daftar Sekarang</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col justify-between hover:border-blue-300 transition-all">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                            Pendaftaran Dibuka
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium">Batas: 10 Des 2026</span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base mb-1.5 leading-snug">Djarum Beasiswa Plus</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Program beasiswa prestasi yang dilengkapi serangkaian pelatihan soft skills, leadership, dan character building.
                    </p>

                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-2 mb-6">
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Minimal IPK:</span>
                            <span class="font-bold text-slate-700">3.20</span>
                        </div>
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Semester:</span>
                            <span class="font-bold text-slate-700">Semester 4</span>
                        </div>
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Bantuan Biaya:</span>
                            <span class="font-bold text-blue-700">Rp 1.000.000 / bln</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('beasiswa.show') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
                        Detail Syarat
                    </a>
                    <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors shadow-xs">
                        <span>Daftar Sekarang</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col justify-between hover:border-blue-300 transition-all">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/70">
                            Segera Dibuka
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium">Mulai: Jan 2027</span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base mb-1.5 leading-snug">Subsidi UKT Ikatan Alumni FMIPA</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Bantuan penyesuaian UKT bagi mahasiswa aktif FMIPA yang membutuhkan dukungan kelangsungan masa studi.
                    </p>

                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-2 mb-6">
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Minimal IPK:</span>
                            <span class="font-bold text-slate-700">2.75</span>
                        </div>
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Semester:</span>
                            <span class="font-bold text-slate-700">Semua Semester</span>
                        </div>
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400">Bantuan Biaya:</span>
                            <span class="font-bold text-blue-700">Potongan UKT 50%</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('beasiswa.show') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
                        Detail Syarat
                    </a>
                    <button type="button" disabled class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed">
                        Belum Dibuka
                    </button>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection