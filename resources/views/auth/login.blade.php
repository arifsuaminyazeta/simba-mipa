@extends('layouts.guest')

@section('title', 'Login SIMBA-MIPA')

@section('content')
<div class="w-full min-h-[650px] px-4 py-12 bg-blue-50 flex items-center justify-center">
    <div class="w-full max-w-sm p-7 bg-white border border-slate-200 rounded-xl shadow-lg">
        <div class="text-center mb-6">
            <div class="mx-auto mb-4 w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-700">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5m5 5H3"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Silakan Login</h2>
            <p class="text-xs text-slate-500 mt-2">Masuk ke portal SIMBA-MIPA</p>
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
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" placeholder="Password" required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600">
            </div>

            <label class="mb-5 flex items-center gap-2 text-xs text-slate-600">
                <input type="checkbox" name="remember" class="rounded">
                Ingat saya
            </label>

            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-3 rounded transition">
                LOGIN
            </button>
        </form>

        <div class="text-center mt-5">
            <p class="text-xs text-slate-500">
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="text-blue-700 font-semibold">Daftar</a>
            </p>
        </div>
    </div>
</div>
@endsection
