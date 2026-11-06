@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Administrasi akademik</p>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">Manajemen Pengguna</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola akun Dosen PA dan pemetaan mahasiswa bimbingan.</p>
        </div>
        <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Dosen PA
        </a>
    </div>

    @if(session('success'))
        <div role="status" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-medium text-emerald-800">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mahasiswa Aktif</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($activeStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Tersedia untuk pemetaan PA</p>
        </div>
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sudah Dipetakan</p>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($assignedStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Memiliki Dosen PA</p>
        </div>
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Belum Dipetakan</p>
            <p class="text-2xl font-extrabold {{ $unassignedStudentCount ? 'text-amber-500' : 'text-slate-800' }} mt-1">{{ number_format($unassignedStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Perlu ditetapkan pembimbingnya</p>
        </div>
    </div>

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
                                <span class="font-bold text-slate-800">{{ number_format($lecturer->active_advisees_count, 0, ',', '.') }}</span>
                                <span class="text-slate-400">mahasiswa aktif</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('users.advisees', $lecturer) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-blue-200 bg-blue-50 text-blue-700 font-semibold text-[11px] hover:bg-blue-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857"/></svg>
                                        Atur Bimbingan
                                    </a>
                                    <a href="{{ route('users.edit', $lecturer) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-[11px] hover:bg-slate-50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit Akun
                                    </a>
                                </div>
                            </td>
                        </tr>
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
@endsection
