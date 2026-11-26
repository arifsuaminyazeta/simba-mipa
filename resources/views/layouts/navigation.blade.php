@php
    $navUser = auth()->user();$navItems = collect();

    if ($navUser?->role === 'admin') {
        $pendingAdmin = \App\Models\ScholarshipApplication::whereIn('status', ['verified_by_dosen', 'loa_submitted'])->count();$ewsAdmin = \App\Models\SemesterEvaluation::whereNotIn('ews_status', ['aman'])->count();

        if ($pendingAdmin > 0) {$navItems->push([
                'title' => $pendingAdmin.' berkas menunggu verifikasi Admin',
                'desc' => 'Tinjau pengajuan rekomendasi dan bukti LoA.',
                'url' => route('verifikasi.akhir'),
                'type' => 'blue',
            ]);
        }

        if ($ewsAdmin > 0) {$navItems->push([
                'title' => $ewsAdmin.' evaluasi KHS berstatus peringatan EWS',
                'desc' => 'Perlu pemantauan akademik lebih lanjut.',
                'url' => route('akademik.evaluasi'),
                'type' => 'rose',
            ]);
        }
    } elseif ($navUser?->role === 'dosen_pa') {
        $pendingDosen = \App\Models\ScholarshipApplication::where('status', 'pending')
            ->whereHas('user', fn ($q) => $q->where('dosen_pa_id',$navUser->id))
            ->count();
        $ewsDosen = \App\Models\SemesterEvaluation::whereNotIn('ews_status', ['aman'])
            ->whereHas('user', fn ($q) => $q->where('dosen_pa_id',$navUser->id))
            ->count();

        if ($pendingDosen > 0) {$navItems->push([
                'title' => $pendingDosen.' pengajuan menunggu verifikasi PA',
                'desc' => 'Periksa kelayakan berkas mahasiswa bimbingan.',
                'url' => route('verifikasi.awal'),
                'type' => 'blue',
            ]);
        }

        if ($ewsDosen > 0) {$navItems->push([
                'title' => $ewsDosen.' mahasiswa bimbingan berstatus EWS',
                'desc' => 'Cek hasil KHS dan catatan evaluasi semester.',
                'url' => route('akademik.monitoring'),
                'type' => 'rose',
            ]);
        }
    } elseif ($navUser?->role === 'mahasiswa') {
        $recentAnnouncements = \App\Models\Announcement::where('is_active', true)
            ->whereIn('target_role', ['public', 'all', 'mahasiswa'])
            ->latest()
            ->take(3)
            ->get();

        foreach ($recentAnnouncements as $item) {$navItems->push([
                'title' => $item->title,
                'desc' => \Illuminate\Support\Str::limit($item->content, 70),
                'url' => route('dashboard.mahasiswa').'#pengumuman',
                'type' => 'blue',
            ]);
        }
    }
@endphp

<header class="bg-white border-b border-slate-200/90 h-16 flex items-center justify-between px-6 lg:px-8 sticky top-0 z-30">
    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        <span>Portal Akademik</span>
        <span class="text-slate-300">/</span>
        <span class="text-slate-800 font-semibold">@yield('title', 'Dashboard')</span>
    </div>

    <div class="relative" id="notif-wrapper">
        <button type="button" id="notif-button" class="relative p-2 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-slate-50 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if($navItems->isNotEmpty())
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-blue-600 ring-2 ring-white"></span>
            @endif
        </button>

        <div id="notif-dropdown" style="top: 100%; right: 0; width: 320px; margin-top: 8px;" class="hidden absolute bg-white border border-slate-200 rounded-2xl shadow-lg overflow-hidden z-50">
            <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                <p class="text-xs font-bold text-slate-800">Notifikasi</p>
                <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $navItems->count() }} info</span>
            </div>
            <div style="max-height: 288px;" class="divide-y divide-slate-100 overflow-y-auto">
                @forelse($navItems as $notif)
                    <a href="{{ $notif['url'] }}" class="block px-4 py-3 hover:bg-slate-50 transition-colors">
                        <p class="text-xs font-semibold {{ $notif['type'] === 'rose' ? 'text-rose-600' : 'text-slate-800' }}">{{ $notif['title'] }}</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $notif['desc'] }}</p>
                    </a>
                @empty
                    <div class="px-4 py-6 text-center text-xs text-slate-400">
                        Belum ada notifikasi baru.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('notif-wrapper');
        const button = document.getElementById('notif-button');
        const dropdown = document.getElementById('notif-dropdown');

        if (!wrapper || !button || !dropdown) return;

        button.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>