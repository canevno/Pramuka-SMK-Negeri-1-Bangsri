@php
    use Illuminate\Support\Str;
@endphp

@extends('admin.layouts.app')

@section('title', 'Pengelola API')
@section('page-title', 'Pengelola API')
@section('page-description', 'Pantau perangkat yang pernah mengunjungi website dan blokir perangkat yang mencurigakan.')

@section('content')
<div class="space-y-3 sm:space-y-4">
    <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-slate-400 sm:text-[11px]">Modul Admin</p>
            <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-zinc-900 dark:text-slate-100 sm:text-2xl">Pengelola API</h2>
            <p class="mt-1 text-xs text-zinc-500 dark:text-slate-400 sm:text-sm">Daftar perangkat yang telah mengunjungi website Anda dan status blokirnya.</p>
        </div>

        <span class="inline-flex w-fit items-center rounded-lg border border-zinc-200 bg-white px-2.5 py-1.5 text-[10px] font-semibold text-zinc-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 sm:px-3 sm:text-xs">
            {{ $visitorDevices->count() }} perangkat tercatat
        </span>
    </div>

    <div class="grid grid-cols-1 gap-2.5 sm:gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-4">
            <p class="truncate text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Total perangkat</p>
            <p class="mt-2 text-xl font-semibold tabular-nums tracking-tight text-zinc-900 dark:text-slate-100 sm:text-2xl">{{ $visitorDevices->count() }}</p>
            <p class="mt-1 text-[10px] text-zinc-500 dark:text-slate-400 sm:text-[11px]">Semua yang tercatat</p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-4">
            <p class="truncate text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Aktif saat ini</p>
            <p class="mt-2 text-xl font-semibold tabular-nums tracking-tight text-emerald-600 dark:text-emerald-300 sm:text-2xl">{{ $visitorDevices->filter(fn ($device) => $device->is_active)->count() }}</p>
            <p class="mt-1 text-[10px] text-zinc-500 dark:text-slate-400 sm:text-[11px]">Kunjungan dalam 5 menit terakhir</p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-4">
            <p class="truncate text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Tidak aktif</p>
            <p class="mt-2 text-xl font-semibold tabular-nums tracking-tight text-amber-600 dark:text-amber-300 sm:text-2xl">{{ $visitorDevices->filter(fn ($device) => ! $device->is_blocked && ! $device->is_active)->count() }}</p>
            <p class="mt-1 text-[10px] text-zinc-500 dark:text-slate-400 sm:text-[11px]">Tidak ada aktivitas dalam 5 menit</p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-4">
            <p class="truncate text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Diblokir</p>
            <p class="mt-2 text-xl font-semibold tabular-nums tracking-tight text-rose-600 dark:text-rose-300 sm:text-2xl">{{ $visitorDevices->whereNotNull('blocked_at')->count() }}</p>
            <p class="mt-1 text-[10px] text-zinc-500 dark:text-slate-400 sm:text-[11px]">Perangkat terlarang</p>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-start gap-2.5 rounded-lg border border-zinc-200 border-l-2 border-l-zinc-900 bg-white px-3 py-2.5 text-xs text-zinc-800 dark:border-slate-800 dark:border-l-slate-100 dark:bg-slate-900/90 dark:text-slate-200 sm:px-4 sm:py-3 sm:text-sm">
            <svg viewBox="0 0 24 24" class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg>
            <span class="min-w-0">{{ session('success') }}</span>
        </div>
    @endif

    <section class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-slate-800 dark:bg-slate-900/90">
        <div class="overflow-x-auto">
            <table class="min-w-full border-separate border-spacing-0 text-left text-sm text-zinc-600 dark:text-slate-300">
                <thead class="bg-zinc-50 dark:bg-slate-800/60">
                    <tr class="text-[10px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400">
                        <th class="border-b border-zinc-200 px-3 py-2.5 lg:px-4 lg:py-3 dark:border-slate-700">Perangkat</th>
                        <th class="border-b border-zinc-200 px-3 py-2.5 lg:px-4 lg:py-3 dark:border-slate-700">Browser / Platform</th>
                        <th class="border-b border-zinc-200 px-3 py-2.5 lg:px-4 lg:py-3 dark:border-slate-700">IP</th>
                        <th class="border-b border-zinc-200 px-3 py-2.5 lg:px-4 lg:py-3 dark:border-slate-700">Terakhir dilihat</th>
                        <th class="border-b border-zinc-200 px-3 py-2.5 lg:px-4 lg:py-3 dark:border-slate-700">Kunjungan</th>
                        <th class="border-b border-zinc-200 px-3 py-2.5 lg:px-4 lg:py-3 dark:border-slate-700">Status</th>
                        <th class="border-b border-zinc-200 px-3 py-2.5 lg:px-4 lg:py-3 dark:border-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visitorDevices as $device)
                        <tr class="transition hover:bg-zinc-50/70 dark:hover:bg-slate-800/40">
                            <td class="border-b border-zinc-200 px-3 py-3 align-top lg:px-4 dark:border-slate-800">
                                <div class="font-semibold text-zinc-900 dark:text-slate-100">{{ $device->device_label ?: 'Perangkat' }}</div>
                                <div class="mt-1 text-[11px] text-zinc-500 dark:text-slate-400">{{ Str::limit($device->user_agent ?: 'User-agent tidak tersedia', 70) }}</div>
                            </td>
                            <td class="border-b border-zinc-200 px-3 py-3 align-top text-zinc-700 dark:border-slate-800 dark:text-slate-200 lg:px-4">
                                <div>{{ $device->browser ?: '-' }}</div>
                                <div class="mt-1 text-[11px] text-zinc-500 dark:text-slate-400">{{ $device->platform ?: '-' }}</div>
                            </td>
                            <td class="border-b border-zinc-200 px-3 py-3 align-top text-zinc-700 dark:border-slate-800 dark:text-slate-200 lg:px-4">{{ $device->ip_address ?: '-' }}</td>
                            <td class="border-b border-zinc-200 px-3 py-3 align-top tabular-nums text-zinc-700 dark:border-slate-800 dark:text-slate-200 lg:px-4">
                                {{ $device->last_seen_at ? $device->last_seen_at->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td class="border-b border-zinc-200 px-3 py-3 align-top tabular-nums text-zinc-700 dark:border-slate-800 dark:text-slate-200 lg:px-4">{{ $device->visit_count ?? 0 }}</td>
                            <td class="border-b border-zinc-200 px-3 py-3 align-top lg:px-4 dark:border-slate-800">
                                @if ($device->is_blocked)
                                    <span class="inline-flex rounded-md bg-rose-100 px-2 py-0.5 text-[10px] font-semibold text-rose-700 ring-1 ring-rose-200 dark:bg-rose-950/30 dark:text-rose-300 dark:ring-rose-900/60">Diblokir</span>
                                @elseif ($device->is_active)
                                    <span class="inline-flex rounded-md bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-300 dark:ring-emerald-900/60">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-md bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-700 ring-1 ring-amber-200 dark:bg-amber-950/30 dark:text-amber-300 dark:ring-amber-900/60">Tidak aktif</span>
                                @endif
                                <div class="mt-1 text-[10px] text-zinc-500 dark:text-slate-400">
                                    Terakhir mengunjungi: {{ $device->last_seen_at ? $device->last_seen_at->translatedFormat('d M Y, H:i') : '-' }}
                                </div>
                            </td>
                            <td class="border-b border-zinc-200 px-3 py-3 align-top lg:px-4 dark:border-slate-800">
                                @if ($device->is_blocked)
                                    <form method="POST" action="{{ route('admin.settings.device.unblock', $device) }}">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-[10px] font-semibold text-zinc-700 transition hover:border-zinc-900 hover:text-zinc-900 dark:border-slate-700 dark:bg-transparent dark:text-slate-200 dark:hover:border-slate-300 dark:hover:text-slate-100">Buka blokir</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.settings.device.block', $device) }}">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-[10px] font-semibold text-rose-700 transition hover:bg-rose-100 dark:border-rose-900 dark:bg-rose-950/30 dark:text-rose-300 dark:hover:bg-rose-950/50">Blokir perangkat</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border-b border-zinc-200 px-4 py-10 text-center text-sm text-zinc-500 dark:border-slate-800 dark:text-slate-400">
                                Belum ada perangkat yang tercatat mengunjungi website.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
