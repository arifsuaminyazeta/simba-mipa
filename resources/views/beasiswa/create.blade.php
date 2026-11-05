@extends('layouts.app')

@section('title', 'Tambah Beasiswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <a href="{{ route('demo.beasiswa.index') }}" class="text-sm text-blue-600 font-medium">
            ← Kembali ke Kelola Beasiswa
        </a>

        <h1 class="text-2xl font-bold text-slate-800 mt-4">Tambah Beasiswa</h1>
        <p class="text-sm text-slate-500 mt-1">Masukkan informasi program beasiswa baru.</p>
    </div>

    <form action="{{ route('demo.beasiswa.store') }}" method="POST"
          class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 space-y-6">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Beasiswa</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Contoh: Beasiswa KIP Kuliah"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Instansi Penyedia</label>
                <input type="text" name="provider" value="{{ old('provider') }}"
                       placeholder="Nama instansi atau perusahaan"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('provider') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Minimal IPK</label>
                <input type="number" name="min_gpa" value="{{ old('min_gpa') }}"
                       step="0.01" min="0" max="4"
                       placeholder="3.00"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('min_gpa') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kuota Penerima</label>
                <input type="number" name="quota" value="{{ old('quota') }}"
                       min="1"
                       placeholder="100"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('quota') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pembukaan</label>
                <input type="date" name="open_date" value="{{ old('open_date') }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('open_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Penutupan</label>
                <input type="date" name="close_date" value="{{ old('close_date') }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('close_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status Beasiswa</label>
                <select name="status"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="open">Dibuka</option>
                    <option value="closed">Ditutup</option>
                </select>
            </div>

        </div>

        <div class="flex justify-end gap-3 pt-5 border-t border-slate-100">

            <a href="{{ route('demo.beasiswa.index') }}"
               class="px-5 py-3 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600">
                Batal
            </a>

            <button type="submit"
                    class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">
                Simpan Beasiswa
            </button>

        </div>

    </form>
</div>
@endsection