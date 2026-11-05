@extends('layouts.app')

@section('title', 'Detail Verifikasi')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <a href="{{ auth()->user()->role == 'admin' ? route('verifikasi.akhir') : route('verifikasi.awal') }}"
       class="text-sm text-blue-600 font-medium">
        ← Kembali ke Verifikasi
    </a>

    <div>
        <h1 class="text-2xl font-bold text-slate-800 mt-4">Detail Pengajuan Beasiswa</h1>
        <p class="text-sm text-slate-500 mt-1">
            Periksa informasi mahasiswa dan dokumen persyaratan.
        </p>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl p-6">

        <h2 class="font-bold text-slate-800 mb-5">Informasi Mahasiswa</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-xs text-slate-400">Nama Mahasiswa</p>
                <p class="font-semibold text-slate-800 mt-1">
                    {{ $application->user->name }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Email</p>
                <p class="font-semibold text-slate-800 mt-1">
                    {{ $application->user->email }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Program Beasiswa</p>
                <p class="font-semibold text-slate-800 mt-1">
                    {{ $application->scholarship->name }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">IPK Mahasiswa</p>
                <p class="font-semibold text-slate-800 mt-1">
                    {{ number_format($application->gpa_score, 2) }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Minimal IPK Beasiswa</p>
                <p class="font-semibold text-slate-800 mt-1">
                    {{ number_format($application->scholarship->min_gpa, 2) }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Status Pengajuan</p>
                <p class="font-semibold text-blue-600 mt-1">
                    {{ ucwords(str_replace('_', ' ', $application->status)) }}
                </p>
            </div>

        </div>

    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6">

        <h2 class="font-bold text-slate-800 mb-5">Dokumen Persyaratan</h2>

        <div class="space-y-4">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-slate-50 rounded-xl">

                <div>
                    <p class="font-semibold text-slate-700 text-sm">Berkas Pendaftaran</p>
                    <p class="text-xs text-slate-400 mt-1">Dokumen persyaratan mahasiswa</p>
                </div>

                @if($application->document_file)
                    <a href="{{ asset('storage/'.$application->document_file) }}"
                       target="_blank"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold text-center">
                        Lihat Dokumen
                    </a>
                @else
                    <span class="text-xs text-red-500">Dokumen belum tersedia</span>
                @endif

            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-slate-50 rounded-xl">

                <div>
                    <p class="font-semibold text-slate-700 text-sm">Bukti Kelolosan Resmi</p>
                    <p class="text-xs text-slate-400 mt-1">Surat atau bukti penerimaan dari penyelenggara</p>
                </div>

                @if($application->acceptance_proof_file)
                    <a href="{{ asset('storage/'.$application->acceptance_proof_file) }}"
                       target="_blank"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold text-center">
                        Lihat Bukti
                    </a>
                @else
                    <span class="text-xs text-red-500">Belum diunggah</span>
                @endif

            </div>

        </div>

    </div>

    @if(auth()->user()->role == 'dosen' && $application->status == 'pending')

    <div class="bg-white border border-slate-200 rounded-2xl p-6">

        <h2 class="font-bold text-slate-800 mb-2">Keputusan Dosen PA</h2>

        <p class="text-sm text-slate-500 mb-5">
            Berikan keputusan berdasarkan hasil pemeriksaan dokumen mahasiswa.
        </p>

        <form action="{{ route('verifikasi.dosen', $application->id) }}"
              method="POST" class="space-y-5">

            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Catatan Verifikasi
                </label>

                <textarea name="dosen_notes" rows="4"
                          class="w-full border border-slate-200 rounded-xl p-4 text-sm"
                          placeholder="Masukkan catatan atau alasan penolakan...">{{ old('dosen_notes') }}</textarea>
            </div>

            @error('decision')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <div class="flex flex-col sm:flex-row justify-end gap-3">

                <button name="decision" value="reject"
                        class="px-6 py-3 bg-red-50 text-red-600 rounded-xl text-sm font-semibold">
                    Tolak Berkas
                </button>

                <button name="decision" value="verify"
                        class="px-6 py-3 bg-blue-600 text-white rounded-xl text-sm font-semibold">
                    Verifikasi Berkas
                </button>

            </div>

        </form>

    </div>

    @endif

    @if(auth()->user()->role == 'admin' && $application->status == 'verified_by_dosen')

    <div class="bg-white border border-slate-200 rounded-2xl p-6">

        <h2 class="font-bold text-slate-800 mb-2">Verifikasi Akhir Admin</h2>

        <p class="text-sm text-slate-500 mb-5">
            Pastikan bukti kelolosan resmi sudah sesuai sebelum menetapkan mahasiswa sebagai Awardee.
        </p>

        <div class="mb-5 p-4 bg-blue-50 border border-blue-100 rounded-xl">
            <p class="text-sm text-blue-700">
                Berkas mahasiswa telah melewati verifikasi awal oleh Dosen PA.
            </p>
        </div>

        <form action="{{ route('verifikasi.admin', $application->id) }}"
              method="POST" class="space-y-5">

            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Catatan Admin
                </label>

                <textarea name="admin_notes" rows="4"
                          class="w-full border border-slate-200 rounded-xl p-4 text-sm"
                          placeholder="Masukkan catatan verifikasi...">{{ old('admin_notes') }}</textarea>
            </div>

            @error('decision')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <div class="flex flex-col sm:flex-row justify-end gap-3">

                <button name="decision" value="reject"
                        class="px-6 py-3 bg-red-50 text-red-600 rounded-xl text-sm font-semibold">
                    Tolak Pengajuan
                </button>

                <button name="decision" value="approve"
                        class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-semibold">
                    Tetapkan Awardee
                </button>

            </div>

        </form>

    </div>

    @endif

</div>
@endsection