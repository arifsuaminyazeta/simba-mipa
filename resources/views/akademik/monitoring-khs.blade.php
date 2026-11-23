@extends('layouts.app')

@section('title', 'Monitoring EWS Bimbingan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 mb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Early Warning System (EWS) Akademik</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau tren dan stabilitas IPK mahasiswa bimbingan penerima beasiswa untuk mencegah sanksi evaluasi mitra.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200/80">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Dosen Pembimbing Akademik
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Ringkasan Status EWS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Aman</p>
                <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($safeCount, 0, ',', '.') }} <span class="text-xs font-semibold text-emerald-700">Mahasiswa</span></h3>
                <p class="text-[11px] text-emerald-600 mt-1">IPK di atas ambang batas aman</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peringatan / Warning</p>
                <h3 class="text-2xl font-extrabold text-amber-600 mt-1">{{ number_format($warningCount, 0, ',', '.') }} <span class="text-xs font-semibold text-amber-700">Mahasiswa</span></h3>
                <p class="text-[11px] text-amber-600 font-medium mt-1">Mendekati ambang batas minimal</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kritis / Bahaya</p>
                <h3 class="text-2xl font-extrabold text-rose-600 mt-1">{{ number_format($criticalCount, 0, ',', '.') }} <span class="text-xs font-semibold text-rose-700">Mahasiswa</span></h3>
                <p class="text-[11px] text-rose-600 font-medium mt-1">IPK di bawah syarat beasiswa</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </div>
    </div>

    <!-- Tabel Monitoring Mahasiswa Bimbingan -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden mt-8">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Daftar Mahasiswa Bimbingan Penerima Beasiswa</h2>
                <p class="text-xs text-slate-400 mt-0.5">Pantau evaluasi berkala dan lakukan verifikasi KHS anak bimbingan Anda.</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-lg bg-slate-100 text-slate-600">Total: {{ number_format($totalCount, 0, ',', '.') }} Evaluasi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Mahasiswa</th>
                        <th class="px-6 py-3.5">Program Beasiswa</th>
                        <th class="px-4 py-3.5 text-center">IPS</th>
                        <th class="px-4 py-3.5 text-center">IPK</th>
                        <th class="px-5 py-3.5 text-center">Indikator EWS</th>
                        <th class="px-5 py-3.5 text-center">Status Verifikasi</th>
                        <th class="px-6 py-3.5 text-center">Tindakan Dosen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($evaluations as $evaluation)
                        @php
                            $ewsStyles = [
                                'aman' => [
                                    'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'dot' => 'bg-emerald-600',
                                    'label' => 'Aman & Stabil',
                                ],
                                'warning' => [
                                    'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'dot' => 'bg-amber-600 animate-pulse',
                                    'label' => 'Perlu Perhatian',
                                ],
                                'kritis' => [
                                    'badge' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    'dot' => 'bg-rose-600 animate-pulse',
                                    'label' => 'Kritis / Bahaya',
                                ],
                                'revoked' => [
                                    'badge' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    'dot' => 'bg-rose-600 animate-pulse',
                                    'label' => 'Dicabut',
                                ],
                            ];
                            $currentEws = $ewsStyles[$evaluation->ews_status] ?? $ewsStyles['aman'];

                            $verifStyles = [
                                'pending' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'verified' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'revision' => 'bg-rose-50 text-rose-700 border-rose-200',
                            ];
                            $verifLabels = [
                                'pending' => 'Menunggu Verifikasi',
                                'verified' => 'Terverifikasi',
                                'revision' => 'Perlu Revisi',
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900 text-[13px]">{{ $evaluation->user->name ?? '-' }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $evaluation->user->nim_nip ?? '-' }} · Semester {{ $evaluation->semester_ke }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-800 text-xs">{{ $evaluation->scholarship->name ?? '-' }}</span>
                                <p class="text-[10px] text-blue-600 mt-0.5">Min. IPK: {{ number_format((float) ($evaluation->scholarship->min_gpa ?? 3.0), 2) }}</p>
                            </td>
                            <td class="px-4 py-4 text-center font-bold {{ $evaluation->ips_score < ($evaluation->scholarship->min_gpa ?? 3.0) ? 'text-rose-600' : ($evaluation->ips_score < ($evaluation->scholarship->min_gpa ?? 3.0) + 0.25 ? 'text-amber-600' : 'text-emerald-600') }}">
                                {{ number_format((float) $evaluation->ips_score, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $currentEws['badge'] }} border">
                                    {{ number_format((float) $evaluation->ipk_score, 2, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-medium {{ $currentEws['badge'] }} border">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $currentEws['dot'] }}"></span>
                                    {{ $currentEws['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $verifStyles[$evaluation->verification_status] ?? 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                    {{ $verifLabels[$evaluation->verification_status] ?? ucfirst($evaluation->verification_status) }}
                                </span>
                                @if($evaluation->evaluator_notes)
                                    <p class="text-[10px] text-slate-400 mt-1 max-w-[170px] truncate mx-auto" title="{{ $evaluation->evaluator_notes }}">
                                        Catatan: {{ $evaluation->evaluator_notes }}
                                    </p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    @if($evaluation->khs_file)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($evaluation->khs_file) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-[11px] transition-all shadow-xs" title="Lihat Berkas KHS">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Lihat KHS</span>
                                        </a>
                                    @endif

                                    <button type="button" onclick="document.getElementById('verify-modal-{{ $evaluation->id }}').showModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border {{ $evaluation->verification_status === 'verified' ? 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100' }} font-semibold text-[11px] transition-all shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $evaluation->verification_status === 'verified' ? 'Ubah Verifikasi' : 'Verifikasi' }}</span>
                                    </button>
                                </div>

                                <!-- Dialog Modal Verifikasi KHS -->
                                <dialog id="verify-modal-{{ $evaluation->id }}" class="rounded-2xl p-0 backdrop:bg-slate-900/50 shadow-2xl max-w-lg w-full m-auto border border-slate-200">
                                    <div class="bg-white p-6 rounded-2xl text-left">
                                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                            <div>
                                                <h3 class="text-sm font-bold text-slate-800">Verifikasi KHS Mahasiswa</h3>
                                                <p class="text-xs text-slate-400 mt-0.5">{{ $evaluation->user->name }} · Semester {{ $evaluation->semester_ke }}</p>
                                            </div>
                                            <button type="button" onclick="document.getElementById('verify-modal-{{ $evaluation->id }}').close()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center text-sm font-bold">✕</button>
                                        </div>

                                        <form action="{{ route('akademik.verify', $evaluation) }}" method="POST" class="space-y-4 mt-5">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Keputusan Pembimbing Akademik <span class="text-rose-500">*</span></label>
                                                <div class="grid grid-cols-2 gap-3 text-xs">
                                                    <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-emerald-50/50 has-checked:border-emerald-500 has-checked:bg-emerald-50 has-checked:text-emerald-800 font-semibold transition-all">
                                                        <input type="radio" name="decision" value="verify" @checked(old('decision', $evaluation->verification_status) !== 'revision') required class="text-emerald-600 focus:ring-emerald-500">
                                                        <span>Setujui (Verified)</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-rose-50/50 has-checked:border-rose-500 has-checked:bg-rose-50 has-checked:text-rose-800 font-semibold transition-all">
                                                        <input type="radio" name="decision" value="revision" @checked(old('decision', $evaluation->verification_status) === 'revision') required class="text-rose-600 focus:ring-rose-500">
                                                        <span>Perlu Revisi</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div>
                                                <label for="notes-{{ $evaluation->id }}" class="block text-xs font-semibold text-slate-700 mb-1.5">Catatan Evaluasi / Rekomendasi PA</label>
                                                <textarea id="notes-{{ $evaluation->id }}" name="evaluator_notes" rows="3" placeholder="Tuliskan catatan akademik atau anjuran untuk mahasiswa..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">{{ old('evaluator_notes', $evaluation->evaluator_notes) }}</textarea>
                                            </div>

                                            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                                <button type="button" onclick="document.getElementById('verify-modal-{{ $evaluation->id }}').close()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 transition-colors">Batal</button>
                                                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors shadow-xs">Simpan Keputusan</button>
                                            </div>
                                        </form>
                                    </div>
                                </dialog>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="text-xs font-semibold text-slate-700">Belum ada mahasiswa bimbingan yang melaporkan KHS</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Laporan KHS anak bimbingan Anda akan otomatis muncul di tabel ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($evaluations->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $evaluations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
