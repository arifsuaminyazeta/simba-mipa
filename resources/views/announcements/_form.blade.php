<div>
    <label for="title" class="block text-xs font-semibold text-slate-700 mb-1.5">Judul pengumuman <span class="text-rose-500">*</span></label>
    <input id="title" name="title" type="text" required maxlength="255" value="{{ old('title', $announcement?->title) }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-rose-400 @enderror" placeholder="Contoh: Jadwal pengumpulan berkas beasiswa">
    @error('title') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label for="target_role" class="block text-xs font-semibold text-slate-700 mb-1.5">Target audiens <span class="text-rose-500">*</span></label>
    @php
        $selectedTarget = old('target_role', $announcement?->target_role ?? 'public');
    @endphp
    <select id="target_role" name="target_role" required class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 @error('target_role') border-rose-400 @enderror">
        <option value="public" @selected($selectedTarget === 'public')>Publik (Semua Pengunjung)</option>
        <option value="all" @selected($selectedTarget === 'all')>Semua Pengguna Login</option>
        <option value="mahasiswa" @selected($selectedTarget === 'mahasiswa')>Khusus Mahasiswa</option>
        <option value="dosen_pa" @selected($selectedTarget === 'dosen_pa')>Khusus Dosen PA</option>
    </select>
    @error('target_role') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label for="content" class="block text-xs font-semibold text-slate-700 mb-1.5">Isi pengumuman <span class="text-rose-500">*</span></label>
    <textarea id="content" name="content" rows="9" required maxlength="20000" class="w-full rounded-xl border-slate-200 text-sm leading-relaxed focus:border-blue-500 focus:ring-blue-500 @error('content') border-rose-400 @enderror" placeholder="Tuliskan detail pengumuman dengan jelas...">{{ old('content', $announcement?->content) }}</textarea>
    @error('content') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
</div>

<label for="is_active" class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 bg-slate-50/70 cursor-pointer">
    <input type="hidden" name="is_active" value="0">
    <input id="is_active" name="is_active" type="checkbox" value="1" @checked((bool) old('is_active', $announcement?->is_active ?? true)) class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
    <span>
        <span class="block text-xs font-semibold text-slate-800">Publikasikan pengumuman (Aktif)</span>
        <span class="block text-[11px] text-slate-500 mt-0.5">Jika tidak dicentang, pengumuman disimpan sebagai nonaktif/draf dan tidak ditampilkan kepada audiens.</span>
    </span>
</label>

<div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 pt-2 border-t border-slate-100">
    <a href="{{ route('announcements.manage') }}" class="inline-flex justify-center px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Batal</a>
    <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ $announcement ? 'Simpan Perubahan' : 'Terbitkan Pengumuman' }}
    </button>
</div>
