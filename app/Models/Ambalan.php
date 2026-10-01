{{-- Halaman publik Ambalan. Variabel dari rute: $ambalans['PA'] dan $ambalans['PI']
     Kolom: name, tagline, motto, description, photo_url, logo_url,
            leader_name, member_count, meeting_schedule, meeting_place, is_active

     PENTING: jika Anda sudah punya desain pages/ambalan.blade.php, JANGAN timpa.
     Pertahankan HTML lama, lalu ganti teks/gambarnya saja, misalnya:
        Ambalan Putra   ->  {{ $ambalans['PA']['name'] }}
        <img src="...">  ->  <img src="{{ $ambalans['PA']['photo_url'] ?? 'url-lama' }}">
     File ini hanyalah contoh pemakaian variabelnya. --}}
@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-6xl px-4 py-16">
    <div class="grid gap-8 md:grid-cols-2">
        @foreach (['PA', 'PI'] as $type)
            @php($a = $ambalans[$type])
            @continue(! $a['is_active'])

            <article class="overflow-hidden rounded-2xl border-2 border-black">
                @if ($a['photo_url'])
                    <img src="{{ $a['photo_url'] }}" alt="{{ $a['name'] }}" class="h-64 w-full object-cover">
                @endif

                <div class="space-y-3 p-6">
                    <div class="flex items-center gap-3">
                        @if ($a['logo_url'])
                            <img src="{{ $a['logo_url'] }}" alt="Logo {{ $a['name'] }}" class="h-12 w-12 object-contain">
                        @endif
                        <div>
                            <h2 class="text-2xl font-bold">{{ $a['name'] }}</h2>
                            @if ($a['tagline'])
                                <p class="text-sm opacity-70">{{ $a['tagline'] }}</p>
                            @endif
                        </div>
                    </div>

                    @if ($a['motto'])
                        <p class="italic">“{{ $a['motto'] }}”</p>
                    @endif

                    <p class="text-sm leading-relaxed">{!! nl2br(e($a['description'])) !!}</p>

                    <dl class="grid grid-cols-2 gap-3 border-t-2 border-black pt-4 text-sm">
                        @if ($a['leader_name'])
                            <div><dt class="font-semibold">Pradana</dt><dd>{{ $a['leader_name'] }}</dd></div>
                        @endif
                        @if ($a['member_count'])
                            <div><dt class="font-semibold">Anggota</dt><dd>{{ $a['member_count'] }} orang</dd></div>
                        @endif
                        @if ($a['meeting_schedule'])
                            <div><dt class="font-semibold">Jadwal</dt><dd>{{ $a['meeting_schedule'] }}</dd></div>
                        @endif
                        @if ($a['meeting_place'])
                            <div><dt class="font-semibold">Tempat</dt><dd>{{ $a['meeting_place'] }}</dd></div>
                        @endif
                    </dl>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection