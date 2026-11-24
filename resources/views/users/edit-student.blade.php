@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="pb-4 border-b border-slate-200">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke manajemen pengguna
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Mahasiswa</h1>
        <p class="text-xs text-slate-500 mt-1">Ubah data akun dan status kategori mahasiswa.</p>
    </div>

    @if($errors->any())
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs text-rose-700">
            Periksa kembali isian yang ditandai. Semua perubahan harus valid sebelum disimpan.
        </div>
    @endif

    <form method="POST" action="{{ route('users.students.update', $student) }}" class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama lengkap <span class="text-rose-500">*</span></label>
                <input id="name" name="name" type="text" required maxlength="255" value="{{ old('name', $student->name) }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-rose-400 @enderror">
                @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email <span class="text-rose-500">*</span></label>
                <input id="email" name="email" type="email" required maxlength="255" value="{{ old('email', $student->email) }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-rose-400 @enderror">
                @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="nim_nip" class="block text-xs font-semibold text-slate-700 mb-1.5">NPM <span class="text-rose-500">*</span></label>
                <input id="nim_nip" name="nim_nip" type="text" required maxlength="255" value="{{ old('nim_nip', $student->nim_nip) }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('nim_nip') border-rose-400 @enderror">
                @error('nim_nip') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="major" class="block text-xs font-semibold text-slate-700 mb-1.5">Jurusan <span class="text-rose-500">*</span></label>
                <select id="major" name="major" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('major') border-rose-400 @enderror">
                    @foreach(['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'] as $major)
                        <option value="{{ $major }}" @selected(old('major', $student->major) === $major)>{{ $major }}</option>
                    @endforeach
                </select>
                @error('major') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">No. Telepon</label>
                <input id="phone" name="phone" type="text" maxlength="30" value="{{ old('phone', $student->phone) }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="student_category" class="block text-xs font-semibold text-slate-700 mb-1.5">Status mahasiswa <span class="text-rose-500">*</span></label>
                <select id="student_category" name="student_category" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('student_category') border-rose-400 @enderror">
                    <option value="umum" @selected(old('student_category', $category) === 'umum')>Mahasiswa Umum</option>
                    <option value="awardee" @selected(old('student_category', $category) === 'awardee')>Awardee</option>
                    <option value="alumni_awardee" @selected(old('student_category', $category) === 'alumni_awardee')>Alumni Awardee</option>
                </select>
                @error('student_category') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="dosen_pa_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Dosen Pembimbing Akademik</label>
                <select id="dosen_pa_id" name="dosen_pa_id" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('dosen_pa_id') border-rose-400 @enderror">
                    <option value="">Tidak ada dosen PA</option>
                    @foreach($advisors as $advisor)
                        <option value="{{ $advisor->id }}" @selected((string) old('dosen_pa_id', $student->dosen_pa_id) === (string) $advisor->id)>
                            {{ $advisor->name }}@if($advisor->major) · {{ $advisor->major }}@endif
                        </option>
                    @endforeach
                </select>
                @error('dosen_pa_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $student->is_active)) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Akun mahasiswa aktif
                </label>
            </div>

            <div class="sm:col-span-2 border-t border-slate-100 pt-5">
                <h2 class="text-xs font-bold text-slate-800">Ubah kata sandi (opsional)</h2>
                <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika kata sandi tidak ingin diubah.</p>
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata sandi baru</label>
                <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-rose-400 @enderror">
                @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi kata sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 pt-5 border-t border-slate-100">
            <a href="{{ route('users.index') }}" class="inline-flex justify-center px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Batal</a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
