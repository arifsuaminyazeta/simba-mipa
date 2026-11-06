@extends('layouts.app')

@section('title', 'Pemetaan Mahasiswa Bimbingan')

@section('content')
<div class="space-y-6">
    <div class="pb-4 border-b border-slate-200">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke manajemen pengguna
        </a>
        <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Pemetaan Dosen PA</p>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">{{ $dosen->name }}</h1>
        <p class="text-xs text-slate-500 mt-1">{{ $dosen->nim_nip }} · {{ $dosen->major }} · {{ $dosen->email }}</p>
    </div>

    @if(session('success'))
        <div role="status" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-medium text-emerald-800">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('users.advisees.update', $dosen) }}" class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        @csrf
        @method('PUT')
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Pilih Mahasiswa Bimbingan</h2>
                <p class="text-xs text-slate-400 mt-0.5">Centang mahasiswa aktif yang ditetapkan kepada dosen ini. Pemetaan yang disimpan akan menggantikan pemetaan sebelumnya.</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-lg bg-blue-50 text-blue-700">{{ count($assignedStudentIds) }} mahasiswa saat ini</span>
        </div>

        @if($errors->has('student_ids') || $errors->has('student_ids.*'))
            <div role="alert" class="mx-5 mt-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs text-rose-700">
                Pilihan mahasiswa tidak valid. Muat ulang halaman dan pilih mahasiswa aktif.
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">Pilih</th>
                        <th class="px-5 py-3.5">Mahasiswa</th>
                        <th class="px-5 py-3.5">Jurusan</th>
                        <th class="px-5 py-3.5">Dosen PA Saat Ini</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-3.5 text-center">
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" @checked(in_array($student->id, $assignedStudentIds)) aria-label="Pilih {{ $student->name }}" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-5 py-3.5">
                                <p class="font-bold text-slate-900">{{ $student->name }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $student->nim_nip ?: 'NIM belum tersedia' }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $student->major }}</td>
                            <td class="px-5 py-3.5">
                                @if((int) $student->dosen_pa_id === $dosen->id)
                                    <span class="text-blue-700 font-semibold">Dosen ini</span>
                                @elseif($student->academicAdvisor)
                                    <span class="text-slate-600">{{ $student->academicAdvisor->name }}</span>
                                @else
                                    <span class="text-amber-600">Belum dipetakan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada mahasiswa aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-[11px] text-slate-400">Mahasiswa yang dipilih akan dipindahkan dari Dosen PA sebelumnya jika ada.</p>
            <div class="flex justify-end gap-2">
                <a href="{{ route('users.index') }}" class="inline-flex justify-center px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pemetaan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
