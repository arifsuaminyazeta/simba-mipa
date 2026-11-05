<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMBA-MIPA') }} - @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f8fafc] text-slate-900 selection:bg-blue-100 selection:text-blue-700 h-full overflow-hidden">

    <div class="h-full flex overflow-hidden">
        <!-- Sidebar Kiri -->
        <div class="h-full shrink-0">
            @include('layouts.sidebar')
        </div>

        <!-- Area Konten Utama -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            <!-- Topbar Navigasi -->
            @include('layouts.navigation')

            <!-- Halaman Konten -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>