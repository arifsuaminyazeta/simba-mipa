@extends('layouts.app')

@section('title', 'Detail Pengajuan Beasiswa')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="text-sm text-blue-600 font-medium">← Kembali ke Pendaftaran</a>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl p-6">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $application->scholarship->name }}</h1>
                <p class="text-sm text-slate-500 mt-1">Diajukan {{ $application->created_at->format('d M Y') }}</p>
            </div>
            <p class="text-sm font-semibold text-blue-700">{{ ucwords(str_replace('_', ' ', $application->status)) }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-6">
            <div>
                <p class="text-xs text-slate-400">IPK saat mendaftar</p>
                <p class="font-semibold text-slate-800 mt-1">{{ number_format((float) $application->gpa_score, 2) }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">IPK minimum beasiswa</p>
                <p class="font-semibold text-slate-800 mt-1">{{ number_format((float) $application->scholarship->min_gpa, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6">
        <h2 class="font-bold text-slate-800 mb-5">Dokumen Pengajuan</h2>
        <div class="space-y-3">
            @foreach([
                'Berkas pendaftaran' => $application->document_file,
                'Surat pernyataan' => $application->statement_file,
                'Esai motivasi' => $application->motivation_file,
                'Surat rekomendasi' => $application->recommendation_letter_file,
                'Bukti kelolosan LoA/SK' => $application->acceptance_proof_file,
            ] as $label => $file)
                <div class="flex items-center justify-between gap-3 p-4 bg-slate-50 rounded-xl">
                    <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                    @if($file)
                        @if($label === 'Surat rekomendasi')
                            <a href="{{ route('mahasiswa.pendaftaran.recommendation', $application) }}" class="text-xs font-semibold text-blue-600">Unduh PDF</a>
                        @else
                            <a href="{{ asset('storage/'.$file) }}" target="_blank" class="text-xs font-semibold text-blue-600">Lihat PDF</a>
                        @endif
                    @else
                        <span class="text-xs text-slate-400">Belum tersedia</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-white border border-slate-200 rounded-2xl p-6">
            <h2 class="font-bold text-slate-800 mb-2">Catatan Dosen PA</h2>
            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $application->dosen_notes ?: 'Belum ada catatan.' }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-6">
            <h2 class="font-bold text-slate-800 mb-2">Catatan Admin</h2>
            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $application->admin_notes ?: 'Belum ada catatan.' }}</p>
        </div>
    </div>

    @if($application->status === 'pending')
        <div class="flex justify-end gap-3">
            <a href="{{ route('mahasiswa.pendaftaran.edit', $application) }}" class="px-4 py-2 border border-blue-200 text-blue-700 rounded-lg text-sm font-semibold">Ubah Pengajuan</a>
            <form action="{{ route('mahasiswa.pendaftaran.destroy', $application) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 border border-rose-200 text-rose-700 rounded-lg text-sm font-semibold" onclick="return confirm('Batalkan pengajuan ini?')">Batalkan</button>
            </form>
        </div>
    @elseif($application->status === 'approved_by_admin')
        <div class="flex justify-end">
            <a href="{{ route('mahasiswa.pendaftaran.upload', $application) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold">Unggah LoA/SK</a>
        </div>
    @endif
</div>
@endsection