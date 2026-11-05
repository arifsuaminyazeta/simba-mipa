<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMBA-MIPA') }} - @yield('title', 'Sistem Informasi Beasiswa FMIPA')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f8fafc] text-slate-900 selection:bg-blue-100 selection:text-blue-700 flex flex-col min-h-screen">

    <!-- Top Bar-->
    <div class="bg-blue-700 text-white text-[11px] font-medium py-2 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                <span>Fakultas Matematika dan Ilmu Pengetahuan Alam · Universitas Lampung</span>
            </div>
            <div class="text-blue-100 hidden sm:block">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </div>

    <!-- Header & Navigasi-->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SIMBA-MIPA" class="w-11 h-11 object-contain rounded-xl">
                <div>
                    <h1 class="text-base font-bold text-slate-800 tracking-tight leading-tight">SIMBA-MIPA</h1>
                    <p class="text-[11px] font-semibold text-blue-600 uppercase tracking-wider">Portal Beasiswa & Alumni</p>
                </div>
            </a>

            <!-- Navigasi -->
            <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-slate-600">
                <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors {{ request()->is('/') ? 'text-blue-600' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('beasiswa.katalog') }}" class="hover:text-blue-600 transition-colors {{ request()->routeIs('beasiswa.katalog') ? 'text-blue-600' : '' }}">
                    Katalog Beasiswa
                </a>
                <a href="{{ route('announcements.index') }}" class="hover:text-blue-600 transition-colors {{ request()->routeIs('announcements.*') ? 'text-blue-600' : '' }}">
                    Pengumuman
                </a>
                <a href="{{ route('tracer.index') }}" class="hover:text-blue-600 transition-colors {{ request()->routeIs('tracer.*') ? 'text-blue-600' : '' }}">
                    Tracer Alumni
                </a>
            </nav>

            <!-- Tombol Masuk -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route(auth()->user()->role === 'admin' ? 'dashboard.admin' : (auth()->user()->role === 'dosen' ? 'dashboard.dosen' : 'dashboard.mahasiswa')) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 shadow-xs transition-all">
                        <span>Dashboard</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 transition-all">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold hover:bg-blue-600 hover:text-white transition-all">
                        <span>Masuk Portal</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer Publik -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>&copy; {{ date('Y') }} SIMBA-MIPA FMIPA Unila. Hak cipta dilindungi.</p>
            <div class="flex items-center gap-4 text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer">Panduan Beasiswa</span>
                <span>·</span>
                <span class="hover:text-blue-600 cursor-pointer">Kontak Subbag</span>
            </div>
        </div>
    </footer>

</body>
</html>