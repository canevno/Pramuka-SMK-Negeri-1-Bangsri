<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{-- Ganti {{ $slot }} dengan kode di bawah ini --}}
        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </flux:main>
</x-layouts::app.sidebar>