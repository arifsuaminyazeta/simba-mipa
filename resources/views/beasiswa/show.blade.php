@extends('layouts.app')

@section('title', 'Detail Beasiswa')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <a href="{{ route('demo.beasiswa.index') }}" class="text-sm text-blue-600 font-medium">
        ← Kembali ke Kelola Beasiswa
    </a>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8">

        <div class="flex flex-col md:flex-row md:justify-between gap-4">

            <div>
                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Detail Program Beasiswa</p>

                <h1 class="text-2xl font-bold text-slate-800 mt-2">
                    {{ $scholarship->name }}
                </h1>

                <p class="text-sm text-slate-500 mt-2">
                    Disediakan oleh {{ $scholarship->provider }}
                </p>
            </div>

            <div>
                @if($scholarship->status == 'open')
                    <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-semibold">
                        Sedang Dibuka
                    </span>
                @else
                    <span class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-sm font-semibold">
                        Ditutup
                    </span>
                @endif
            </div>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-8">

            <div class="bg-slate-50 rounded-xl p-5">
                <p class="text-xs text-slate-500">Minimal IPK</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-2">
                    {{ number_format($scholarship->min_gpa, 2) }}
                </h2>
            </div>

            <div class="bg-slate-50 rounded-xl p-5">
                <p class="text-xs text-slate-500">Total Kuota</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-2">
                    {{ $scholarship->quota }}
                </h2>
            </div>

            <div class="bg-slate-50 rounded-xl p-5">
                <p class="text-xs text-slate-500">Sisa Kuota</p>
                <h2 class="text-2xl font-bold text-blue-600 mt-2">
                    {{ $scholarship->remaining_quota }}
                </h2>
            </div>

        </div>

        <div class="mt-8">
            <h3 class="font-semibold text-slate-800 mb-4">Periode Pendaftaran</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <div>
                    <p class="text-xs text-slate-400">Tanggal Pembukaan</p>
                    <p class="font-semibold text-slate-700 mt-1">
                        {{ $scholarship->open_date->format('d F Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400">Tanggal Penutupan</p>
                    <p class="font-semibold text-slate-700 mt-1">
                        {{ $scholarship->close_date->format('d F Y') }}
                    </p>
                </div>

            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">

            <a href="{{ route('demo.beasiswa.edit', $scholarship->id) }}"
               class="px-6 py-3 bg-blue-600 text-white rounded-xl text-sm font-semibold">
                Edit Beasiswa
            </a>

        </div>

    </div>

</div>
@endsection