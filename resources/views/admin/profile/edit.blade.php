@extends('admin.layouts.app')

@section('title', 'Edit Profil Admin')
@section('page-title', 'Profil Admin')
@section('page-description', 'Kelola data profil admin, NTA, kontak, dan foto profil.')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/30 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-950 sm:p-5">
                <div class="flex flex-col items-center text-center">
                    <div class="relative">
                        <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-full object-cover border-4 border-slate-200 shadow-sm sm:h-32 sm:w-32 dark:border-slate-800">
                    </div>

                    <div class="mt-4 w-full">
                        <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Foto Profil</label>
                        <input type="file" name="photo" accept="image/*" class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-900 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-950 sm:p-5">
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">NTA</label>
                        <input type="text" name="nta" value="{{ old('nta', $user->nta ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="NTA-2026-001">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="0812...">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Super Admin">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Bio / Deskripsi</label>
                        <textarea name="bio" rows="4" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Tuliskan bio singkat admin...">{{ old('bio', $user->bio ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                        Simpan Profil
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
