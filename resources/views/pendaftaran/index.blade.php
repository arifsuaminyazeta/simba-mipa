@extends('layouts.app')

@section('title', 'Status Pendaftaran Beasiswa')

@section('content')
<div class="space-y-8">
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm">{{ $errors->first() }}</div>
    @endif
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Status Pendaftaran Beasiswa</h1>
            <p class="text-xs text-slate-500 mt-1">Lacak tahapan verifikasi berkas, persetujuan Dosen PA, dan keputusan Subbag Kemahasiswaan FMIPA.</p>
        </div>
        <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 shadow-xs transition-all self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Daftar Beasiswa Baru</span>
        </a>
    </div>

    @if($applications->isNotEmpty())
        @php
            $activeApplication = $applications->first();
            $statusLabels = [
                'pending' => 'Menunggu Verifikasi Dosen PA',
                'verified_by_dosen' => 'Menunggu Verifikasi Admin',
                'rejected_by_dosen' => 'Ditolak Dosen PA',
                'approved_by_admin' => 'Disetujui - Unggah LoA/SK',
                'rejected_by_admin' => 'Ditolak Admin',
                'loa_submitted' => 'Menunggu Konfirmasi LoA/SK',
                'awardee_confirmed' => 'Awardee Terkonfirmasi',
            ];
        @endphp
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60">Pengajuan Terbaru</span>
                        <span class="text-xs text-slate-400">Diajukan: {{ $activeApplication->created_at->format('d M Y') }}</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">{{ $activeApplication->scholarship->name }}</h2>
                    <p class="text-xs text-slate-500">IPK saat mendaftar: {{ number_format((float) $activeApplication->gpa_score, 2) }}</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold">
                    {{ $statusLabels[$activeApplication->status] ?? $activeApplication->status }}
                </span>
            </div>
        </div>
    @endif

    <!-- Tabel Riwayat Semua Pendaftaran -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-800">Riwayat Pengajuan Beasiswa</h3>
                <p class="text-xs text-slate-400">Daftar semua permohonan beasiswa yang pernah kamu daftarkan.</p>
            </div>
            <span class="text-xs font-medium text-slate-500">Total {{ $applications->total() }} Pengajuan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Program Beasiswa</th>
                        <th class="px-6 py-3.5">IPK Saat Mendaftar</th>
                        <th class="px-6 py-3.5">Tanggal Daftar</th>
                        <th class="px-6 py-3.5">Status Akhir</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($applications as $application)
                        @php
                            $statusLabels = [
                                'pending' => 'Menunggu Verifikasi Dosen PA',
                                'verified_by_dosen' => 'Menunggu Verifikasi Admin',
                                'rejected_by_dosen' => 'Ditolak Dosen PA',
                                'approved_by_admin' => 'Disetujui - Unggah LoA/SK',
                                'rejected_by_admin' => 'Ditolak Admin',
                                'loa_submitted' => 'Menunggu Konfirmasi LoA/SK',
                                'awardee_confirmed' => 'Awardee Terkonfirmasi',
                            ];
                            $statusClasses = in_array($application->status, ['rejected_by_dosen', 'rejected_by_admin'], true)
                                ? 'bg-rose-50 text-rose-700 border-rose-200'
                                : (in_array($application->status, ['approved_by_admin', 'awardee_confirmed'], true)
                                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                    : 'bg-amber-50 text-amber-700 border-amber-200');
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900">{{ $application->scholarship->name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $application->scholarship->provider }}</p>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ number_format((float) $application->gpa_score, 2) }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $application->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $statusClasses }}">
                                    {{ $statusLabels[$application->status] ?? $application->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('mahasiswa.pendaftaran.show', $application) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-[11px] hover:bg-slate-50 transition-colors">Detail</a>
                                @if($application->status === 'pending')
                                    <a href="{{ route('mahasiswa.pendaftaran.edit', $application) }}" class="ml-1 px-3 py-1.5 rounded-lg border border-blue-200 text-blue-700 font-semibold text-[11px]">Ubah</a>
                                    <form action="{{ route('mahasiswa.pendaftaran.destroy', $application) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="ml-1 px-3 py-1.5 rounded-lg border border-rose-200 text-rose-700 font-semibold text-[11px]" onclick="return confirm('Batalkan pengajuan ini?')">Batalkan</button>
                                    </form>
                                @elseif($application->status === 'approved_by_admin')
                                    <a href="{{ route('mahasiswa.pendaftaran.upload', $application) }}" class="ml-1 px-3 py-1.5 rounded-lg border border-blue-200 text-blue-700 font-semibold text-[11px]">Unggah LoA/SK</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-400">Belum ada pengajuan beasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $applications->links() }}</div>
    </div>
</div>
@endsection