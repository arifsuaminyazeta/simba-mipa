@extends('layouts.app')

@section('title', 'Buat Pengumuman')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="pb-4 border-b border-slate-200">
        <a href="{{ route('announcements.manage') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke pengumuman
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Buat Pengumuman</h1>
        <p class="text-xs text-slate-500 mt-1">Tulis informasi resmi untuk mahasiswa dan alumni FMIPA.</p>
    </div>

    <form method="POST" action="{{ route('announcements.store') }}" class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-6 space-y-5">
        @csrf
        @include('announcements._form', ['announcement' => null])
    </form>
</div>
@endsection
