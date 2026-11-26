@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Administrasi akademik</p>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">Manajemen Pengguna</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola akun Dosen PA, status mahasiswa, dan pemetaan mahasiswa bimbingan.</p>
        </div>
        <button type="button" onclick="document.getElementById('lecturer-create-modal').showModal()" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Dosen PA
        </button>
    </div>

    @if(session('success'))
        <div role="status" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-medium text-emerald-800">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <dialog id="lecturer-create-modal" class="m-auto w-[calc(100%-2rem)] max-w-2xl rounded-2xl border border-slate-200 bg-white p-0 text-left shadow-2xl overflow-hidden backdrop:bg-slate-900/40 backdrop:backdrop-blur-xs">
        <div class="dialog-scroll">
            <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-6 py-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600">Tambah akun</p>
                    <h3 class="mt-0.5 text-base font-bold text-slate-800">Tambah Dosen PA</h3>
                </div>
                <button type="button" onclick="document.getElementById('lecturer-create-modal').close()" class="flex h-8 w-8 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors" aria-label="Tutup">✕</button>
            </div>

            <form method="POST" action="{{ route('users.store') }}" class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="form_mode" value="create">

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="create-name" class="mb-1.5 block text-xs font-semibold text-slate-700">Nama lengkap <span class="text-rose-500">*</span></label>
                        <input id="create-name" name="name" type="text" required maxlength="255" value="{{ old('form_mode') === 'create' ? old('name') : '' }}" placeholder="Contoh: Dr. John Doe, M.Sc." class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="create-email" class="mb-1.5 block text-xs font-semibold text-slate-700">Email <span class="text-rose-500">*</span></label>
                        <input id="create-email" name="email" type="email" required maxlength="255" value="{{ old('form_mode') === 'create' ? old('email') : '' }}" placeholder="dosen@fmipa.unila.ac.id" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="create-nim" class="mb-1.5 block text-xs font-semibold text-slate-700">NIP <span class="text-rose-500">*</span></label>
                        <input id="create-nim" name="nim_nip" type="text" required maxlength="255" value="{{ old('form_mode') === 'create' ? old('nim_nip') : '' }}" placeholder="198001012005011001" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="create-major" class="mb-1.5 block text-xs font-semibold text-slate-700">Jurusan <span class="text-rose-500">*</span></label>
                        @php $createMajor = old('form_mode') === 'create' ? old('major') : null; @endphp
                        <select id="create-major" name="major" required class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih jurusan</option>
                            @foreach(['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'] as $major)
                                <option value="{{ $major }}" @selected($createMajor === $major)>{{ $major }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="create-phone" class="mb-1.5 block text-xs font-semibold text-slate-700">No. Telepon</label>
                        <input id="create-phone" name="phone" type="text" maxlength="30" value="{{ old('form_mode') === 'create' ? old('phone') : '' }}" placeholder="08xxxxxxxxxx" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" @checked(old('form_mode') === 'create' ? old('is_active', 1) : true) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span>Akun dosen aktif</span>
                        </label>
                    </div>
                    <div class="border-t border-slate-100 pt-3 sm:col-span-2">
                        <h4 class="text-xs font-bold text-slate-800">Kata sandi akun</h4>
                    </div>
                    <div>
                        <label for="create-password" class="mb-1.5 block text-xs font-semibold text-slate-700">Kata sandi <span class="text-rose-500">*</span></label>
                        <input id="create-password" name="password" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="create-password-confirm" class="mb-1.5 block text-xs font-semibold text-slate-700">Konfirmasi kata sandi <span class="text-rose-500">*</span></label>
                        <input id="create-password-confirm" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                @if($errors->any() && old('form_mode') === 'create')
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs text-rose-700">
                        Periksa kembali data yang dimasukkan. Ada isian yang belum valid.
                    </div>
                @endif

                <div class="admin-modal-footer flex items-center justify-end gap-3">
                    <button type="button" onclick="document.getElementById('lecturer-create-modal').close()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-xs font-semibold text-white hover:bg-blue-700 transition-colors shadow-xs">Buat Akun Dosen</button>
                </div>
            </form>
        </div>
    </dialog>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mahasiswa Aktif</p>
            <p class="text-2xl font-extrabold text-blue-600 mt-1">{{ number_format($activeStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] text-blue-600 font-medium mt-1">Tersedia untuk pemetaan PA</p>
        </div>
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sudah Dipetakan</p>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($assignedStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] text-emerald-600 font-medium mt-1">Memiliki Dosen PA</p>
        </div>
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Belum Dipetakan</p>
            <p class="text-2xl font-extrabold {{ $unassignedStudentCount ? 'text-amber-500' : 'text-slate-800' }} mt-1">{{ number_format($unassignedStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] {{ $unassignedStudentCount ? 'text-amber-500' : 'text-slate-400' }} font-medium mt-1">Perlu ditetapkan pembimbingnya</p>
        </div>
    </div>

    <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Status Mahasiswa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Cari dan ubah kategori akademik mahasiswa.</p>
        </div>

        <form method="GET" action="{{ route('users.index') }}" class="p-5 border-b border-slate-100 bg-slate-50/40">
            <div class="flex flex-col lg:flex-row gap-3">
                <label class="relative flex-1">
                    <span class="sr-only">Cari mahasiswa</span>
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 110-14 7 7 0 010 14z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NPM, atau email" class="w-full rounded-xl border-slate-200 pl-9 text-xs focus:border-blue-500 focus:ring-blue-500">
                </label>
                <select name="student_category" class="rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500 lg:w-52">
                    <option value="">Semua status</option>
                    <option value="umum" @selected(request('student_category') === 'umum')>Mahasiswa Umum</option>
                    <option value="awardee" @selected(request('student_category') === 'awardee')>Awardee</option>
                    <option value="alumni_awardee" @selected(request('student_category') === 'alumni_awardee')>Alumni Awardee</option>
                </select>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">Terapkan</button>
                @if(request()->has('search') || request()->has('student_category'))
                    <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-xs font-semibold hover:bg-slate-50">Reset</a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Mahasiswa</th>
                        <th class="px-5 py-3.5">Jurusan</th>
                        <th class="px-5 py-3.5">Status Mahasiswa</th>
                        <th class="px-5 py-3.5">Dosen PA</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($students as $student)
                        @php
                            $studentCategory = $student->academic_status === 'lulus'
                                ? ($student->is_awardee ? 'alumni_awardee' : 'umum')
                                : ($student->is_awardee ? 'awardee' : 'umum');
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900 text-[13px]">{{ $student->name }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $student->nim_nip }} · {{ $student->email }}</p>
                            </td>
                            <td class="px-5 py-4">{{ $student->major }}</td>
                            <td class="px-5 py-4">
                                @if($studentCategory === 'awardee')
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">Awardee</span>
                                @elseif($studentCategory === 'alumni_awardee')
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-violet-50 text-violet-700 border border-violet-200 text-[10px] font-bold">Alumni Awardee</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold">Mahasiswa Umum</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $student->academicAdvisor?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <button type="button" onclick="document.getElementById('student-edit-modal-{{ $student->id }}').showModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-[11px] hover:bg-slate-50 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit Mahasiswa
                                </button>
                            </td>
                        </tr>
                        <dialog id="student-edit-modal-{{ $student->id }}" class="admin-modal student-edit-modal m-auto overflow-hidden rounded-2xl bg-white p-0 text-left shadow-2xl">
                            <div class="dialog-scroll">
                                <div class="admin-modal-header sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600">Kelola data mahasiswa</p>
                                        <h3 class="mt-0.5 text-base font-bold text-slate-800">Edit Mahasiswa</h3>
                                    </div>
                                    <button type="button" onclick="document.getElementById('student-edit-modal-{{ $student->id }}').close()" class="flex h-8 w-8 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors" aria-label="Tutup">✕</button>
                                </div>
                                <form method="POST" action="{{ route('users.students.update', $student) }}" class="admin-modal-form" style="padding: 0;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="form_mode" value="edit-student-{{ $student->id }}">
                                    <div class="student-edit-fields grid grid-cols-1 gap-4 sm:grid-cols-2" style="box-sizing: border-box; width: 100%; padding: 20px 24px 12px;">
                                        <div class="sm:col-span-2">
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">Nama lengkap <span class="text-rose-500">*</span></label>
                                            <input type="text" name="name" value="{{ $student->name }}" required maxlength="255" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">Email <span class="text-rose-500">*</span></label>
                                            <input type="email" name="email" value="{{ $student->email }}" required maxlength="255" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">NPM <span class="text-rose-500">*</span></label>
                                            <input type="text" name="nim_nip" value="{{ $student->nim_nip }}" required maxlength="255" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">Jurusan <span class="text-rose-500">*</span></label>
                                            <select name="major" required class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                                @foreach(['Ilmu Komputer','Matematika','Fisika','Kimia','Biologi'] as $major)
                                                    <option value="{{ $major }}" @selected($student->major === $major)>{{ $major }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">No. Telepon</label>
                                            <input type="text" name="phone" value="{{ $student->phone }}" maxlength="30" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">Status mahasiswa <span class="text-rose-500">*</span></label>
                                            <select name="student_category" required class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="umum" @selected($studentCategory === 'umum')>Mahasiswa Umum</option>
                                                <option value="awardee" @selected($studentCategory === 'awardee')>Awardee</option>
                                                <option value="alumni_awardee" @selected($studentCategory === 'alumni_awardee')>Alumni Awardee</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">Dosen Pembimbing Akademik</label>
                                            <select name="dosen_pa_id" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="">Tidak ada dosen PA</option>
                                                @foreach($lecturers as $advisor)
                                                    <option value="{{ $advisor->id }}" @selected($student->dosen_pa_id === $advisor->id)>{{ $advisor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                                                <input type="checkbox" name="is_active" value="1" @checked($student->is_active) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                <span>Akun mahasiswa aktif</span>
                                            </label>
                                        </div>
                                        <div class="border-t border-slate-100 pt-3 sm:col-span-2">
                                            <h4 class="text-xs font-bold text-slate-800">Ubah kata sandi <span class="font-normal text-slate-400">(opsional)</span></h4>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Kosongkan jika kata sandi tidak ingin diubah.</p>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">Kata sandi baru</label>
                                            <input type="password" name="password" minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold text-slate-700">Konfirmasi kata sandi</label>
                                            <input type="password" name="password_confirmation" minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div class="admin-modal-footer flex items-center justify-end gap-3" style="margin: 0; padding: 14px 24px 16px;">
                                        <button type="button" onclick="document.getElementById('student-edit-modal-{{ $student->id }}').close()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Batal</button>
                                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-xs font-semibold text-white hover:bg-blue-700 transition-colors shadow-xs">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </dialog>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-sm font-semibold text-slate-700">Mahasiswa tidak ditemukan</p>
                                <p class="text-xs text-slate-400 mt-1">Ubah kata kunci atau filter status mahasiswa.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $students->links() }}</div>
        @endif
    </section>

    <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Akun Dosen Pembimbing Akademik</h2>
            <p class="text-xs text-slate-400 mt-0.5">Atur informasi akun dan mahasiswa bimbingan setiap dosen.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Dosen PA</th>
                        <th class="px-5 py-3.5">Jurusan</th>
                        <th class="px-5 py-3.5">Mahasiswa Bimbingan</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lecturers as $lecturer)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900 text-[13px]">{{ $lecturer->name }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $lecturer->nim_nip }} · {{ $lecturer->email }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-semibold">{{ $lecturer->major }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-bold text-blue-600">{{ number_format($lecturer->active_advisees_count, 0, ',', '.') }}</span>
                                <span class="text-slate-400">mahasiswa aktif</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" onclick="document.getElementById('advisees-modal-{{ $lecturer->id }}').showModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-blue-200 bg-blue-50 text-blue-700 font-semibold text-[11px] hover:bg-blue-100">
                                        Atur Bimbingan
                                    </button>
                                    <button type="button" onclick="document.getElementById('lecturer-edit-modal-{{ $lecturer->id }}').showModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-[11px] hover:bg-slate-50">
                                        Edit Akun
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <dialog id="advisees-modal-{{ $lecturer->id }}" class="m-auto w-[calc(100%-2rem)] max-w-lg rounded-2xl border border-slate-200 bg-white p-0 text-left shadow-2xl overflow-hidden backdrop:bg-slate-900/40 backdrop:backdrop-blur-xs">
                            <div class="dialog-scroll">
                                <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-6 py-4">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600">Pemetaan pembimbing</p>
                                        <h3 class="mt-0.5 text-base font-bold text-slate-800">{{ $lecturer->name }}</h3>
                                    </div>
                                    <button type="button" onclick="document.getElementById('advisees-modal-{{ $lecturer->id }}').close()" class="flex h-8 w-8 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors" aria-label="Tutup">✕</button>
                                </div>
                                <div class="px-6 py-5 space-y-4">
                                    <div class="rounded-xl border border-slate-200/90 bg-slate-50/70 p-4 space-y-2.5">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500">NIP Dosen</span>
                                            <span class="font-semibold text-slate-800">{{ $lecturer->nim_nip }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500">Jurusan</span>
                                            <span class="inline-flex px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-semibold">{{ $lecturer->major }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500">Mahasiswa Bimbingan Aktif</span>
                                            <span class="font-bold text-blue-600">{{ number_format($lecturer->active_advisees_count, 0, ',', '.') }} Mahasiswa</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-500 leading-relaxed">
                                        Pemetaan mahasiswa bimbingan PA dapat dikelola secara lengkap untuk menetapkan, menambah, atau memindahkan mahasiswa bimbingan dosen ini.
                                    </p>
                                </div>
                                <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-6 py-4 bg-slate-50/50">
                                    <button type="button" onclick="document.getElementById('advisees-modal-{{ $lecturer->id }}').close()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-white transition-colors">Tutup</button>
                                    <a href="{{ route('users.advisees', $lecturer) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-semibold text-white hover:bg-blue-700 transition-colors shadow-xs">
                                        <span>Kelola Pemetaan</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </dialog>
                        <dialog id="lecturer-edit-modal-{{ $lecturer->id }}" class="admin-modal m-auto overflow-hidden rounded-2xl bg-white p-0 text-left shadow-2xl">
                            <div class="dialog-scroll">
                                <div class="admin-modal-header sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600">Kelola akun dosen</p>
                                        <h3 class="mt-0.5 text-base font-bold text-slate-800">Edit Akun Dosen PA</h3>
                                    </div>
                                    <button type="button" onclick="document.getElementById('lecturer-edit-modal-{{ $lecturer->id }}').close()" class="flex h-8 w-8 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors" aria-label="Tutup">✕</button>
                                </div>

                                <form method="POST" action="{{ route('users.update', $lecturer) }}" class="admin-modal-form" style="padding: 0;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="form_mode" value="edit">
                                    <input type="hidden" name="lecturer_id" value="{{ $lecturer->id }}">

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2" style="box-sizing: border-box; width: 100%; padding: 20px 24px 12px;">
                                        <div class="sm:col-span-2">
                                            <label for="edit-name-{{ $lecturer->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">Nama lengkap <span class="text-rose-500">*</span></label>
                                            <input id="edit-name-{{ $lecturer->id }}" name="name" type="text" required maxlength="255" value="{{ old('lecturer_id') == $lecturer->id ? old('name') : $lecturer->name }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="edit-email-{{ $lecturer->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">Email <span class="text-rose-500">*</span></label>
                                            <input id="edit-email-{{ $lecturer->id }}" name="email" type="email" required maxlength="255" value="{{ old('lecturer_id') == $lecturer->id ? old('email') : $lecturer->email }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="edit-nim-{{ $lecturer->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">NIP <span class="text-rose-500">*</span></label>
                                            <input id="edit-nim-{{ $lecturer->id }}" name="nim_nip" type="text" required maxlength="255" value="{{ old('lecturer_id') == $lecturer->id ? old('nim_nip') : $lecturer->nim_nip }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="edit-major-{{ $lecturer->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">Jurusan <span class="text-rose-500">*</span></label>
                                            @php $editMajor = old('lecturer_id') == $lecturer->id ? old('major') : $lecturer->major; @endphp
                                            <select id="edit-major-{{ $lecturer->id }}" name="major" required class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                                @foreach(['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi'] as $major)
                                                    <option value="{{ $major }}" @selected($editMajor === $major)>{{ $major }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="edit-phone-{{ $lecturer->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">No. Telepon</label>
                                            <input id="edit-phone-{{ $lecturer->id }}" name="phone" type="text" maxlength="30" value="{{ old('lecturer_id') == $lecturer->id ? old('phone') : $lecturer->phone }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                                                <input type="checkbox" name="is_active" value="1" @checked(old('lecturer_id') == $lecturer->id ? old('is_active', 0) : $lecturer->is_active) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                <span>Akun dosen aktif</span>
                                            </label>
                                        </div>
                                        <div class="border-t border-slate-100 pt-3 sm:col-span-2">
                                            <h4 class="text-xs font-bold text-slate-800">Ubah kata sandi <span class="font-normal text-slate-400">(opsional)</span></h4>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Kosongkan jika kata sandi tidak ingin diubah.</p>
                                        </div>
                                        <div>
                                            <label for="edit-password-{{ $lecturer->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">Kata sandi baru</label>
                                            <input id="edit-password-{{ $lecturer->id }}" name="password" type="password" minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="edit-password-confirm-{{ $lecturer->id }}" class="mb-1.5 block text-xs font-semibold text-slate-700">Konfirmasi kata sandi</label>
                                            <input id="edit-password-confirm-{{ $lecturer->id }}" name="password_confirmation" type="password" minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>

                                    <div class="admin-modal-footer flex items-center justify-end gap-3" style="margin: 0; padding: 14px 24px 16px;">
                                        <button type="button" onclick="document.getElementById('lecturer-edit-modal-{{ $lecturer->id }}').close()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Batal</button>
                                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-xs font-semibold text-white hover:bg-blue-700 transition-colors shadow-xs">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </dialog>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-14 text-center">
                                <p class="text-sm font-semibold text-slate-700">Belum ada akun Dosen PA</p>
                                <p class="text-xs text-slate-400 mt-1">Tambahkan akun dosen untuk mulai memetakan mahasiswa bimbingan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($lecturers->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $lecturers->links() }}</div>
        @endif
    </section>
</div>

@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(old('form_mode') === 'edit' && old('lecturer_id'))
                document.getElementById('lecturer-edit-modal-{{ old('lecturer_id') }}')?.showModal();
            @elseif(old('form_mode') === 'create')
                document.getElementById('lecturer-create-modal')?.showModal();
            @elseif(old('form_mode') && str_starts_with(old('form_mode'), 'edit-student-'))
                document.getElementById('student-edit-modal-{{ str_replace('edit-student-', '', old('form_mode')) }}')?.showModal();
            @endif
        });
    </script>
@endif
@endsection
