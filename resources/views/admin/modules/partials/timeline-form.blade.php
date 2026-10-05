@php
    $timelineEvent = $timelineEvent ?? $event ?? null;
    $isEdit = ! empty($timelineEvent) && is_object($timelineEvent);
    $formKey = $isEdit ? 'edit-' . $timelineEvent->id : 'new';

    $oldFormKey = (string) old('_form');
    $useOld = $oldFormKey === $formKey || ($isEdit && $oldFormKey === 'edit-' . $timelineEvent->id);
    $val = fn (string $key, $default = '') => $useOld ? old($key, $default) : $default;

    $rawDate = $timelineEvent?->date;
    $defaultDate = $rawDate ? \Illuminate\Support\Carbon::parse($rawDate)->format('Y-m-d') : date('Y-m-d');
    $defaultTime = $timelineEvent?->time ? substr((string) $timelineEvent->time, 0, 5) : '';

    $existingTitle = $val('title', $timelineEvent?->title ?? '');
    $existingDate = $val('date', $defaultDate);
    $existingTime = $val('time', $defaultTime);
    $existingLocation = $val('location', $timelineEvent?->location ?? '');
    $existingLocationUrl = $val('location_url', $timelineEvent?->location_url ?? '');
    $existingTheme = $val('theme', $timelineEvent?->theme ?? '');
    $existingDescription = $val('description', $timelineEvent?->description ?? '');
    $existingStatus = $val('status', $timelineEvent?->status ?? 'upcoming');
    $existingIsActive = (bool) $val('is_active', $timelineEvent?->is_active ?? true);
    $existingSortOrder = $val('sort_order', $timelineEvent?->sort_order ?? 0);

    $logoPath = $timelineEvent?->logo_path;
    $existingLogo = $logoPath
        ? (preg_match('/^https?:\/\//', $logoPath) ? $logoPath : asset('storage/' . ltrim($logoPath, '/')))
        : '';

    $buttonLabel = $isEdit ? 'Perbarui kegiatan' : 'Simpan kegiatan';
    $logoId = 'timeline_logo_' . $formKey;

    $labelClass = 'mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400';
    $inputClass = 'w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500 dark:focus:border-emerald-400 dark:focus:ring-emerald-400/10';
@endphp

