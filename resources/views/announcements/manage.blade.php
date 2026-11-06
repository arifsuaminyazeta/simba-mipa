@extends('layouts.app')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Informasi fakultas</p>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">Kelola Pengumuman</h1>
            <p class="text-xs text-slate-500 mt-1">Buat, perbarui, dan atur publikasi pengumuman fakultas.</p>
        </div>
        <a href="{{ route('announcements.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengumuman
        </a>
    </div>

    @if(session('success'))
        <div role="status" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-medium text-emerald-800">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Daftar Pengumuman</h2>
                <p class="text-xs text-slate-400 mt-0.5">Pengumuman aktif tampil di halaman publik.</p>
            </div>
            <a href="{{ route('announcements.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat halaman publik &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Pengumuman</th>
                        <th class="px-5 py-3.5">Dibuat oleh</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4 max-w-xl">
                                <p class="font-bold text-slate-900 text-[13px]">{{ $announcement->title }}</p>
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 whitespace-pre-line">{{ $announcement->content }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $announcement->creator?->name ?? 'Pengguna dihapus' }}</td>
                            <td class="px-5 py-4 whitespace-nowrap text-slate-500">{{ $announcement->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4">
                                @if($announcement->is_active)
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">Terbit</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold">Draf</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('announcements.edit', $announcement) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-[11px] hover:bg-slate-50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('announcements.destroy', $announcement) }}" onsubmit="return confirm('Hapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 text-rose-700 font-semibold text-[11px] hover:bg-rose-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h12"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <p class="text-sm font-semibold text-slate-700">Belum ada pengumuman</p>
                                <p class="text-xs text-slate-400 mt-1">Buat pengumuman pertama untuk membagikan informasi fakultas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($announcements->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $announcements->links() }}</div>
        @endif
    </section>
</div>
@endsection
