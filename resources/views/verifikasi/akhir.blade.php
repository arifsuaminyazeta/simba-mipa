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
            <h2 class="text-3xl font-bold text-rose-600 mt-2">{{ $countRejected }}</h2>
        </div>

    </div>

    <form method="GET" action="{{ route('verifikasi.akhir') }}" class="bg-white border border-slate-200 rounded-2xl p-5 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mahasiswa..."
            class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm">
        <button class="bg-blue-600 text-white px-5 rounded-xl text-sm font-semibold">Cari</button>
    </form>

    @foreach([
        ['title' => 'Antrean Surat Rekomendasi', 'applications' => $recommendationApplications, 'empty' => 'Tidak ada pengajuan yang menunggu surat rekomendasi.'],
        ['title' => 'Antrean Konfirmasi LoA/SK', 'applications' => $loaApplications, 'empty' => 'Tidak ada LoA/SK yang menunggu konfirmasi.'],
    ] as $queue)
        <section class="bg-white border border-slate-200 rounded-2xl p-5">
            <h2 class="font-bold text-slate-800 mb-5">{{ $queue['title'] }}</h2>
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
                        @forelse($queue['applications'] as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-3 py-4">{{ $queue['applications']->firstItem() + $loop->index }}</td>
                                <td class="px-3 py-4">
                                    <p class="font-semibold text-slate-800">{{ $item->user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $item->user->email }}</p>
                                </td>
                                <td class="px-3 py-4">{{ $item->scholarship->name }}</td>
                                <td class="px-3 py-4 font-bold text-blue-600">{{ number_format((float) $item->gpa_score, 2) }}</td>
                                <td class="px-3 py-4">{{ ucwords(str_replace('_', ' ', $item->status)) }}</td>
                                <td class="px-3 py-4 text-center">
                                    <button type="button" onclick="document.getElementById('verification-detail-modal-{{ $item->id }}').showModal()" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">Detail</button>
                                </td>
                            </tr>
                            <dialog id="verification-detail-modal-{{ $item->id }}" class="m-auto w-[calc(100%-2rem)] max-w-3xl rounded-2xl border border-slate-200 bg-white p-0 text-left shadow-2xl">
                                <div class="dialog-scroll">
                                    <div class="sticky top-0 z-10 flex items-start justify-between border-b border-slate-100 bg-white" style="min-height:72px;padding:14px 24px;">
                                        <div><p class="text-[10px] font-bold uppercase tracking-wider text-blue-600">Detail verifikasi</p><h3 class="mt-1 text-sm font-bold text-slate-800">{{ $item->user->name }}</h3><p class="mt-0.5 text-xs text-slate-400">{{ $item->scholarship->name }}</p></div>
                                        <button type="button" onclick="document.getElementById('verification-detail-modal-{{ $item->id }}').close()" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100">✕</button>
                                    </div>
                                    <div class="space-y-5 px-6 py-5">
                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                            <div class="rounded-xl bg-slate-50 p-4"><p class="text-[11px] text-slate-400">Mahasiswa</p><p class="mt-1 text-xs font-bold text-slate-800">{{ $item->user->nim_nip }} · {{ $item->user->major }}</p></div>
                                            <div class="rounded-xl bg-slate-50 p-4"><p class="text-[11px] text-slate-400">IPK</p><p class="mt-1 text-sm font-bold text-blue-600">{{ number_format((float) $item->gpa_score, 2) }}</p></div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                            @if($item->document_file)<a href="{{ asset('storage/'.$item->document_file) }}" target="_blank" class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-center text-xs font-semibold text-blue-700">Lihat Berkas Pendaftaran</a>@endif
                                            @if($item->acceptance_proof_file)<a href="{{ asset('storage/'.$item->acceptance_proof_file) }}" target="_blank" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-center text-xs font-semibold text-emerald-700">Lihat LoA/SK</a>@endif
                                        </div>
                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                            <div class="rounded-xl border border-slate-200 p-4"><p class="text-xs font-bold text-slate-800">Catatan Dosen PA</p><p class="mt-2 whitespace-pre-line text-xs text-slate-600">{{ $item->dosen_notes ?: 'Belum ada catatan.' }}</p></div>
                                            <div class="rounded-xl border border-slate-200 p-4"><p class="text-xs font-bold text-slate-800">Catatan Admin</p><p class="mt-2 whitespace-pre-line text-xs text-slate-600">{{ $item->admin_notes ?: 'Belum ada catatan.' }}</p></div>
                                        </div>
                                        @if(in_array($item->status, ['verified_by_dosen', 'loa_submitted'], true))
                                            <form action="{{ route('verifikasi.admin', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-4 border-t border-slate-100 pt-5">
                                                @csrf
                                                @if($item->status === 'verified_by_dosen')
                                                    <div><label class="mb-1.5 block text-xs font-semibold text-slate-700">Surat Rekomendasi (PDF) *</label><input type="file" name="recommendation_letter_file" accept=".pdf,application/pdf" required class="block w-full text-xs text-slate-600"></div>
                                                @endif
                                                <div><label class="mb-1.5 block text-xs font-semibold text-slate-700">Catatan Admin</label><textarea name="admin_notes" rows="3" class="w-full rounded-xl border-slate-200 text-xs">{{ $item->admin_notes }}</textarea></div>
                                                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-white py-4 sm:flex-row sm:justify-end"><button type="submit" name="decision" value="reject" class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-2.5 text-xs font-semibold text-rose-700">Tolak</button><button type="submit" name="decision" value="approve" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-semibold text-white">{{ $item->status === 'verified_by_dosen' ? 'Setujui Pengajuan' : 'Tetapkan Awardee' }}</button></div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </dialog>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400">{{ $queue['empty'] }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-5">{{ $queue['applications']->links() }}</div>
        </section>
    @endforeach

</div>
@endsection