<form action="{{ $action ?? route('admin.timeline.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif
    <input type="hidden" name="_form" value="{{ $formKey }}">

    <div class="md:col-span-2">
        <label for="timeline_title_{{ $formKey }}" class="{{ $labelClass }}">Judul kegiatan <span class="text-rose-500">*</span></label>
        <input id="timeline_title_{{ $formKey }}" type="text" name="title" value="{{ $existingTitle }}" required maxlength="255" class="{{ $inputClass }}" placeholder="Contoh: Kemah Bakti Pramuka">
    </div>

    <div>
        <label for="timeline_date_{{ $formKey }}" class="{{ $labelClass }}">Tanggal <span class="text-rose-500">*</span></label>
        <input id="timeline_date_{{ $formKey }}" type="date" name="date" value="{{ $existingDate }}" required class="{{ $inputClass }}">
    </div>

    <div>
        <label for="timeline_time_{{ $formKey }}" class="{{ $labelClass }}">Waktu</label>
        <input id="timeline_time_{{ $formKey }}" type="time" name="time" value="{{ $existingTime }}" class="{{ $inputClass }}">
    </div>

    <div>
        <label for="timeline_location_{{ $formKey }}" class="{{ $labelClass }}">Nama lokasi <span class="text-rose-500">*</span></label>
        <input id="timeline_location_{{ $formKey }}" type="text" name="location" value="{{ $existingLocation }}" required maxlength="255" class="{{ $inputClass }}" placeholder="Contoh: SMK Negeri 1 Bangsri">
    </div>

    <div>
        <label for="timeline_location_url_{{ $formKey }}" class="{{ $labelClass }}">Link lokasi (Google Maps)</label>
        <input id="timeline_location_url_{{ $formKey }}" type="url" name="location_url" value="{{ $existingLocationUrl }}" class="{{ $inputClass }}" placeholder="https://maps.app.goo.gl/...">
    </div>

    <div class="md:col-span-2">
        <label for="timeline_theme_{{ $formKey }}" class="{{ $labelClass }}">Tema / Motto</label>
        <textarea id="timeline_theme_{{ $formKey }}" name="theme" rows="2" class="{{ $inputClass }}" placeholder="Isi tema kegiatan jika ada">{{ $existingTheme }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label for="timeline_description_{{ $formKey }}" class="{{ $labelClass }}">Deskripsi</label>
        <textarea id="timeline_description_{{ $formKey }}" name="description" rows="5" class="{{ $inputClass }}" placeholder="Deskripsi kegiatan. Tekan Enter untuk membuat paragraf baru.">{{ $existingDescription }}</textarea>
    </div>

    <div class="md:col-span-2 grid gap-4 sm:grid-cols-3">
        <div>
            <label for="timeline_status_{{ $formKey }}" class="{{ $labelClass }}">Status</label>
            <select id="timeline_status_{{ $formKey }}" name="status" class="{{ $inputClass }}">
                <option value="upcoming" @selected($existingStatus === 'upcoming')>Akan datang</option>
                <option value="ongoing" @selected($existingStatus === 'ongoing')>Berlangsung</option>
                <option value="completed" @selected($existingStatus === 'completed')>Selesai</option>
            </select>
        </div>

        <div>
            <label for="timeline_is_active_{{ $formKey }}" class="{{ $labelClass }}">Publikasi</label>
            <select id="timeline_is_active_{{ $formKey }}" name="is_active" class="{{ $inputClass }}">
                <option value="1" @selected($existingIsActive)>Tampilkan</option>
                <option value="0" @selected(! $existingIsActive)>Sembunyikan</option>
            </select>
        </div>

        <div>
            <label for="timeline_sort_order_{{ $formKey }}" class="{{ $labelClass }}">Urutan</label>
            <input id="timeline_sort_order_{{ $formKey }}" type="number" name="sort_order" min="0" value="{{ $existingSortOrder }}" class="{{ $inputClass }}">
        </div>
    </div>

    <div class="md:col-span-2">
        <span class="{{ $labelClass }}">Logo kegiatan</span>

        <div data-logo-zone data-current="{{ $existingLogo }}" class="rounded-2xl border-2 border-dashed border-slate-300 bg-white transition dark:border-slate-700 dark:bg-slate-900/50">
            <input type="file" id="{{ $logoId }}" name="logo" accept="image/png,image/jpeg,image/webp" class="sr-only" data-input>
            <input type="hidden" name="remove_logo" value="0" data-remove>

            <label for="{{ $logoId }}" data-empty class="flex cursor-pointer flex-col items-center justify-center gap-2 px-4 py-8 text-center">
                <svg class="h-9 w-9 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <p class="text-sm text-slate-600 dark:text-slate-300">Seret &amp; lepas logo di sini, atau <span class="font-semibold text-emerald-600 dark:text-emerald-400">klik untuk memilih</span></p>
                <p class="text-[11px] text-slate-500 dark:text-slate-400">PNG, JPG, atau WEBP &middot; maksimal 4 MB</p>
            </label>

            <div data-filled class="hidden">
                <div class="flex items-center gap-3 p-3">
                    <img data-preview alt="Preview logo" class="h-20 w-20 shrink-0 rounded-xl border border-slate-200 bg-white object-contain dark:border-slate-700">
                    <div class="min-w-0 flex-1">
                        <span data-badge class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Baru</span>
                        <p data-name class="mt-1 truncate text-sm font-medium text-slate-900 dark:text-white"></p>
                        <p data-meta class="text-[11px] text-slate-500 dark:text-slate-400"></p>
                    </div>
                    <div class="flex shrink-0 flex-col gap-1.5 sm:flex-row">
                        <label for="{{ $logoId }}" class="cursor-pointer rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-center text-[11px] font-semibold text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Ganti</label>
                        <button type="button" data-clear class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300">Hapus</button>
                    </div>
                </div>
            </div>

            <p data-error class="hidden px-3 pb-3 text-xs font-medium text-rose-600 dark:text-rose-400"></p>
        </div>

        @if($isEdit)
            <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">Tidak perlu unggah ulang. Jika tidak memilih file baru, logo lama tetap dipakai.</p>
        @endif
    </div>

    <div class="md:col-span-2 flex justify-end pt-2">
        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
            {{ $buttonLabel }}
        </button>
    </div>
</form>