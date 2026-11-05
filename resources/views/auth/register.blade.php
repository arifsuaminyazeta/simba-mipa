@extends('layouts.guest')

@section('title', 'Registrasi SIMBA-MIPA')

@section('content')
<div class="w-full min-h-[650px] px-4 py-12 bg-blue-50 flex items-center justify-center">
    <div class="w-full max-w-md p-7 bg-white border border-slate-200 rounded-xl shadow-lg">
        <div class="text-center mb-6">
            <div class="mx-auto mb-4 w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-700">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m6-10a4 4 0 100-8 4 4 0 000 8zm10 0v6m3-3h-6"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Buat Akun</h2>
            <p class="text-xs text-slate-500 mt-2">Daftarkan akun mahasiswa SIMBA-MIPA</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-100 rounded text-xs text-red-600">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600">
            </div>

            <div class="mb-4">
                <label for="nim_nip" class="block text-xs font-semibold text-slate-700 mb-2">NIM</label>
                <input id="nim_nip" type="text" name="nim_nip" value="{{ old('nim_nip') }}" required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600">
            </div>

            <div class="mb-4">
                <label for="major" class="block text-xs font-semibold text-slate-700 mb-2">Program Studi</label>
                <select id="major" name="major" required class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded bg-white">
                    <option value="">Pilih Program Studi</option>
                    @foreach (['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'] as $major)
                        <option value="{{ $major }}" {{ old('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600">
            </div>

            <div class="mb-5">
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded outline-none focus:border-blue-600">
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded p-3 mb-5">
                <p class="text-xs text-blue-700 leading-relaxed">
                    Registrasi khusus mahasiswa FMIPA. Akun dosen dan admin dikelola oleh administrator sistem.
                </p>
            </div>

            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-3 rounded transition">
                DAFTAR
            </button>
        </form>

        <div class="text-center mt-5">
            <p class="text-xs text-slate-500">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="text-blue-700 font-semibold">Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
