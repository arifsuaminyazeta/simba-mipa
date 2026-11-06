@extends('layouts.app')

@section('title', 'Verifikasi Akhir')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800">Verifikasi Akhir Beasiswa</h1>
        <p class="text-sm text-slate-500 mt-1">
            Validasi bukti kelolosan resmi mahasiswa sebelum penetapan status Awardee.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Menunggu Persetujuan</p>
            <h2 class="text-3xl font-bold text-amber-500 mt-2">{{ $countPending }}</h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Disetujui</p>
            <h2 class="text-3xl font-bold text-emerald-600 mt-2">{{ $countApproved }}</h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Ditolak</p>
            <h2 class="text-3xl font-bold text-red-500 mt-2">{{ $countRejected }}</h2>
        </div>

    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5">

        <form method="GET" class="mb-5 flex gap-3">

            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama mahasiswa..."
                   class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm">

            <button class="bg-blue-600 text-white px-5 rounded-xl text-sm font-semibold">
                Cari
            </button>

        </form>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-500 uppercase">
                        <th class="px-3 py-4">No</th>
                        <th class="px-3 py-4">Mahasiswa</th>
                        <th class="px-3 py-4">Program Beasiswa</th>
                        <th class="px-3 py-4">IPK</th>
                        <th class="px-3 py-4">Status</th>
                        <th class="px-3 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($applications as $item)

                    <tr class="hover:bg-slate-50">

                        <td class="px-3 py-4">
                            {{ $applications->firstItem() + $loop->index }}
                        </td>

                        <td class="px-3 py-4">
                            <p class="font-semibold text-slate-800">
                                {{ $item->user->name }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $item->user->email }}
                            </p>
                        </td>

                        <td class="px-3 py-4">
                            {{ $item->scholarship->name }}
                        </td>

                        <td class="px-3 py-4">
                            {{ number_format($item->gpa_score, 2) }}
                        </td>

                        <td class="px-3 py-4">

                            @if($item->status == 'verified_by_dosen')
                                <span class="px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold">
                                    Menunggu Admin
                                </span>
                            @elseif($item->status == 'approved_by_admin')
                                <span class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                                    Disetujui
                                </span>
                            @else
                                <span class="px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-xs font-semibold">
                                    Ditolak
                                </span>
                            @endif

                        </td>

                        <td class="px-3 py-4 text-center">
                            <a href="{{ route('verifikasi.detail', $item->id) }}"
                               class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">
                                Detail
                            </a>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center py-12 text-slate-400">
                            Belum ada data verifikasi.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-5">
            {{ $applications->links() }}
        </div>

    </div>

</div>
@endsection