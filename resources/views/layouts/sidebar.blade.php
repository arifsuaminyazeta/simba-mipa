@php
    $role = auth()->user()?->role;
@endphp

<aside class="w-64 bg-white border-r border-slate-200/90 flex flex-col justify-between shrink-0 min-h-full">
    <div class="p-5">
        <div class="flex items-center gap-3 px-1 mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIMBA-MIPA" class="w-10 h-10 object-contain rounded-xl shadow-xs shrink-0">
            <div>
                <h1 class="text-base font-bold text-slate-800 tracking-tight leading-tight">SIMBA-MIPA</h1>
                <p class="text-[10px] font-semibold text-blue-600 uppercase tracking-wider">Beasiswa & Alumni</p>
            </div>
        </div>

        @if($role === 'mahasiswa')
            <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Portal Mahasiswa</p>
            <nav class="space-y-1">
                <a href="{{ route('mahasiswa.dashboard') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Dashboard Saya</a>
                <a href="{{ route('mahasiswa.beasiswa.katalog') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('mahasiswa.beasiswa.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Cari Beasiswa</a>
                <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('mahasiswa.pendaftaran.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Status Pendaftaran</a>
                <a href="{{ route('mahasiswa.akademik.upload') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('mahasiswa.akademik.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Unggah KHS & IPK</a>
                <a href="{{ route('mahasiswa.tracer.form') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('mahasiswa.tracer.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Tracer Alumni</a>
            </nav>
        @elseif($role === 'dosen')
            <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Portal Pembimbing Akademik</p>
            <nav class="space-y-1">
                <a href="{{ route('dashboard.dosen') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('dashboard.dosen') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Dashboard PA</a>
                <a href="{{ route('verifikasi.awal') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('verifikasi.awal') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Verifikasi Berkas Mahasiswa</a>
                <a href="{{ route('akademik.monitoring') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('akademik.monitoring') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Monitoring EWS Bimbingan</a>
            </nav>
        @elseif($role === 'admin')
            <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Menu Administrasi</p>
            <nav class="space-y-1">
                <a href="{{ route('dashboard.admin') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('dashboard.admin') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Dashboard</a>
                <a href="{{ route('beasiswa.index') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('beasiswa.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Kelola Beasiswa</a>
                <a href="{{ route('verifikasi.akhir') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('verifikasi.akhir') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Verifikasi Berkas</a>
                <a href="{{ route('akademik.evaluasi') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('akademik.evaluasi') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Early Warning System</a>
                <a href="{{ route('tracer.rekap') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('tracer.rekap') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Tracer Study</a>
                <a href="{{ route('announcements.manage') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('announcements.manage', 'announcements.create', 'announcements.edit') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Kelola Pengumuman</a>
                <a href="{{ route('users.index') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">Manajemen Pengguna</a>
            </nav>
        @else
            <p class="px-3 text-xs text-slate-500">Masuk untuk membuka portal.</p>
        @endif
    </div>

    <div class="p-4 border-t border-slate-100 flex items-center justify-between">
        @if(auth()->check())
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-9 h-9 rounded-xl {{ $role === 'mahasiswa' ? 'bg-emerald-600' : ($role === 'dosen' ? 'bg-indigo-600' : 'bg-blue-600') }} text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                    {{ $role === 'mahasiswa' ? 'M' : ($role === 'dosen' ? 'D' : 'A') }}
                </div>
                <div class="truncate">
                    <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-medium truncate">
                        {{ auth()->user()->nim_nip ? auth()->user()->nim_nip.' · '.(auth()->user()->major ?? '') : 'Admin Fakultas MIPA' }}
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Keluar Portal" class="text-slate-400 hover:text-rose-600 p-1.5 rounded-lg hover:bg-slate-50 transition-colors">
                    Keluar
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Masuk</a>
        @endif
    </div>
</aside>
