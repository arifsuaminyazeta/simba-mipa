@extends('layouts.app')

@section('title', 'Pelaporan KHS & Evaluasi IPK')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Unggah KHS & Monitoring IPK</h1>
            <p class="text-xs text-slate-500 mt-1">Pelaporan capaian akademik berkala untuk evaluasi keberlanjutan beasiswa (Early Warning System).</p>
        </div>
        <div class="flex items-center gap-2">
            @if($latest)
                @if($latest->ews_status === 'aman')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Status EWS: Aman (Normal)
                    </span>
                @elseif($latest->ews_status === 'warning')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 text-xs font-semibold border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Status EWS: Peringatan (Warning)
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 text-xs font-semibold border border-rose-200">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        Status EWS: {{ ucfirst($latest->ews_status) }}
                    </span>
                @endif
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 text-slate-600 text-xs font-semibold border border-slate-200">
                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                    Status: Belum Ada Laporan KHS
                </span>
            @endif
        </div>
    </div>

    <!-- Feedback Notifikasi -->
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

    <!-- Banner Peringatan Kunci Pelaporan -->
    @if($blockReason)
        <div class="flex items-start gap-3 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
                <p class="font-bold">Pelaporan KHS Dikunci</p>
                <p class="mt-0.5 text-amber-800">{{ $blockReason }}</p>
            </div>
        </div>
    @endif

    <!-- Banner Ringkasan Standar EWS Beasiswa Aktif -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Beasiswa Aktif</p>
            <h3 class="text-base font-bold text-blue-700 mt-1">{{ $scholarship->name ?? 'Belum Terdaftar Beasiswa' }}</h3>
            <p class="text-[11px] text-blue-600 font-medium mt-1">
                {{ $scholarship ? ($scholarship->provider . ' · Wajib lapor') : 'Khusus Mahasiswa Awardee' }}
            </p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Batas Minimal IPK (Ambang Batas)</p>
            <h3 class="text-2xl font-extrabold text-amber-600 mt-1">
                {{ $scholarship ? number_format((float) $scholarship->min_gpa, 2) : '-' }}
            </h3>
            <p class="text-[11px] text-amber-600 font-medium mt-1">
                IPK &lt; {{ $scholarship ? number_format((float) $scholarship->min_gpa, 2) : '3.00' }} memicu peringatan Dosen PA
            </p>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">IPK Kumulatif Terakhir</p>
            <h3 class="text-2xl font-extrabold {{ $latest && $scholarship && $latest->ipk_score < $scholarship->min_gpa ? 'text-rose-600' : 'text-emerald-600' }} mt-1">
                {{ $latest ? number_format((float) $latest->ipk_score, 2) : '-' }}
            </h3>
            <p class="text-[11px] {{ $latest && $scholarship && $latest->ipk_score < $scholarship->min_gpa ? 'text-rose-600' : 'text-emerald-600' }} font-semibold mt-1">
                @if(!$latest)
                    Belum ada data evaluasi KHS
                @elseif($scholarship && $latest->ipk_score < $scholarship->min_gpa)
                    ⚠ Di bawah ambang batas beasiswa
                @else
                    ✓ Di atas ambang batas syarat
                @endif
            </p>
        </div>
    </div>

    <!-- Form Unggah KHS Semester Berjalan -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
        <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-6">
            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Form Laporan KHS Baru</h3>
                <p class="text-[11px] text-slate-400">Masukkan nilai resmi sesuai Kartu Hasil Studi yang telah divalidasi pembimbing akademik.</p>
            </div>
        </div>

        @if($blockReason)
            <div class="p-6 text-center bg-slate-50 rounded-2xl border border-slate-200">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Formulir Tidak Tersedia</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">{{ $blockReason }}</p>
            </div>
        @else
            <form action="{{ route('akademik.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label for="semester_ke" class="block text-[11px] font-semibold text-slate-700 mb-1.5">
                            Pilih Semester Dilaporkan <span class="text-rose-500">*</span>
                        </label>
                        <select id="semester_ke" name="semester_ke" required class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('semester_ke') ? 'border-rose-400' : 'border-slate-200' }} text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                            <option value="">-- Pilih Semester --</option>
                            @for($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" @selected(old('semester_ke', ($latest ? $latest->semester_ke + 1 : 1)) == $i)>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('semester_ke')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ips_score" class="block text-[11px] font-semibold text-slate-700 mb-1.5">
                            Indeks Prestasi Semester (IPS) <span class="text-rose-500">*</span>
                        </label>
                        <input id="ips_score" type="number" step="0.01" min="0" max="4.00" name="ips_score" value="{{ old('ips_score') }}" placeholder="Contoh: 3.85" required class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('ips_score') ? 'border-rose-400' : 'border-slate-200' }} text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                        @error('ips_score')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ipk_score" class="block text-[11px] font-semibold text-slate-700 mb-1.5">
                            Indeks Prestasi Kumulatif (IPK) <span class="text-rose-500">*</span>
                        </label>
                        <input id="ipk_score" type="number" step="0.01" min="0" max="4.00" name="ipk_score" value="{{ old('ipk_score') }}" placeholder="Contoh: 3.96" required class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('ipk_score') ? 'border-rose-400' : 'border-slate-200' }} text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium">
                        @error('ipk_score')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Upload File KHS PDF -->
                <div class="border-2 border-dashed {{ $errors->has('khs_file') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200 bg-slate-50/50' }} rounded-2xl p-6 text-center hover:border-blue-400 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-800 mb-1">Pilih atau seret berkas KHS resmi (PDF)</p>
                    <p class="text-[11px] text-slate-400 mb-3">Ukuran maksimal file 2 MB. Pastikan barcode atau tanda tangan sah terlihat jelas.</p>
                    <label class="inline-flex cursor-pointer px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-all shadow-xs">
                        <span id="khs-file-label">Jelajahi File Komputer</span>
                        <input type="file" name="khs_file" accept=".pdf" required class="hidden" onchange="document.getElementById('khs-file-label').textContent = this.files[0] ? this.files[0].name : 'Jelajahi File Komputer'">
                    </label>
                    @error('khs_file')
                        <p class="text-rose-500 text-[11px] mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 shadow-sm shadow-blue-200 transition-all flex items-center gap-2">
                        <span>Simpan & Kirim KHS</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        @endif
    </div>

    <!-- Riwayat Pelaporan KHS Terdahulu -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-800">Riwayat Nilai Semester & Berkas KHS</h3>
                <p class="text-xs text-slate-400">Rekam jejak evaluasi akademik yang dilaporkan dan diperiksa oleh Dosen PA.</p>
            </div>
            <span class="text-xs font-medium text-slate-500">{{ $evaluations->count() }} Semester Terlaporkan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Semester</th>
                        <th class="px-6 py-3.5">Beasiswa</th>
                        <th class="px-6 py-3.5">IPS</th>
                        <th class="px-6 py-3.5">IPK</th>
                        <th class="px-6 py-3.5">Status EWS</th>
                        <th class="px-6 py-3.5">Verifikasi Dosen PA</th>
                        <th class="px-6 py-3.5 text-right">Berkas KHS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($evaluations as $item)
                        @php
                            $ewsClasses = [
                                'aman' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'kritis' => 'bg-rose-50 text-rose-700 border-rose-200',
                                'revoked' => 'bg-rose-50 text-rose-700 border-rose-200',
                            ];
                            $ewsLabels = [
                                'aman' => 'Aman / Normal',
                                'warning' => 'Peringatan',
                                'kritis' => 'Kritis',
                                'revoked' => 'Dicabut',
                            ];
                            $verifClasses = [
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
                            <td class="px-6 py-4 font-bold text-slate-900">
                                Semester {{ $item->semester_ke }}
                                <p class="text-[10px] text-slate-400 font-normal mt-0.5">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                {{ $item->scholarship->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold {{ $item->ips_score < ($item->scholarship->min_gpa ?? 3.0) ? 'text-rose-600' : ($item->ips_score < ($item->scholarship->min_gpa ?? 3.0) + 0.25 ? 'text-amber-600' : 'text-emerald-600') }}">
                                {{ number_format((float) $item->ips_score, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-12 px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $ewsClasses[$item->ews_status] ?? 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                    {{ number_format((float) $item->ipk_score, 2, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $ewsClasses[$item->ews_status] ?? 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                    {{ $ewsLabels[$item->ews_status] ?? ucfirst($item->ews_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $verifClasses[$item->verification_status] ?? 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                    {{ $verifLabels[$item->verification_status] ?? ucfirst($item->verification_status) }}
                                </span>
                                @if($item->evaluator_notes)
                                    <p class="text-[10px] text-slate-500 mt-1 max-w-xs italic">
                                        Catatan PA: "{{ $item->evaluator_notes }}"
                                    </p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($item->khs_file)
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($item->khs_file) }}" target="_blank" class="text-blue-600 hover:underline font-medium text-[11px] inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Lihat KHS (PDF)
                                    </a>
                                @else
                                    <span class="text-slate-400 text-[11px]">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="text-xs font-semibold text-slate-700">Belum ada riwayat KHS yang dilaporkan</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Silakan isi formulir di atas untuk melaporkan KHS semester terbaru Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
