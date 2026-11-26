@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Administrasi akademik</p>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight mt-1">Manajemen Pengguna</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola akun Dosen PA, pemetaan mahasiswa bimbingan, serta status akademik dan aktivasi akun mahasiswa.</p>
        </div>
        <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Dosen PA
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

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mahasiswa Aktif</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($activeStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Tersedia untuk pemetaan PA</p>
        </div>
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sudah Dipetakan</p>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($assignedStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Memiliki Dosen PA</p>
        </div>
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Belum Dipetakan</p>
            <p class="text-2xl font-extrabold {{ $unassignedStudentCount ? 'text-amber-500' : 'text-slate-800' }} mt-1">{{ number_format($unassignedStudentCount, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Perlu ditetapkan pembimbingnya</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200">
        <a href="{{ route('users.index', ['tab' => 'dosen_pa']) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold border-b-2 transition-colors {{ $activeTab === 'dosen_pa' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            Dosen PA
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'dosen_pa' ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-600' }}">{{ number_format($totalLecturerCount, 0, ',', '.') }}</span>
        </a>
        <a href="{{ route('users.index', ['tab' => 'mahasiswa']) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold border-b-2 transition-colors {{ $activeTab === 'mahasiswa' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            Mahasiswa
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'mahasiswa' ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-600' }}">{{ number_format($totalStudentCount, 0, ',', '.') }}</span>
        </a>
    </div>

    @if($activeTab === 'dosen_pa')
        <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-800">Akun Dosen Pembimbing Akademik</h2>
                <p class="text-xs text-slate-400 mt-0.5">Atur informasi akun, status aktivasi, dan mahasiswa bimbingan setiap dosen.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5">Dosen PA</th>
                            <th class="px-5 py-3.5">Jurusan</th>
                            <th class="px-5 py-3.5">Telepon</th>
                            <th class="px-5 py-3.5">Mahasiswa Bimbingan</th>
                            <th class="px-5 py-3.5">Status Akun</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($lecturers as $lecturer)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-900 text-[13px]">{{ $lecturer->name }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $lecturer->nim_nip }} · {{ $lecturer->email }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-semibold">{{ $lecturer->major }}</span>
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $lecturer->phone ?: '-' }}</td>
                                <td class="px-5 py-4">
                                    <span class="font-bold text-slate-800">{{ number_format($lecturer->active_advisees_count, 0, ',', '.') }}</span>
                                    <span class="text-slate-400">mahasiswa aktif</span>
                                </td>
                                <td class="px-5 py-4">
                                    @if($lecturer->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 border border-slate-200 text-[10px] font-semibold">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('users.advisees', $lecturer) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-blue-200 bg-blue-50 text-blue-700 font-semibold text-[11px] hover:bg-blue-100">
                                            Atur Bimbingan
                                        </a>
                                        <a href="{{ route('users.edit', $lecturer) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-[11px] hover:bg-slate-50">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('users.toggle-active', $lecturer) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg border text-[11px] font-semibold transition-colors {{ $lecturer->is_active ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100' : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                                {{ $lecturer->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center">
                                    <p class="text-sm font-semibold text-slate-700">Belum ada akun Dosen PA</p>
                                    <p class="text-xs text-slate-400 mt-1">Tambahkan akun dosen untuk mulai memetakan mahasiswa bimbingan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($lecturers->hasPages())
                <div class="px-5 py-4 border-t border-slate-100">{{ $lecturers->links() }}</div>
            @endif
        </section>
    @else
        <section class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 space-y-4">
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Daftar Mahasiswa</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Cari mahasiswa, ubah status akademik (aktif/cuti/lulus), atau kelola aktivasi akun.</p>
                </div>
                <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    <input type="hidden" name="tab" value="mahasiswa">
                    <div class="lg:col-span-2">
                        <label for="search" class="sr-only">Cari nama atau NIM</label>
                        <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama atau NIM mahasiswa..." class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="major" class="sr-only">Jurusan</label>
                        <select id="major" name="major" class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Jurusan</option>
                            @foreach($majors as $major)
                                <option value="{{ $major }}" @selected(($filters['major'] ?? '') === $major)>{{ $major }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="academic_status" class="sr-only">Status Akademik</label>
                        <select id="academic_status" name="academic_status" class="w-full rounded-xl border-slate-200 text-xs focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Status Akademik</option>
                            @foreach($academicStatuses as $status)
                                <option value="{{ $status }}" @selected(($filters['academic_status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">Filter</button>
                        <a href="{{ route('users.index', ['tab' => 'mahasiswa']) }}" class="px-3 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Reset</a>
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-400 font-semibold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5">Mahasiswa</th>
                            <th class="px-5 py-3.5">Jurusan & Dosen PA</th>
                            <th class="px-5 py-3.5">Telepon</th>
                            <th class="px-5 py-3.5">Status Akademik</th>
                            <th class="px-5 py-3.5">Status Akun</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($students as $student)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p class="font-bold text-slate-900 text-[13px]">{{ $student->name }}</p>
                                        @if($student->is_awardee)
                                            <span class="inline-flex px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-semibold">Awardee</span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $student->nim_nip ?: 'NIM belum diisi' }} · {{ $student->email }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="font-medium text-slate-800">{{ $student->major ?: '-' }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">PA: {{ $student->academicAdvisor?->name ?? 'Belum dipetakan' }}</p>
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $student->phone ?: '-' }}</td>
                                <td class="px-5 py-4">
                                    <form method="POST" action="{{ route('users.academic-status.update', $student) }}" class="flex items-center gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <select name="academic_status" aria-label="Status akademik {{ $student->name }}" class="rounded-lg border-slate-200 text-[11px] py-1 px-2 focus:border-blue-500 focus:ring-blue-500">
                                            @foreach($academicStatuses as $status)
                                                <option value="{{ $status }}" @selected($student->academic_status === $status)>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-slate-800 text-white text-[11px] font-semibold hover:bg-slate-700">Simpan</button>
                                    </form>
                                </td>
                                <td class="px-5 py-4">
                                    @if($student->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 border border-slate-200 text-[10px] font-semibold">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form method="POST" action="{{ route('users.toggle-active', $student) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg border text-[11px] font-semibold transition-colors {{ $student->is_active ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100' : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                            {{ $student->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center">
                                    <p class="text-sm font-semibold text-slate-700">Tidak ada mahasiswa ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-1">Ubah kata kunci pencarian atau filter jurusan dan status akademik.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($students->hasPages())
                <div class="px-5 py-4 border-t border-slate-100">{{ $students->links() }}</div>
            @endif
        </section>
    @endif
</div>
@endsection
