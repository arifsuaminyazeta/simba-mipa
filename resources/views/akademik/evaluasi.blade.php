@extends('layouts.app')

@section('title', 'Early Warning System')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Monitoring akademik</p>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">Early Warning System</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau hasil evaluasi KHS dan tindak lanjut penerima beasiswa.</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200/80">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Ambang aman IPS &ge; 3,25
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Evaluasi</p>
                <h2 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalEvaluations, 0, ',', '.') }}</h2>
                <p class="text-[11px] text-slate-400 mt-1">Data KHS tersimpan</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aman</p>
                <h2 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($safeCount, 0, ',', '.') }} <span class="text-sm font-semibold">evaluasi</span></h2>
                <p class="text-[11px] text-slate-400 mt-1">IPS &ge; 3,25 dan tidak berstatus peringatan</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Perlu Perhatian</p>
                <h2 class="text-2xl font-extrabold text-amber-500 mt-1">{{ number_format($warningCount, 0, ',', '.') }} <span class="text-sm font-semibold">evaluasi</span></h2>
                <p class="text-[11px] text-slate-400 mt-1">IPS 3,00–3,24 atau ditandai peringatan</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kritis</p>
                <h2 class="text-2xl font-extrabold text-rose-600 mt-1">{{ number_format($criticalCount, 0, ',', '.') }} <span class="text-sm font-semibold">evaluasi</span></h2>
                <p class="text-[11px] text-slate-400 mt-1">IPS di bawah 3,00 atau status dicabut</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </div>
    </div>

    @if($pendingCount > 0)
        <div class="flex items-start gap-3 rounded-2xl border border-blue-200 bg-blue-50/70 px-4 py-3.5">
            <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-xs text-blue-800"><span class="font-bold">{{ number_format($pendingCount, 0, ',', '.') }} evaluasi</span> masih menunggu verifikasi. Gunakan filter status untuk meninjau berkas tersebut.</p>
        </div>
    @endif

    <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Daftar Evaluasi Mahasiswa</h2>
                <p class="text-xs text-slate-400 mt-0.5">Status EWS ditentukan dari IPS dan status evaluasi KHS.</p>
            </div>
            <form method="GET" action="{{ route('akademik.evaluasi') }}" class="flex flex-col sm:flex-row gap-2">
                <label class="sr-only" for="search">Cari mahasiswa atau beasiswa</label>
                <input id="search" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama, NIM, beasiswa..." class="w-full sm:w-64 rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                <label class="sr-only" for="status">Filter status</label>
                <select id="status" name="status" class="rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua status</option>
                    <option value="pending" @selected(($filters['status'] ?? '') === 'pending')>Menunggu verifikasi</option>
                    <option value="verified" @selected(($filters['status'] ?? '') === 'verified')>Terverifikasi</option>
                    <option value="warning" @selected(($filters['status'] ?? '') === 'warning')>Perlu tindak lanjut</option>
                    <option value="revoked" @selected(($filters['status'] ?? '') === 'revoked')>Dicabut</option>
                </select>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">Terapkan</button>
                @if(($filters['search'] ?? null) || ($filters['status'] ?? null))
                    <a href="{{ route('akademik.evaluasi') }}" class="inline-flex items-center justify-center px-3 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Mahasiswa</th>
                        <th class="px-6 py-3.5">Program Beasiswa</th>
                        <th class="px-4 py-3.5 text-center">Semester</th>
                        <th class="px-4 py-3.5 text-center">IPS</th>
                        <th class="px-5 py-3.5">Indikator EWS</th>
                        <th class="px-5 py-3.5">Status Evaluasi</th>
                        <th class="px-6 py-3.5 text-right">Berkas KHS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($evaluations as $evaluation)
                        @php
                            $isCritical = $evaluation->status === 'revoked' || $evaluation->ips_score < 3.00;
                            $isWarning = !$isCritical && ($evaluation->status === 'warning' || $evaluation->ips_score < 3.25);
                            $indicatorClass = $isCritical
                                ? 'bg-rose-50 text-rose-700 border-rose-200'
                                : ($isWarning ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200');
                            $indicatorLabel = $isCritical ? 'Kritis' : ($isWarning ? 'Perlu perhatian' : 'Aman');
                            $statusStyles = [
                                'pending' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'verified' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'revoked' => 'bg-rose-50 text-rose-700 border-rose-200',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu verifikasi',
                                'verified' => 'Terverifikasi',
                                'warning' => 'Perlu tindak lanjut',
                                'revoked' => 'Dicabut',
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900 text-[13px]">{{ $evaluation->user->name }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $evaluation->user->nim_nip ?: 'NIM belum tersedia' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">{{ $evaluation->scholarship->name }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $evaluation->scholarship->provider }}</p>
                            </td>
                            <td class="px-4 py-4 text-center text-slate-600 font-medium">{{ $evaluation->semester_ke }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-12 px-2.5 py-1 rounded-full text-xs font-bold {{ $indicatorClass }} border">
                                    {{ number_format((float) $evaluation->ips_score, 2, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[10px] font-bold whitespace-nowrap {{ $indicatorClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $isCritical ? 'bg-rose-600' : ($isWarning ? 'bg-amber-500' : 'bg-emerald-600') }}"></span>
                                    {{ $indicatorLabel }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full border text-[10px] font-semibold whitespace-nowrap {{ $statusStyles[$evaluation->status] }}">
                                    {{ $statusLabels[$evaluation->status] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($evaluation->khs_file) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-slate-700 font-semibold text-[11px] hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m0 0L8 8m4-4l4 4M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3"/></svg>
                                    Lihat KHS
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-14 text-center">
                                <div class="mx-auto w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum ada data evaluasi</p>
                                <p class="text-xs text-slate-400 mt-1">Data KHS akan tampil di sini setelah mahasiswa mengirimkan evaluasi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($evaluations->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $evaluations->links() }}</div>
        @endif
    </section>

    <p class="text-[11px] text-slate-400">Indikator EWS menggunakan IPS semester berjalan: aman mulai 3,25, perhatian 3,00–3,24, dan kritis di bawah 3,00. Status dicabut selalu ditampilkan sebagai kritis.</p>
</div>
@endsection