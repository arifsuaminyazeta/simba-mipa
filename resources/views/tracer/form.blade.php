@extends('layouts.app')

@section('title', 'Kuesioner Tracer Alumni Beasiswa')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Tracer Study Alumni Awardee</p>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">Formulir Tracer Alumni Beasiswa</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui rekam jejak karier Anda untuk mendukung pemetaan alumni dan mentoring adik tingkat FMIPA Unila.</p>
        </div>
        <a href="{{ route('tracer.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition-all self-start sm:self-auto">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Lihat Direktori Publik</span>
        </a>
    </div>

    @if(session('success'))
        <div role="status" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-medium text-emerald-800">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div role="alert" class="flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-medium text-rose-700">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if(! $isEligible)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-amber-900">Akses Formulir Terkunci</h2>
                    <p class="text-xs text-amber-800 mt-1 leading-relaxed">{{ $lockReason }}</p>
                    <p class="text-[11px] text-amber-700 mt-2">Hubungi Admin FMIPA jika status kelulusan atau status penerima beasiswa (awardee) Anda perlu diperbarui.</p>
                </div>
            </div>
        </div>
    @else
        @if($errors->any())
            <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs text-rose-700">
                Periksa kembali isian formulir tracer study yang ditandai sebelum menyimpan.
            </div>
        @endif

        <form action="{{ route('tracer.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
                <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">01</div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Identitas &amp; Status Aktivitas</h3>
                        <p class="text-[11px] text-slate-400">Pilih status aktivitas Anda setelah lulus dari FMIPA Unila.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1.5">Nama &amp; Jurusan</label>
                        <input type="text" value="{{ auth()->user()->name }} ({{ auth()->user()->major ?: 'FMIPA' }})" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-semibold cursor-not-allowed">
                    </div>

                    <div>
                        <label for="employment_status" class="block text-[11px] font-semibold text-slate-700 mb-1.5">Status Saat Ini <span class="text-rose-500">*</span></label>
                        <select id="employment_status" name="employment_status" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium @error('employment_status') border-rose-400 @enderror">
                            <option value="">Pilih status aktivitas</option>
                            @foreach($employmentStatuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('employment_status', $tracer?->employment_status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('employment_status') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="waiting_months" class="block text-[11px] font-semibold text-slate-700 mb-1.5">Waktu Tunggu Mendapat Pekerjaan / Studi (bulan)</label>
                        <input id="waiting_months" name="waiting_months" type="number" min="0" max="120" value="{{ old('waiting_months', $tracer?->waiting_months) }}" placeholder="Contoh: 2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium @error('waiting_months') border-rose-400 @enderror">
                        @error('waiting_months') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
                <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">02</div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Aktivitas Karir / Studi Saat Ini</h3>
                        <p class="text-[11px] text-slate-400">Isi perusahaan, kampus tujuan studi lanjut, atau usaha yang sedang dijalani (opsional jika sedang mencari kerja).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label for="company_name" class="block text-[11px] font-semibold text-slate-700 mb-1.5">Nama Perusahaan / Institusi / Kampus</label>
                        <input id="company_name" name="company_name" type="text" maxlength="255" value="{{ old('company_name', $tracer?->company_name) }}" placeholder="Contoh: PT Telkom Indonesia" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium @error('company_name') border-rose-400 @enderror">
                        @error('company_name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="job_title" class="block text-[11px] font-semibold text-slate-700 mb-1.5">Posisi / Jabatan / Program Studi</label>
                        <input id="job_title" name="job_title" type="text" maxlength="255" value="{{ old('job_title', $tracer?->job_title) }}" placeholder="Contoh: Junior Software Engineer" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium @error('job_title') border-rose-400 @enderror">
                        @error('job_title') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="city" class="block text-[11px] font-semibold text-slate-700 mb-1.5">Lokasi (Kota / Negara)</label>
                        <input id="city" name="city" type="text" maxlength="120" value="{{ old('city', $tracer?->city) }}" placeholder="Contoh: Jakarta Selatan, DKI Jakarta" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium @error('city') border-rose-400 @enderror">
                        @error('city') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs space-y-5">
                <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">03</div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Tautan Kontak &amp; Kesediaan Berbagi</h3>
                        <p class="text-[11px] text-slate-400">Atur tautan profil profesional dan persetujuan tampil di direktori publik alumni.</p>
                    </div>
                </div>

                <div class="text-xs">
                    <label for="contact_linkedin" class="block text-[11px] font-semibold text-slate-700 mb-1.5">URL Profil LinkedIn</label>
                    <input id="contact_linkedin" name="contact_linkedin" type="url" maxlength="255" value="{{ old('contact_linkedin', $tracer?->contact_linkedin) }}" placeholder="https://www.linkedin.com/in/username" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 font-medium @error('contact_linkedin') border-rose-400 @enderror">
                    @error('contact_linkedin') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="rounded-xl bg-slate-50 border border-slate-200/80 p-4">
                    <input type="hidden" name="ready_for_sharing" value="0">
                    <label class="inline-flex items-start gap-3 cursor-pointer">
                        <input id="ready_for_sharing" name="ready_for_sharing" type="checkbox" value="1" @checked((bool) old('ready_for_sharing', $tracer?->ready_for_sharing ?? false)) class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>
                            <span class="block text-xs font-semibold text-slate-800">Saya bersedia menjadi narasumber &amp; tampil di Direktori Alumni Publik</span>
                            <span class="block text-[11px] text-slate-500 mt-0.5">Jika dicentang, nama, jurusan, karier saat ini, dan tautan LinkedIn Anda akan ditampilkan pada direktori alumni untuk membantu mahasiswa FMIPA.</span>
                        </span>
                    </label>
                    @error('ready_for_sharing') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex justify-end">
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 shadow-xs transition-all flex items-center gap-2">
                    <span>{{ $tracer ? 'Perbarui Data Tracer' : 'Simpan Data Tracer' }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </button>
            </div>
        </form>
    @endif
</div>
@endsection
