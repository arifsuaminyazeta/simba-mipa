@extends('layouts.app')

@section('title', 'Kelola Profil')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Profil</h1>
        <p class="text-xs text-slate-500 mt-1">Perbarui informasi akun, foto profil, dan kata sandi Anda.</p>
    </div>

    @if(session('status') === 'profile-updated')
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
            Profil berhasil diperbarui.
        </div>
    @elseif(session('status') === 'password-updated')
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
            Kata sandi berhasil diperbarui.
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
        <h2 class="text-sm font-bold text-slate-800 mb-1">Informasi Akun</h2>
        <p class="text-xs text-slate-500 mb-5">Pastikan email dan nomor telepon aktif untuk keperluan verifikasi beasiswa.</p>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="flex items-center gap-4 pb-2">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" style="width: 64px; height: 64px;" class="rounded-2xl object-cover border border-slate-200 shrink-0">
                @else
                    <div style="width: 64px; height: 64px;" class="rounded-2xl bg-blue-600 text-white font-bold flex items-center justify-center text-lg shrink-0">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <label for="avatar" class="block text-xs font-semibold text-slate-700 mb-1">Foto Profil (JPG/PNG/WEBP, maks. 2MB)</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="text-xs text-slate-500">
                    @error('avatar')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon / WhatsApp</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    @error('phone')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">NIM / NIP & Jurusan</label>
                    <input type="text" value="{{ implode(' · ', array_filter([$user->nim_nip, $user->major])) ?: '-' }}" disabled class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-500 text-xs">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
        <h2 class="text-sm font-bold text-slate-800 mb-1">Ubah Kata Sandi</h2>
        <p class="text-xs text-slate-500 mb-5">Gunakan kata sandi minimal 8 karakter untuk menjaga keamanan akun.</p>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="current_password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" required class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    @error('current_password', 'updatePassword')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    @error('password', 'updatePassword')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition-colors">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection