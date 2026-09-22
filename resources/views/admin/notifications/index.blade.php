@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Notifikasi Admin</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Semua pembaruan, data masuk, dan perubahan status pendaftaran muncul di sini.</p>
        </div>
        <form action="{{ route('admin.notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Tandai semua dibaca
            </button>
        </form>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-950">
        <div class="divide-y divide-slate-200 dark:divide-slate-800">
            @forelse($notifications as $notification)
                <div class="block p-4 transition hover:bg-slate-50 dark:hover:bg-slate-900/60">
                    <div class="flex items-start justify-between gap-4">
                        <a href="{{ route('admin.notifications.visit', $notification) }}" class="flex-1 block space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-2.5 w-2.5 rounded-full {{ $notification->is_read ? 'bg-slate-300' : 'bg-emerald-500' }}"></span>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $notification->title }}</p>
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-300">{{ $notification->message }}</p>
                            <div class="flex items-center gap-3 text-xs text-slate-400 dark:text-slate-500">
                                <span>{{ $notification->created_at ? $notification->created_at->diffForHumans() : 'Baru saja' }}</span>
                                @if($notification->type)
                                    <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $notification->type }}</span>
                                @endif
                            </div>
                        </a>

                        @if(! $notification->is_read)
                            <form action="{{ route('admin.notifications.read', $notification) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-[10px] font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:text-white">
                                    Baca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-sm text-slate-500 dark:text-slate-400">
                    Belum ada notifikasi terbaru.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
