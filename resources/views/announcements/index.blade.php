@extends('layouts.guest')

@section('title', 'Pengumuman Fakultas')

@section('content')
<div class="w-full">
    <section class="bg-white border-b border-slate-200/80 py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    Pusat Informasi Resmi
                </span>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Pengumuman &amp; Edaran</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Informasi terbaru beasiswa, kegiatan, dan layanan Fakultas MIPA.</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-10">
        <div class="space-y-4">
            @forelse($announcements as $announcement)
                <article class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs hover:border-blue-300 transition-all">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-3">
                        <span class="inline-flex self-start px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60">Pengumuman Fakultas</span>
                        <span class="text-[11px] text-slate-400">{{ $announcement->created_at->format('d F Y') }} · {{ $announcement->creator?->name ?? 'FMIPA' }}</span>
                    </div>
                    <h2 class="text-base font-bold text-slate-900">{{ $announcement->title }}</h2>
                    <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line mt-2">{{ $announcement->content }}</p>
                </article>
            @empty
                <div class="bg-white border border-slate-200/90 rounded-2xl px-6 py-16 text-center shadow-xs">
                    <div class="mx-auto w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-700">Belum ada pengumuman</p>
                    <p class="text-xs text-slate-400 mt-1">Pengumuman fakultas yang telah diterbitkan akan tampil di sini.</p>
                </div>
            @endforelse
        </div>

        @if($announcements->hasPages())
            <div class="mt-6">{{ $announcements->links() }}</div>
        @endif
    </section>
</div>
@endsection
