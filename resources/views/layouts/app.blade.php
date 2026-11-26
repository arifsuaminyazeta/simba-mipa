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
    <style>
        dialog {
            max-height: calc(100vh - 32px);
            margin: auto;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: white;
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.20);
        }
        dialog::backdrop {
            background: rgba(15, 23, 42, 0.48);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }
        dialog[open] { animation: modal-enter 150ms ease-out; }
        @keyframes modal-enter {
            from { opacity: 0; transform: translateY(8px) scale(.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        dialog > div,
        dialog .dialog-scroll {
            max-height: calc(100vh - 32px);
            overflow-y: auto;
        }
        dialog .sticky.top-0 {
            position: sticky;
            top: 0;
            z-index: 30;
            min-height: 72px;
            padding: 14px 24px;
            background: white;
        }
        dialog .sticky.top-0 h3 {
            margin: 0;
            line-height: 1.25;
        }
        dialog .dialog-scroll > form {
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding: 18px 24px 0;
        }
        dialog .dialog-scroll > form > *:first-child {
            margin-top: 0;
        }
        dialog form label {
            margin-bottom: 6px;
            line-height: 1.35;
        }
        dialog form input,
        dialog form select {
            min-height: 42px;
        }
        dialog form textarea {
            min-height: 96px;
        }
        dialog form input,
        dialog form select,
        dialog form textarea {
            border-radius: 10px;
        }
        dialog form .grid {
            gap: 12px;
        }
        dialog form > .flex:last-child,
        dialog form > div.flex:last-child,
        dialog form > div.flex.flex-col-reverse:last-child,
        dialog form > div.flex.items-center.justify-end:last-child {
            position: static;
            margin: 16px 0 0;
            padding: 14px 0 16px;
            background: white;
            border-top: 1px solid #e2e8f0;
        }
        dialog form input[type="checkbox"],
        dialog form input[type="radio"] {
            min-height: 0;
        }
        dialog button {
            transition: background-color 150ms ease, color 150ms ease, border-color 150ms ease;
        }

        dialog.admin-modal {
            width: min(640px, calc(100vw - 32px));
            max-width: 640px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
        }
        dialog.admin-modal .admin-modal-header {
            min-height: 72px;
            padding: 14px 24px;
        }
        dialog.admin-modal form.admin-modal-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 0;
            padding: 0;
        }
        dialog.admin-modal form.admin-modal-form > .grid {
            gap: 12px;
            box-sizing: border-box;
            width: 100%;
            padding: 20px 24px 12px;
        }
        dialog.admin-modal .admin-modal-footer {
            margin: 0;
            padding: 14px 24px 16px;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
        }
        dialog.student-edit-modal .dialog-scroll {
            width: 100%;
            overflow-x: hidden;
        }
        dialog.student-edit-modal form.admin-modal-form,
        dialog.student-edit-modal form.admin-modal-form > .grid,
        dialog.student-edit-modal form.admin-modal-form > .grid > div {
            min-width: 0;
            box-sizing: border-box;
        }
        dialog.student-edit-modal form.admin-modal-form {
            width: 100%;
            gap: 16px;
            padding: 0;
        }
        dialog.student-edit-modal form.admin-modal-form > .student-edit-fields {
            width: 100%;
        }
        dialog.student-edit-modal .admin-modal-footer {
            margin: 2px -24px 0;
            padding: 14px 24px 16px;
        }
        dialog.student-edit-modal form.admin-modal-form input:not([type="checkbox"]),
        dialog.student-edit-modal form.admin-modal-form select {
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }
    </style>

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