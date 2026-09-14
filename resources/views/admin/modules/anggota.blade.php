@extends('admin.layouts.app')

@section('title', $title)
@section('page-heading', $title)
@section('page-description', $description)

@section('content')
<div class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Modul Admin</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
        </div>

        @if(! empty($publicRoute) && ! empty($publicLabel))
            <a href="{{ $publicRoute }}" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                {{ $publicLabel }}
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="flex items-start justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <p>{{ session('success') }}</p>
            <button type="button" onclick="this.closest('div').remove()" class="text-lg leading-none opacity-70 transition hover:opacity-100" aria-label="Tutup notifikasi">&times;</button>
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Total Dewan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['aktif'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Saat ini</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Non-Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['nonaktif'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Dihentikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Jabatan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['jabatan'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Terdata</p>
        </div>
    </div>

    <div class="flex items-center justify-between gap-3">
        <div></div>
        @if(($anggota ?? collect())->isNotEmpty())
            <form action="{{ route('admin.anggota.delete-all') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua anggota dewan? Tindakan ini tidak bisa dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-100">
                    Hapus Semua
                </button>
            </form>
        @endif
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-xs uppercase tracking-[0.12em] text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($anggota ?? [] as $item)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $item->nama }}</td>
                            <td class="px-4 py-3">{{ $item->kelas_asal ?: '-' }}</td>
                            <td class="px-4 py-3">{{ $item->jabatan ?: '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $item->status ?: ($item->is_active ? 'Aktif' : 'Non-Aktif') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="{{ route('admin.anggota.toggle', $item) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 hover:bg-amber-100">
                                            {{ $item->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-anggota-{{ $item->id }}').classList.toggle('hidden')" class="rounded-lg border border-indigo-200 bg-indigo-50 px-2.5 py-1.5 text-[10px] font-semibold text-indigo-700 hover:bg-indigo-100">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.anggota.delete', $item) }}" method="POST" onsubmit="return confirm('Hapus anggota dewan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700 hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-anggota-{{ $item->id }}" class="hidden bg-slate-50">
                            <td colspan="5" class="px-4 py-4">
                                <form action="{{ route('admin.anggota.update', $item) }}" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    @csrf
                                    @method('PUT')

                                    <input type="text" name="nama" value="{{ old('nama', $item->nama) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Nama lengkap" required>
                                    <input type="text" name="kelas_asal" value="{{ old('kelas_asal', $item->kelas_asal) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Kelas">
                                    <input type="text" name="jabatan" value="{{ old('jabatan', $item->jabatan) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Jabatan">
                                    <input type="text" name="sangga" value="{{ old('sangga', $item->sangga) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Sangga">
                                    <input type="text" name="sub_sangga" value="{{ old('sub_sangga', $item->sub_sangga) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Sub Sangga">
                                    <select name="ambalan" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                        <option value="" {{ old('ambalan', $item->ambalan) === '' ? 'selected' : '' }}>Pilih Ambalan</option>
                                        <option value="PA" {{ old('ambalan', $item->ambalan) === 'PA' ? 'selected' : '' }}>PA</option>
                                        <option value="PI" {{ old('ambalan', $item->ambalan) === 'PI' ? 'selected' : '' }}>PI</option>
                                    </select>
                                    <select name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                        <option value="Aktif" {{ old('status', $item->status) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Non-Aktif" {{ old('status', $item->status) === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Urutan">
                                    <input type="file" name="photo" accept="image/*" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2">
                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                                        Aktif dipublikasikan
                                    </label>
                                    <div class="flex justify-end gap-2 md:col-span-2">
                                        <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data anggota dewan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Formulir Anggota Dewan</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">Siap diproses</span>
        </div>

        <form action="{{ route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            @csrf

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Nama lengkap</span>
                <input type="text" name="nama" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Masukkan nama anggota dewan" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Kelas</span>
                <input type="text" name="kelas_asal" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Contoh: XI">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Jabatan</span>
                <input type="text" name="jabatan" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Ketua Regu / Sekretaris">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Sangga</span>
                <input type="text" name="sangga" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Sangga Merah">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Sub Sangga</span>
                <input type="text" name="sub_sangga" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Sub Sangga 1">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Ambalan</span>
                <select name="ambalan" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500">
                    <option value="">Pilih</option>
                    <option value="PA">PA</option>
                    <option value="PI">PI</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</span>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500">
                    <option value="Aktif">Aktif</option>
                    <option value="Non-Aktif">Non-Aktif</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500">
            </label>

            <div class="md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Foto anggota dewan</span>
                <input type="file" name="photo" accept="image/*" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500">
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    Simpan Anggota Dewan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
