@extends('layouts.guest')

@section('title', 'Login SIMBA-MIPA')

@section('content')

<div style="
    width: 100%;
    min-height: 650px;
    padding: 45px 16px;
    background: #edf4ff;
    display: flex;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
">

    {{-- CARD LOGIN --}}
    <div style="
        width: 100%;
        max-width: 340px;
        height: fit-content;
        background: white;
        padding: 28px;
        box-sizing: border-box;
        border-radius: 8px;
        box-shadow: 0 5px 25px rgba(30, 64, 175, 0.10);
        border: 1px solid #e5eaf2;
    ">

        <div class="text-center mb-6">

            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-700">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                            d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5m5 5H3"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-xl font-bold text-slate-800">
                Silakan Login
            </h2>

            <p class="text-xs text-slate-500 mt-2">
                Masuk ke portal SIMBA-MIPA
            </p>

        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-100 rounded text-xs text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-100 rounded text-xs text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email atau username ..."
                    required
                    autofocus
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600"
                >
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Password ..."
                    required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600"
                >
            </div>

            <div class="mb-5">
                <label class="flex items-center gap-2 text-xs text-slate-600">
                    <input type="checkbox" name="remember" class="rounded">
                    Ingat saya
                </label>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-3 rounded transition">
                LOGIN
            </button>

        </form>

        <div class="text-center mt-5">
            <p class="text-xs text-slate-500">
                Belum memiliki akun?

                <a href="{{ route('register') }}" class="text-blue-700 font-semibold">
                    Daftar
                </a>
            </p>
        </div>

    </div>

</div>

@endsection