@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')

@section('title', 'Katalog Beasiswa')

@section('content')
@php
    $authUser = auth()->user();
    $isRecommendationLocked = $authUser && ($authUser->is_awardee === true || $authUser->academic_status === 'lulus');
    $catalogAction = request()->routeIs('mahasiswa.beasiswa.katalog')
        ? route('mahasiswa.beasiswa.katalog')
        : route('beasiswa.katalog');
@endphp

<div class="w-full">
    <section class="bg-white border-b border-slate-200/80 py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="max-w-2xl mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Peluang Pendanaan Mahasiswa
                </span>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Katalog Beasiswa FMIPA</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Eksplorasi berbagai program beasiswa aktif dari instansi pemerintah, mitra industri, dan yayasan untuk mahasiswa FMIPA Unila.
                </p>
            </div>

            @if(session('status'))
                <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-xs font-medium text-blue-800">
                    {{ session('status') }}
                </div>
            @endif

            @if($isRecommendationLocked)
                <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800">
                    @if($authUser->academic_status === 'lulus')
                        Status akademik Anda saat ini <strong>Lulus</strong>. Pengajuan rekomendasi beasiswa baru tidak tersedia.
                    @else
                        Anda tercatat sebagai <strong>Awardee Aktif</strong>. Pengajuan rekomendasi beasiswa baru dikunci selama masa penerimaan beasiswa.
                    @endif
                </div>
            @endif

            <!-- Filter Bar -->
            <form id="catalog-filter-form" method="GET" action="{{ $catalogAction }}" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center;" class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                <div style="flex: 1 1 280px; min-width: 0;" class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ $filters['search'] ?? request('search') }}"
                           placeholder="Cari nama beasiswa atau mitra penyelenggara..."
                           style="width: 100%;"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-800 placeholder-slate-400">
                </div>
                <div style="flex: 0 0 180px;">
                    <select name="status" style="width: 100%;" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        <option value="">Semua Status</option>
                        <option value="open" @selected(($filters['status'] ?? request('status')) === 'open')>Dibuka</option>
                        <option value="closed" @selected(($filters['status'] ?? request('status')) === 'closed')>Ditutup</option>
                    </select>
                </div>
                <div style="flex: 0 0 auto;" class="flex gap-2">
                    <button type="submit" style="min-width: 110px;" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-colors">
                        Cari
                    </button>
                    <a id="catalog-reset-btn" href="{{ $catalogAction }}" class="{{ request('search') || request('status') ? '' : 'hidden' }} px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-xs font-semibold hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </section>

    <!-- Grid Kartu Beasiswa -->
    <section id="catalog-results" class="max-w-7xl mx-auto px-6 lg:px-12 py-12 transition-opacity duration-150">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($scholarships as $scholarship)
                @php
                    $awardeesCount = (int) ($scholarship->awardees_count ?? 0);
                    $remainingQuota = $scholarship->quota !== null
                        ? max(0, $scholarship->quota - $awardeesCount)
                        : null;
                    $isOpen = $scholarship->status === 'open';
                @endphp

                <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex flex-col justify-between hover:border-blue-300 transition-all">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            @if($isOpen)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                    Pendaftaran Dibuka
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200/70">
                                    Pendaftaran Ditutup
                                </span>
                            @endif
                            <span class="text-[11px] text-slate-400 font-medium">Batas: {{ $scholarship->close_date->format('d M Y') }}</span>
                        </div>

                        <h3 class="font-bold text-slate-900 text-base mb-1 leading-snug">{{ $scholarship->name }}</h3>
                        <p class="text-[11px] font-semibold text-blue-600 mb-2">{{ $scholarship->provider }}</p>

                        <p class="text-xs text-slate-500 leading-relaxed mb-4">
                            {{ $scholarship->description ? \Illuminate\Support\Str::limit($scholarship->description, 140) : 'Informasi detail program beasiswa dapat dilihat pada halaman detail.' }}
                        </p>

                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs space-y-2 mb-6">
                            <div class="flex justify-between text-[11px]">
                                <span class="text-slate-400">Minimal IPK:</span>
                                <span class="font-bold text-slate-700">{{ number_format($scholarship->min_gpa, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-[11px]">
                                <span class="text-slate-400">Sisa Kuota:</span>
                                @if($scholarship->quota === null)
                                    <span class="font-bold text-slate-700">Tanpa batas</span>
                                @else
                                    <span class="font-bold text-slate-700">{{ $remainingQuota }} / {{ $scholarship->quota }}</span>
                                @endif
                            </div>
                            <div class="flex justify-between text-[11px]">
                                <span class="text-slate-400">Periode:</span>
                                <span class="font-medium text-slate-700">{{ $scholarship->open_date->format('d M Y') }} – {{ $scholarship->close_date->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                        <a href="{{ route('beasiswa.show', $scholarship) }}" class="text-xs font-semibold text-slate-600 hover:text-blue-600">
                            Detail Beasiswa
                        </a>

                        <div class="flex items-center gap-2">
                            @if($scholarship->registration_url)
                                <a href="{{ $scholarship->registration_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 px-3 py-2 rounded-xl border border-blue-200 bg-blue-50 text-blue-700 text-xs font-semibold hover:bg-blue-100 transition-colors">
                                    <span>Portal</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6L10 14M5 7H4a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1v-1"/></svg>
                                </a>
                            @endif

                            @if(! $isOpen)
                                <button type="button" disabled class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed">
                                    Ditutup
                                </button>
                            @elseif($isRecommendationLocked)
                                <span class="px-3 py-2 rounded-xl bg-slate-100 text-slate-500 text-[11px] font-semibold" title="Pengajuan rekomendasi terkunci untuk status akun Anda">
                                    Terkunci
                                </span>
                            @elseif(auth()->check() && auth()->user()->role === 'mahasiswa')
                                <a href="{{ route('mahasiswa.pendaftaran.create', ['scholarship_id' => $scholarship->id]) }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors shadow-xs">
                                    <span>Ajukan Rekomendasi</span>
                                </a>
                            @elseif(! auth()->check())
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors shadow-xs">
                                    <span>Masuk untuk Daftar</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3 bg-white border border-slate-200/90 rounded-2xl px-6 py-16 text-center shadow-xs">
                    <p class="text-sm font-semibold text-slate-700">Belum ada program beasiswa yang sesuai</p>
                    <p class="text-xs text-slate-400 mt-1">Coba ubah kata kunci pencarian atau filter status pendaftaran.</p>
                </div>
            @endforelse
        </div>

        @if($scholarships->hasPages())
            <div class="mt-8">
                {{ $scholarships->links() }}
            </div>
        @endif
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('catalog-filter-form');
        const results = document.getElementById('catalog-results');
        const resetBtn = document.getElementById('catalog-reset-btn');
        if (!form || !results) return;

        const searchInput = form.querySelector('input[name="search"]');
        const statusSelect = form.querySelector('select[name="status"]');
        let timer;
        let controller;

        async function fetchCatalog(url) {
            if (controller) controller.abort();
            controller = new AbortController();
            results.style.opacity = '0.5';

            try {
                const res = await fetch(url, {
                    signal: controller.signal,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await res.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const nextResults = doc.getElementById('catalog-results');

                if (nextResults) {
                    results.innerHTML = nextResults.innerHTML;
                    window.history.replaceState({}, '', url);
                }
            } catch (err) {
                if (err.name !== 'AbortError') console.error(err);
            } finally {
                results.style.opacity = '1';
            }
        }

        function triggerLiveFilter() {
            const params = new URLSearchParams();
            const searchVal = searchInput ? searchInput.value.trim() : '';
            const statusVal = statusSelect ? statusSelect.value : '';

            if (searchVal) params.set('search', searchVal);
            if (statusVal) params.set('status', statusVal);

            if (resetBtn) {
                resetBtn.classList.toggle('hidden', !searchVal && !statusVal);
            }

            const queryString = params.toString();
            const url = form.action + (queryString ? '?' + queryString : '');
            fetchCatalog(url);
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearTimeout(timer);
            triggerLiveFilter();
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(triggerLiveFilter, 300);
            });
        }

        if (statusSelect) {
            statusSelect.addEventListener('change', triggerLiveFilter);
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (searchInput) searchInput.value = '';
                if (statusSelect) statusSelect.value = '';
                triggerLiveFilter();
            });
        }

        results.addEventListener('click', function (e) {
            const link = e.target.closest('nav[role="navigation"] a, .pagination a');
            if (link && link.href) {
                e.preventDefault();
                fetchCatalog(link.href);
            }
        });
    });
</script>
@endsection