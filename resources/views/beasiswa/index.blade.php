@extends('layouts.app')

@section('title', 'Kelola Beasiswa')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Beasiswa</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi, kuota, dan periode program beasiswa.</p>
        </div>

        <button type="button" onclick="document.getElementById('scholarship-create-modal').showModal()"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm">
            <span>+</span> Tambah Beasiswa
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <dialog id="scholarship-create-modal" class="m-auto w-[calc(100%-2rem)] max-w-3xl rounded-2xl border border-slate-200 bg-white p-0 text-left shadow-2xl">
        <div class="dialog-scroll">
            <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600">Program baru</p>
                    <h3 class="mt-1 text-base font-bold text-slate-800">Tambah Beasiswa</h3>
                </div>
                <button type="button" onclick="document.getElementById('scholarship-create-modal').close()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup">✕</button>
            </div>
            <form action="{{ route('beasiswa.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">Nama Beasiswa <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('form_mode') === 'create' ? old('name') : '' }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">Instansi Penyedia <span class="text-rose-500">*</span></label>
                        <input type="text" name="provider" value="{{ old('form_mode') === 'create' ? old('provider') : '' }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">Minimal IPK <span class="text-rose-500">*</span></label>
                        <input type="number" name="min_gpa" value="{{ old('form_mode') === 'create' ? old('min_gpa') : '' }}" step="0.01" min="0" max="4" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">Kuota Penerima</label>
                        <input type="number" name="quota" value="{{ old('form_mode') === 'create' ? old('quota') : '' }}" min="1" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">Tanggal Pembukaan <span class="text-rose-500">*</span></label>
                        <input type="date" name="open_date" value="{{ old('form_mode') === 'create' ? old('open_date') : '' }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">Tanggal Penutupan <span class="text-rose-500">*</span></label>
                        <input type="date" name="close_date" value="{{ old('form_mode') === 'create' ? old('close_date') : '' }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">URL Pendaftaran <span class="text-rose-500">*</span></label>
                        <input type="url" name="registration_url" value="{{ old('form_mode') === 'create' ? old('registration_url') : '' }}" placeholder="https://" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('form_mode') === 'create' ? old('description') : '' }}</textarea>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-700">Status</label>
                        <select name="status" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="open" @selected(old('form_mode') !== 'create' || old('status', 'open') === 'open')>Dibuka</option>
                            <option value="closed" @selected(old('form_mode') === 'create' && old('status') === 'closed')>Ditutup</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="form_mode" value="create">
                @if($errors->any() && old('form_mode') === 'create')
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs text-rose-700">Periksa kembali isian beasiswa yang ditandai belum valid.</div>
                @endif
                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <button type="button" onclick="document.getElementById('scholarship-create-modal').close()" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-semibold text-white hover:bg-blue-700">Simpan Beasiswa</button>
                </div>
            </form>
        </div>
    </dialog>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Beasiswa</p>
            <h2 class="text-3xl font-bold text-indigo-600 mt-2">{{ $total ?? 0 }}</h2>
            <p class="text-xs text-indigo-600 font-medium mt-2">Seluruh program terdaftar</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Beasiswa Aktif</p>
            <h2 class="text-3xl font-bold text-emerald-600 mt-2">{{ $active ?? 0 }}</h2>
            <p class="text-xs text-emerald-600 font-medium mt-2">Program sedang dibuka</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Pendaftar</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $applications ?? 0 }}</h2>
            <p class="text-xs text-blue-600 font-medium mt-2">Seluruh pengajuan mahasiswa</p>
        </div>

    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5">

        <form action="{{ route('beasiswa.index') }}" method="GET"
              class="flex flex-col md:flex-row gap-3 mb-5">

            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama atau penyedia beasiswa..."
                   class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">

            <select name="status"
                    class="border border-slate-200 rounded-xl px-4 py-3 text-sm">
                <option value="">Semua Status</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Dibuka</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
            </select>

            <button class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-xs">
                Filter
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('beasiswa.index') }}"
                   class="inline-flex items-center justify-center px-4 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-50">
                    Reset
                </a>
            @endif

        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-xs text-slate-500 uppercase border-b border-slate-200">
                        <th class="py-4 px-3">No</th>
                        <th class="py-4 px-3">Nama Beasiswa</th>
                        <th class="py-4 px-3">Penyedia</th>
                        <th class="py-4 px-3">Minimal IPK</th>
                        <th class="py-4 px-3">Sisa Kuota</th>
                        <th class="py-4 px-3">Periode</th>
                        <th class="py-4 px-3">Status</th>
                        <th class="py-4 px-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($scholarships as $item)
                    @php
                        $awardeesCount = (int) ($item->awardees_count ?? 0);
                        $dynamicRemaining = $item->quota !== null ? max(0, $item->quota - $awardeesCount) : null;
                    @endphp
                    <tr class="hover:bg-slate-50">

                        <td class="py-4 px-3 text-slate-500">
                            {{ $scholarships->firstItem() + $loop->index }}
                        </td>

                        <td class="py-4 px-3">
                            <p class="font-semibold text-slate-800">{{ $item->name }}</p>
                            @if($item->registration_url)
                                <a href="{{ $item->registration_url }}" target="_blank" rel="noopener noreferrer"
                                   class="text-xs text-blue-600 hover:underline">
                                    Portal pendaftaran ↗
                                </a>
                            @endif
                        </td>

                        <td class="py-4 px-3 text-slate-600">
                            {{ $item->provider }}
                        </td>

                        <td class="py-4 px-3">
                            {{ number_format($item->min_gpa, 2) }}
                        </td>

                        <td class="py-4 px-3">
                            @if($item->quota === null)
                                <span class="font-semibold text-slate-700">Tanpa batas</span>
                            @else
                                <span class="font-semibold text-slate-800">{{ $dynamicRemaining }}</span>
                                <span class="text-slate-400">/ {{ $item->quota }}</span>
                            @endif
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->applications_count ?? 0 }} pendaftar</p>
                        </td>

                        <td class="py-4 px-3 text-xs text-slate-500">
                            {{ $item->open_date->format('d/m/Y') }}
                            <br>
                            sampai {{ $item->close_date->format('d/m/Y') }}
                        </td>

                        <td class="py-4 px-3">
                            @if($item->status == 'open')
                                <span class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                                    Dibuka
                                </span>
                            @else
                                <span class="px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-xs font-semibold">
                                    Ditutup
                                </span>
                            @endif
                        </td>

                        <td class="py-4 px-3">
                            <div class="flex items-center justify-center gap-2">

                                <button type="button" onclick="document.getElementById('scholarship-detail-modal-{{ $item->id }}').showModal()"
                                   class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">
                                    Detail
                                </button>

                                <button type="button" onclick="document.getElementById('scholarship-edit-modal-{{ $item->id }}').showModal()"
                                   class="px-3 py-2 bg-amber-50 text-amber-600 rounded-lg text-xs font-semibold">
                                    Edit
                                </button>

                                <form action="{{ route('beasiswa.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus beasiswa ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs font-semibold">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    <dialog id="scholarship-detail-modal-{{ $item->id }}" class="m-auto w-[calc(100%-2rem)] max-w-lg rounded-2xl border border-slate-200 bg-white p-0 text-left shadow-2xl">
                        <div class="dialog-scroll p-6">
                            <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-slate-100 bg-white" style="min-height:72px;padding:14px 24px;">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-blue-600">{{ $item->provider }}</p>
                                    <h3 class="mt-1 text-lg font-bold text-slate-800">{{ $item->name }}</h3>
                                </div>
                                <button type="button" onclick="document.getElementById('scholarship-detail-modal-{{ $item->id }}').close()" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100">✕</button>
                            </div>
                            <div class="mt-5 grid grid-cols-2 gap-3 text-xs">
                                <div class="rounded-xl bg-slate-50 p-3"><p class="text-slate-400">Minimal IPK</p><p class="mt-1 font-bold text-slate-800">{{ number_format($item->min_gpa, 2) }}</p></div>
                                <div class="rounded-xl bg-slate-50 p-3"><p class="text-slate-400">Kuota</p><p class="mt-1 font-bold text-slate-800">{{ $item->remaining_quota }} / {{ $item->quota ?? 'Tanpa batas' }}</p></div>
                                <div class="col-span-2 rounded-xl bg-slate-50 p-3"><p class="text-slate-400">Periode</p><p class="mt-1 font-semibold text-slate-700">{{ $item->open_date->format('d/m/Y') }} - {{ $item->close_date->format('d/m/Y') }}</p></div>
                            </div>
                            @if($item->description)<p class="mt-4 text-xs leading-relaxed text-slate-600">{{ $item->description }}</p>@endif
                            <div class="mt-5 flex justify-end border-t border-slate-100 bg-white py-4">
                                <button type="button" onclick="document.getElementById('scholarship-detail-modal-{{ $item->id }}').close()" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600">Tutup</button>
                            </div>
                        </div>
                    </dialog>

                    <dialog id="scholarship-edit-modal-{{ $item->id }}" class="admin-modal m-auto overflow-hidden rounded-2xl bg-white p-0 text-left shadow-2xl">
                        <div class="dialog-scroll">
                            <div class="admin-modal-header sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-amber-600">Perbarui data</p>
                                    <h3 class="mt-0.5 text-base font-bold text-slate-800">Edit Beasiswa</h3>
                                </div>
                                <button type="button" onclick="document.getElementById('scholarship-edit-modal-{{ $item->id }}').close()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup">✕</button>
                            </div>
                            <form action="{{ route('beasiswa.update', $item) }}" method="POST" class="admin-modal-form" style="padding: 0;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="form_mode" value="edit-{{ $item->id }}">
                                <div class="grid grid-cols-1 gap-3 md:grid-cols-2" style="box-sizing: border-box; width: 100%; padding: 20px 24px 12px;">
                                    <div class="md:col-span-2"><label class="mb-1 block text-xs font-semibold text-slate-700">Nama Beasiswa <span class="text-rose-500">*</span></label><input type="text" name="name" value="{{ old('form_mode') === 'edit-'.$item->id ? old('name') : $item->name }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                    <div class="md:col-span-2"><label class="mb-1 block text-xs font-semibold text-slate-700">Instansi Penyedia <span class="text-rose-500">*</span></label><input type="text" name="provider" value="{{ old('form_mode') === 'edit-'.$item->id ? old('provider') : $item->provider }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                    <div><label class="mb-1 block text-xs font-semibold text-slate-700">Minimal IPK <span class="text-rose-500">*</span></label><input type="number" name="min_gpa" value="{{ old('form_mode') === 'edit-'.$item->id ? old('min_gpa') : $item->min_gpa }}" step="0.01" min="0" max="4" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                    <div><label class="mb-1 block text-xs font-semibold text-slate-700">Kuota</label><input type="number" name="quota" value="{{ old('form_mode') === 'edit-'.$item->id ? old('quota') : $item->quota }}" min="1" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                    <div><label class="mb-1 block text-xs font-semibold text-slate-700">Tanggal Pembukaan <span class="text-rose-500">*</span></label><input type="date" name="open_date" value="{{ old('form_mode') === 'edit-'.$item->id ? old('open_date') : $item->open_date->format('Y-m-d') }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                    <div><label class="mb-1 block text-xs font-semibold text-slate-700">Tanggal Penutupan <span class="text-rose-500">*</span></label><input type="date" name="close_date" value="{{ old('form_mode') === 'edit-'.$item->id ? old('close_date') : $item->close_date->format('Y-m-d') }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                    <div class="md:col-span-2"><label class="mb-1 block text-xs font-semibold text-slate-700">URL Pendaftaran <span class="text-rose-500">*</span></label><input type="url" name="registration_url" value="{{ old('form_mode') === 'edit-'.$item->id ? old('registration_url') : $item->registration_url }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"></div>
                                    <div class="md:col-span-2"><label class="mb-1 block text-xs font-semibold text-slate-700">Deskripsi</label><textarea name="description" rows="3" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('form_mode') === 'edit-'.$item->id ? old('description') : $item->description }}</textarea></div>
                                    <div><label class="mb-1 block text-xs font-semibold text-slate-700">Status</label><select name="status" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"><option value="open" @selected((old('form_mode') === 'edit-'.$item->id ? old('status') : $item->status) === 'open')>Dibuka</option><option value="closed" @selected((old('form_mode') === 'edit-'.$item->id ? old('status') : $item->status) === 'closed')>Ditutup</option></select></div>
                                </div>
                                <div class="admin-modal-footer flex flex-col-reverse gap-2 sm:flex-row sm:justify-end" style="margin: 0; padding: 14px 24px 16px;">
                                    <button type="button" onclick="document.getElementById('scholarship-edit-modal-{{ $item->id }}').close()" class="rounded-xl border border-slate-200 px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-semibold text-white hover:bg-blue-700">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-12 text-slate-400">
                            Belum ada data beasiswa.
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $scholarships->links() }}
        </div>

    </div>

</div>
@endsection
