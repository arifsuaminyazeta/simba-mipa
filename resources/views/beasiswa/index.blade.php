@extends('layouts.app')

@section('title', 'Kelola Beasiswa')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Beasiswa</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi, kuota, dan periode program beasiswa.</p>
        </div>

        <a href="{{ route('demo.beasiswa.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm">
            <span>+</span> Tambah Beasiswa
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Beasiswa</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $total ?? 0 }}</h2>
            <p class="text-xs text-slate-400 mt-2">Seluruh program terdaftar</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Beasiswa Aktif</p>
            <h2 class="text-3xl font-bold text-emerald-600 mt-2">{{ $active ?? 0 }}</h2>
            <p class="text-xs text-slate-400 mt-2">Program sedang dibuka</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Pendaftar</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $applications ?? 0 }}</h2>
            <p class="text-xs text-slate-400 mt-2">Seluruh pengajuan mahasiswa</p>
        </div>

    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5">

        <form action="{{ route('demo.beasiswa.index') }}" method="GET"
              class="flex flex-col md:flex-row gap-3 mb-5">

            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama atau penyedia beasiswa..."
                   class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">

            <select name="status"
                    class="border border-slate-200 rounded-xl px-4 py-3 text-sm">
                <option value="">Semua Status</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Dibuka</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
            </select>

            <button class="px-5 py-3 bg-slate-800 text-white rounded-xl text-sm font-medium">
                Filter
            </button>

        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-xs text-slate-500 uppercase border-b border-slate-200">
                        <th class="py-4 px-3">No</th>
                        <th class="py-4 px-3">Nama Beasiswa</th>
                        <th class="py-4 px-3">Penyedia</th>
                        <th class="py-4 px-3">Minimal IPK</th>
                        <th class="py-4 px-3">Kuota</th>
                        <th class="py-4 px-3">Periode</th>
                        <th class="py-4 px-3">Status</th>
                        <th class="py-4 px-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($scholarships as $item)
                    <tr class="hover:bg-slate-50">

                        <td class="py-4 px-3 text-slate-500">
                            {{ $scholarships->firstItem() + $loop->index }}
                        </td>

                        <td class="py-4 px-3 font-semibold text-slate-800">
                            {{ $item->name }}
                        </td>

                        <td class="py-4 px-3 text-slate-600">
                            {{ $item->provider }}
                        </td>

                        <td class="py-4 px-3">
                            {{ number_format($item->min_gpa, 2) }}
                        </td>

                        <td class="py-4 px-3">
                            <span class="font-semibold">{{ $item->remaining_quota }}</span>
                            <span class="text-slate-400">/ {{ $item->quota }}</span>
                        </td>

                        <td class="py-4 px-3 text-xs text-slate-500">
                            {{ $item->open_date->format('d/m/Y') }}
                            <br>
                            sampai {{ $item->close_date->format('d/m/Y') }}
                        </td>

                        <td class="py-4 px-3">
                            @if($item->status == 'open')
                                <span class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                                    Dibuka
                                </span>
                            @else
                                <span class="px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-xs font-semibold">
                                    Ditutup
                                </span>
                            @endif
                        </td>

                        <td class="py-4 px-3">
                            <div class="flex items-center justify-center gap-2">

                                <a href="{{ route('demo.beasiswa.show', $item->id) }}"
                                   class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">
                                    Detail
                                </a>

                                <a href="{{ route('demo.beasiswa.edit', $item->id) }}"
                                   class="px-3 py-2 bg-amber-50 text-amber-600 rounded-lg text-xs font-semibold">
                                    Edit
                                </a>

                                <form action="{{ route('demo.beasiswa.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus beasiswa ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs font-semibold">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-12 text-slate-400">
                            Belum ada data beasiswa.
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $scholarships->links() }}
        </div>

    </div>

</div>
@endsection