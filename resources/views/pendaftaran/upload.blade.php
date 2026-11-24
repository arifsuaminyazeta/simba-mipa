@extends('layouts.app')

@section('title', 'Unggah LoA/SK')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('mahasiswa.pendaftaran.show', $application) }}" class="text-sm text-blue-600 font-medium">← Kembali ke Detail Pengajuan</a>

    <div class="bg-white border border-slate-200 rounded-2xl p-6">
        <h1 class="text-2xl font-bold text-slate-800">Unggah Bukti Kelolosan</h1>
        <p class="text-sm text-slate-500 mt-1">{{ $application->scholarship->name }}</p>

        @if($errors->any())
            <div class="mt-5 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('mahasiswa.pendaftaran.upload-sk.store', $application) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf
            <div>
                <label for="acceptance_proof_file" class="block text-sm font-semibold text-slate-700 mb-2">Bukti kelolosan resmi LoA/SK (PDF, maks. 2 MB)</label>
                <input id="acceptance_proof_file" type="file" name="acceptance_proof_file" accept=".pdf,application/pdf" required class="block w-full text-sm text-slate-600">
            </div>
            <div class="flex justify-end">
                <button class="px-5 py-3 bg-blue-600 text-white rounded-xl text-sm font-semibold">Kirim LoA/SK</button>
            </div>
        </form>
    </div>
</div>
@endsection