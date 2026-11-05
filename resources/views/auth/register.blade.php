@extends('layouts.guest')

@section('title', 'Registrasi SIMBA-MIPA')

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

    {{-- CARD REGISTER --}}
    <div style="
        width: 100%;
        max-width: 380px;
        height: fit-content;
        background: white;
        padding: 28px;
        box-sizing: border-box;
        border-radius: 8px;
        box-shadow: 0 5px 25px rgba(30, 64, 175, 0.10);
        border: 1px solid #e5eaf2;
    ">

        {{-- HEADER CARD --}}
        <div class="text-center mb-6">

            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-700">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                            d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m6-10a4 4 0 100-8 4 4 0 000 8zm10 0v6m3-3h-6"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-xl font-bold text-slate-800">
                Buat Akun
            </h2>

            <p class="text-xs text-slate-500 mt-2">
                Daftarkan akun mahasiswa SIMBA-MIPA
            </p>

        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-100 rounded text-xs text-red-600">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600"
                >
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    NIM
                </label>

                <input
                    type="text"
                    name="nim_nip"
                    value="{{ old('nim_nip') }}"
                    placeholder="Masukkan NIM"
                    required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600"
                >
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600"
                >
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Program Studi
                </label>

                <select
                    name="major"
                    required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600 bg-white"
                >
                    <option value="">Pilih Program Studi</option>

                    @foreach (['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'] as $major)
                        <option value="{{ $major }}" {{ old('major') == $major ? 'selected' : '' }}>
                            {{ $major }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600"
                >
            </div>

            <div class="mb-5">
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600"
                >
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded p-3 mb-5">
                <p class="text-xs text-blue-700 leading-relaxed">
                    Registrasi khusus mahasiswa FMIPA. Akun dosen dan admin
                    dikelola oleh administrator sistem.
                </p>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-3 rounded transition">
                DAFTAR
            </button>

        </form>

        {{-- LOGIN --}}
        <div class="text-center mt-5">
            <p class="text-xs text-slate-500">
                Sudah memiliki akun?

                <a href="{{ route('login') }}" class="text-blue-700 font-semibold">
                    Masuk
                </a>
            </p>
        </div>

    </div>

</div>

@endsection