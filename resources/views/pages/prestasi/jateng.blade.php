@extends('layouts.frontend')
@section('content')
@php
$achievements = App\Support\AchievementStore::byLevel('jateng');
@endphp
<section class="bg-slate-50 py-16 dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="text-center md:text-left">
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-slate-900 dark:text-white">Prestasi Jateng</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white md:text-4xl">Capaian Tingkat Jateng</h1>
            </div>
            <a href="{{ route('home') }}" class="hidden md:inline-flex items-center rounded-lg bg-slate-900 px-5 py-2.5 text-xs font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Kembali ke Beranda
            </a>
        </div>
        @if($achievements)
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
                @foreach($achievements as $achievement)
                    @php
                        $imageUrl = asset($achievement['image'] ?? 'images/achievement/prestasi1.jpg');
                        $winnerSocialLink = trim((string) ($achievement['winner_social_link'] ?? ''));
                    @endphp
                    <article class="overflow-hidden rounded-xl border border-slate-200 bg-white transition hover:border-slate-900 dark:border-slate-800 dark:bg-black dark:hover:border-white">
                        <button type="button" class="block w-full text-left" data-achievement-image="{{ $imageUrl }}" data-achievement-title="{{ addslashes($achievement['title'] ?? 'Prestasi') }}" data-achievement-category="{{ addslashes($achievement['category'] ?? 'Prestasi') }}" data-achievement-winner="{{ addslashes($achievement['winner'] ?? 'Anggota') }}" data-achievement-winning-link="{{ addslashes($winnerSocialLink) }}" data-achievement-description="{{ addslashes($achievement['description'] ?? 'Prestasi yang membanggakan.') }}" onclick="openAchievementModal(this)">
                            <div class="h-44 overflow-hidden bg-slate-100 dark:bg-slate-900 sm:h-48">
                                <img src="{{ $imageUrl }}" alt="{{ $achievement['title'] }}" class="h-full w-full object-cover transition duration-500" />
                            </div>
                            <div class="space-y-2 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="rounded-full bg-slate-100 px-2 py-1 text-[9px] font-bold uppercase tracking-[0.12em] text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                                        {{ $achievement['category'] ?? 'Prestasi' }}
                                    </span>
                                    <span class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">{{ $achievement['year'] ?? now()->year }}</span>
                                </div>
                                <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ $achievement['title'] }}</h2>
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">
                                    @if($winnerSocialLink !== '')
                                        Pemenang: <a href="{{ $winnerSocialLink }}" target="_blank" rel="noopener noreferrer" class="font-semibold underline decoration-slate-400 underline-offset-4 hover:text-slate-900 dark:hover:text-white">{{ $achievement['winner'] ?? 'Anggota' }}</a>
                                    @else
                                        Pemenang: {{ $achievement['winner'] ?? 'Anggota' }}
                                    @endif
                                </p>
                                <p class="text-xs leading-5 text-slate-600 dark:text-slate-400">{{ $achievement['description'] ?? 'Prestasi yang membanggakan.' }}</p>
                            </div>
                        </button>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500 dark:border-slate-800 dark:bg-black dark:text-slate-400">
                Belum ada data prestasi tingkat Jateng.
            </div>
        @endif

        <div id="achievementModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/85 p-4 backdrop-blur-sm md:p-8" onclick="closeAchievementModal()">
            <button type="button" class="absolute right-5 top-5 text-3xl font-light text-white/75 transition hover:text-white" aria-label="Tutup detail prestasi" onclick="closeAchievementModal()">
                &times;
            </button>

            <div class="relative w-full max-w-5xl overflow-hidden rounded-2xl border border-white/10 bg-slate-950 shadow-2xl" onclick="event.stopPropagation()">
                <div class="flex flex-col lg:flex-row">
                    <div class="flex items-center justify-center bg-slate-900 lg:w-[62%]">
                        <img id="achievementModalImage" src="" alt="Detail prestasi" class="max-h-[72vh] w-full object-contain" />
                    </div>
                    <div class="flex flex-col justify-center space-y-3 p-5 text-left sm:p-6 lg:w-[38%] lg:p-7">
                        <div class="flex flex-wrap items-center gap-2">
                            <span id="achievementModalCategory" class="rounded-full bg-slate-800 px-2.5 py-1 text-[9px] font-bold uppercase tracking-[0.12em] text-slate-200"></span>
                            <span id="achievementModalYear" class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400"></span>
                        </div>
                        <h3 id="achievementModalTitle" class="text-xl font-black text-white sm:text-2xl"></h3>
                        <div id="achievementModalWinner" class="text-sm text-slate-300"></div>
                        <p id="achievementModalDescription" class="text-sm leading-6 text-slate-300"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali Khusus Mobile (Paling Bawah) -->
        <div class="mt-10 flex justify-center md:hidden">
            <a href="{{ route('home') }}" class="inline-flex items-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

<script>
    function openAchievementModal(button) {
        const modal = document.getElementById('achievementModal');
        const image = document.getElementById('achievementModalImage');
        const title = document.getElementById('achievementModalTitle');
        const category = document.getElementById('achievementModalCategory');
        const year = document.getElementById('achievementModalYear');
        const winner = document.getElementById('achievementModalWinner');
        const description = document.getElementById('achievementModalDescription');

        image.src = button.dataset.achievementImage;
        title.textContent = button.dataset.achievementTitle;
        category.textContent = button.dataset.achievementCategory;
        year.textContent = '2024';
        winner.innerHTML = button.dataset.achievementWinner ? 'Pemenang: ' + button.dataset.achievementWinner : 'Pemenang: -';
        description.textContent = button.dataset.achievementDescription || 'Prestasi yang membanggakan.';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeAchievementModal() {
        const modal = document.getElementById('achievementModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAchievementModal();
        }
    });
</script>
@endsection