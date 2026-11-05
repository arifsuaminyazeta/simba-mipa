@extends('layouts.app')

@section('title', 'Edit Beasiswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <a href="{{ route('beasiswa.index') }}" class="text-sm text-blue-600 font-medium">
            ← Kembali ke Kelola Beasiswa
        </a>

        <h1 class="text-2xl font-bold text-slate-800 mt-4">Edit Beasiswa</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui informasi program beasiswa.</p>
    </div>

    <form action="{{ route('beasiswa.update', $scholarship->id) }}"
          method="POST"
          class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 space-y-6">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-2">Nama Beasiswa</label>
                <input type="text" name="name"
                       value="{{ old('name', $scholarship->name) }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                       required>
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-2">Instansi Penyedia</label>
                <input type="text" name="provider"
                       value="{{ old('provider', $scholarship->provider) }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                       required>
                @error('provider') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Minimal IPK</label>
                <input type="number" name="min_gpa"
                       value="{{ old('min_gpa', $scholarship->min_gpa) }}"
                       min="0" max="4" step="0.01"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                       required>
                @error('min_gpa') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Kuota</label>
                <input type="number" name="quota"
                       value="{{ old('quota', $scholarship->quota) }}"
                       min="1"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                       required>
                @error('quota') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Tanggal Pembukaan</label>
                <input type="date" name="open_date"
                       value="{{ old('open_date', $scholarship->open_date->format('Y-m-d')) }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Tanggal Penutupan</label>
                <input type="date" name="close_date"
                       value="{{ old('close_date', $scholarship->close_date->format('Y-m-d')) }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                       required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-2">Status</label>
                <select name="status" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm">
                    <option value="open" {{ $scholarship->status == 'open' ? 'selected' : '' }}>Dibuka</option>
                    <option value="closed" {{ $scholarship->status == 'closed' ? 'selected' : '' }}>Ditutup</option>
                </select>
            </div>

        </div>

        <div class="flex justify-end gap-3 pt-5 border-t border-slate-100">

            <a href="{{ route('beasiswa.index') }}"
               class="px-5 py-3 border border-slate-200 rounded-xl text-sm font-semibold">
                Batal
            </a>

            <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-xl text-sm font-semibold">
                Simpan Perubahan
            </button>

        </div>

    </form>
</div>
@endsection