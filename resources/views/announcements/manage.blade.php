@extends('layouts.app')

@section('title', 'Kelola Pengumuman')

@section('content')
@php
    $roleLabels = [
        'public' => ['label' => 'Publik', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
        'all' => ['label' => 'Semua Pengguna', 'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
        'mahasiswa' => ['label' => 'Mahasiswa', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
        'dosen_pa' => ['label' => 'Dosen PA', 'class' => 'bg-purple-50 text-purple-700 border-purple-200'],
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Informasi fakultas</p>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">Kelola Pengumuman</h1>
            <p class="text-xs text-slate-500 mt-1">Buat, perbarui, dan atur target serta publikasi pengumuman fakultas.</p>
        </div>
        <button type="button" onclick="document.getElementById('announcement-create-modal').showModal()" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengumuman
        </button>
    </div>

    @if(session('success'))
        <div role="status" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-medium text-emerald-800">
            <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <section class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-xs">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Daftar Pengumuman</h2>
                <p class="text-xs text-slate-400 mt-0.5">Pengumuman aktif ditampilkan sesuai target audiens masing-masing.</p>
            </div>
            <a href="{{ route('announcements.index') }}" class="shrink-0 text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat halaman publik &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-100 bg-slate-50 text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-6 py-3.5">Pengumuman</th>
                        <th class="px-5 py-3.5">Target Audiens</th>
                        <th class="px-5 py-3.5">Dibuat oleh</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($announcements as $announcement)
                        @php
                            $targetKey = $announcement->target_role ?? 'public';
                            $badge = $roleLabels[$targetKey] ?? $roleLabels['public'];
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4 max-w-xl">
                                <p class="font-bold text-slate-900 text-[13px]">{{ $announcement->title }}</p>
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 whitespace-pre-line">{{ $announcement->content }}</p>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2.5 py-1 rounded-full border text-[10px] font-bold {{ $badge['class'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $announcement->creator?->name ?? 'Pengguna dihapus' }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">{{ $announcement->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4">
                                @if($announcement->is_active)
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">Aktif</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" onclick="document.getElementById('announcement-edit-modal-{{ $announcement->id }}').showModal()" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('announcements.destroy', $announcement) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-[11px] font-semibold text-rose-700 hover:bg-rose-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <p class="text-sm font-semibold text-slate-700">Belum ada pengumuman</p>
                                <p class="mt-1 text-xs text-slate-400">Buat pengumuman pertama untuk membagikan informasi fakultas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($announcements->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">{{ $announcements->links() }}</div>
        @endif
    </section>
</div>

<dialog id="announcement-create-modal" class="m-auto w-[calc(100%-2rem)] max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white p-0 text-left shadow-2xl">
    <div class="max-h-[calc(100vh-3rem)] overflow-y-auto">
        <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-6 py-3" style="min-height:72px;">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-blue-600">Informasi baru</p>
                <h3 class="mt-1 text-base font-bold text-slate-800">Buat Pengumuman</h3>
            </div>
            <button type="button" onclick="this.closest('dialog').close()" class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup">✕</button>
        </div>
        <form method="POST" action="{{ route('announcements.store') }}" class="space-y-4" style="padding:18px 24px 0;">
            @csrf
            <input type="hidden" name="form_mode" value="create">
            <div>
                <label for="announcement-title" class="mb-2 block text-xs font-semibold text-slate-700">Judul pengumuman <span class="text-rose-500">*</span></label>
                <input id="announcement-title" type="text" name="title" value="{{ old('form_mode') === 'create' ? old('title') : '' }}" required maxlength="255" class="w-full rounded-xl border-slate-200 px-3.5 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="announcement-content" class="mb-2 block text-xs font-semibold text-slate-700">Isi pengumuman <span class="text-rose-500">*</span></label>
                <textarea id="announcement-content" name="content" rows="8" required maxlength="20000" class="w-full resize-y rounded-xl border-slate-200 px-3.5 py-3 text-sm leading-relaxed focus:border-blue-500 focus:ring-blue-500">{{ old('form_mode') === 'create' ? old('content') : '' }}</textarea>
            </div>
            <div>
                <label for="announcement-target" class="mb-2 block text-xs font-semibold text-slate-700">Target audiens</label>
                <select id="announcement-target" name="target_role" class="w-full rounded-xl border-slate-200 px-3.5 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="public">Publik</option>
                    <option value="all">Semua pengguna</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen_pa">Dosen PA</option>
                </select>
            </div>
            <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5">
                <input type="checkbox" name="is_active" value="1" checked class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <span>
                    <span class="block text-xs font-semibold text-slate-800">Publikasikan pengumuman</span>
                    <span class="mt-1 block text-[11px] text-slate-500">Kosongkan untuk menyimpan sebagai draf.</span>
                </span>
            </label>
            @if($errors->any() && old('form_mode') === 'create')
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs text-rose-700">Periksa kembali isi yang ditandai belum valid.</div>
            @endif
            <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-white px-6 py-4 sm:flex-row sm:justify-end">
                <button type="button" onclick="this.closest('dialog').close()" class="rounded-xl border border-slate-200 px-5 py-3 text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-xs font-semibold text-white hover:bg-blue-700">Terbitkan Pengumuman</button>
            </div>
        </form>
    </div>
</dialog>

@foreach($announcements as $announcement)
<dialog id="announcement-edit-modal-{{ $announcement->id }}" class="m-auto w-[calc(100%-2rem)] max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white p-0 text-left shadow-2xl">
    <div class="max-h-[calc(100vh-3rem)] overflow-y-auto">
        <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-6 py-3" style="min-height:72px;">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-amber-600">Perbarui informasi</p>
                <h3 class="mt-1 text-base font-bold text-slate-800">Edit Pengumuman</h3>
            </div>
            <button type="button" onclick="this.closest('dialog').close()" class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup">✕</button>
        </div>
        <form method="POST" action="{{ route('announcements.update', $announcement) }}" class="space-y-4" style="padding:18px 24px 0;">
            @csrf
            @method('PUT')
            <input type="hidden" name="form_mode" value="edit-{{ $announcement->id }}">
            <div>
                <label for="edit-announcement-title-{{ $announcement->id }}" class="mb-2 block text-xs font-semibold text-slate-700">Judul pengumuman <span class="text-rose-500">*</span></label>
                <input id="edit-announcement-title-{{ $announcement->id }}" type="text" name="title" value="{{ old('form_mode') === 'edit-'.$announcement->id ? old('title') : $announcement->title }}" required maxlength="255" class="w-full rounded-xl border-slate-200 px-3.5 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="edit-announcement-content-{{ $announcement->id }}" class="mb-2 block text-xs font-semibold text-slate-700">Isi pengumuman <span class="text-rose-500">*</span></label>
                <textarea id="edit-announcement-content-{{ $announcement->id }}" name="content" rows="8" required maxlength="20000" class="w-full resize-y rounded-xl border-slate-200 px-3.5 py-3 text-sm leading-relaxed focus:border-blue-500 focus:ring-blue-500">{{ old('form_mode') === 'edit-'.$announcement->id ? old('content') : $announcement->content }}</textarea>
            </div>
            <div>
                <label for="edit-announcement-target-{{ $announcement->id }}" class="mb-2 block text-xs font-semibold text-slate-700">Target audiens</label>
                <select id="edit-announcement-target-{{ $announcement->id }}" name="target_role" class="w-full rounded-xl border-slate-200 px-3.5 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach(['public' => 'Publik', 'all' => 'Semua pengguna', 'mahasiswa' => 'Mahasiswa', 'dosen_pa' => 'Dosen PA'] as $target => $label)
                        <option value="{{ $target }}" @selected((old('form_mode') === 'edit-'.$announcement->id ? old('target_role') : $announcement->target_role) === $target)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5">
                <input type="checkbox" name="is_active" value="1" @checked(old('form_mode') === 'edit-'.$announcement->id ? old('is_active') : $announcement->is_active) class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <span>
                    <span class="block text-xs font-semibold text-slate-800">Publikasikan pengumuman</span>
                    <span class="mt-1 block text-[11px] text-slate-500">Kosongkan untuk menyimpan sebagai draf.</span>
                </span>
            </label>
            @if($errors->any() && old('form_mode') === 'edit-'.$announcement->id)
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs text-rose-700">Periksa kembali isi yang ditandai belum valid.</div>
            @endif
            <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-white px-6 py-4 sm:flex-row sm:justify-end">
                <button type="button" onclick="this.closest('dialog').close()" class="rounded-xl border border-slate-200 px-5 py-3 text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-xs font-semibold text-white hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</dialog>
@endforeach

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(old('form_mode') === 'create')
        document.getElementById('announcement-create-modal')?.showModal();
    @elseif(str_starts_with((string) old('form_mode'), 'edit-'))
        document.getElementById('announcement-edit-modal-{{ substr((string) old('form_mode'), 5) }}')?.showModal();
    @endif
});
</script>
@endif
@endsection
