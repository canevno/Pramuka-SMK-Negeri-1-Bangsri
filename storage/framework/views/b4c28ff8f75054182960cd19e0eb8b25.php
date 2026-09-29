

<?php
    $adArtPdfSetting = \App\Models\Setting::getValue('history_ad_art_munas_2023_file');
    $adArtPdfUrl = $adArtPdfSetting
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($adArtPdfSetting)
        : 'https://drive.google.com/uc?export=download&id=1TsyiuH3zC7vF7Uqkx4F1KrDRhTVj-YVC';

    $formatHistoryContent = function ($content) {
        if (empty(trim((string) $content))) {
            return '';
        }

        if (preg_match('/<\s*[^>]+>/', (string) $content)) {
            return (string) $content;
        }

        $normalized = preg_replace('/\r\n|\r/', "\n", (string) $content);
        $normalized = preg_replace('/\n{3,}/', "\n\n", trim($normalized));
        $paragraphs = preg_split('/\n\s*\n/', $normalized);

        $rendered = [];
        foreach ($paragraphs as $paragraph) {
            $text = trim((string) $paragraph);
            if ($text === '') {
                continue;
            }

            $rendered[] = '<p class="mb-4 leading-relaxed text-slate-700">' . nl2br(e($text), false) . '</p>';
        }

        return implode('', $rendered) ?: '<p class="leading-relaxed text-slate-700">' . nl2br(e($normalized), false) . '</p>';
    };

    $historySections = [
        'kepanduan-dunia' => [
            'title' => \App\Models\Setting::getValue('history_kepanduan_dunia_title') ?: 'Kepanduan Dunia',
            'content' => $formatHistoryContent(\App\Models\Setting::getValue('history_kepanduan_dunia_content') ?: 'Kepanduan dunia berawal dari pemikiran seorang pemuda Inggris, Lord Baden-Powell, yang mengembangkan metode pendidikan di alam terbuka melalui perkemahan di Pulau Brownsea pada 1907.\n\nSemangatnya kemudian berkembang menjadi gerakan kepanduan internasional yang menanamkan kedisiplinan, kepemimpinan, dan kepedulian sosial bagi generasi muda di seluruh dunia.'),
            'image' => \App\Models\Setting::getValue('history_kepanduan_dunia_image') ? \Illuminate\Support\Facades\Storage::disk('public')->url(\App\Models\Setting::getValue('history_kepanduan_dunia_image')) : asset('images/download.jpg'),
        ],
        'kepanduan-indonesia' => [
            'title' => \App\Models\Setting::getValue('history_kepanduan_indonesia_title') ?: 'Kepanduan Indonesia',
            'content' => $formatHistoryContent(\App\Models\Setting::getValue('history_kepanduan_indonesia_content') ?: 'Gerakan kepanduan di Indonesia dimulai sejak masa penjajahan Belanda dan kemudian berkembang menjadi lembaga yang membentuk semangat nasionalisme dan persatuan bangsa.\n\nBerbagai organisasi kepanduan di tanah air kemudian menyatu dalam satu wadah yang memperkuat semangat patriotisme dan karakter kaum muda Indonesia.'),
            'image' => \App\Models\Setting::getValue('history_kepanduan_indonesia_image') ? \Illuminate\Support\Facades\Storage::disk('public')->url(\App\Models\Setting::getValue('history_kepanduan_indonesia_image')) : asset('images/kepanduan indonesia.jpg'),
        ],
        'gerakan-pramuka' => [
            'title' => \App\Models\Setting::getValue('history_gerakan_pramuka_title') ?: 'Gerakan Pramuka',
            'content' => $formatHistoryContent(\App\Models\Setting::getValue('history_gerakan_pramuka_content') ?: 'Gerakan Pramuka lahir sebagai wadah pendidikan nonformal yang membangun karakter, kedisiplinan, dan kepedulian sosial bagi pemuda Indonesia.\n\nPramuka mengedepankan nilai Pancasila, prinsip dasar kepramukaan, dan semangat persatuan untuk membentuk generasi yang beriman, bertakwa, dan siap berkontribusi bagi bangsa.'),
            'image' => \App\Models\Setting::getValue('history_gerakan_pramuka_image') ? \Illuminate\Support\Facades\Storage::disk('public')->url(\App\Models\Setting::getValue('history_gerakan_pramuka_image')) : asset('images/gerakanpramuka.jpg'),
        ],
        'ad-art-munas-2023' => [
            'title' => \App\Models\Setting::getValue('history_ad_art_munas_2023_title') ?: 'AD - ART Munas 2023',
            'content' => $formatHistoryContent(\App\Models\Setting::getValue('history_ad_art_munas_2023_content') ?: 'AD-ART Munas 2023 menjadi pedoman utama penyelenggaraan Gerakan Pramuka dalam menjaga tata kelola organisasi, kepemimpinan, dan arah kebijakan strategis.\n\nDokumen ini menegaskan komitmen Pramuka untuk menjaga nilai organisasi, memperkuat kebersamaan, serta memastikan setiap program mendukung kesejahteraan masyarakat dan pembangunan bangsa.'),
            'pdf_url' => $adArtPdfUrl,
        ],
    ];
?>

<?php $__env->startSection('content'); ?>
<div x-data="{ 
    activeTab: '<?php echo e(request()->query('tab', 'kepanduan-dunia')); ?>',
    syncTabFromUrl() {
        const params = new URLSearchParams(window.location.search);
        const hash = window.location.hash.replace('#', '');
        const key = params.get('tab') || hash || 'kepanduan-dunia';
        const validTabs = {
            'kepanduan-dunia': 'kepanduan-dunia',
            'Dewan Ambalan': 'Dewan Ambalan',
            'gerakan-pramuka': 'gerakan-pramuka',
            'ad-art-munas-2023': 'ad-art-munas-2023',
            'lambang': 'lambang',
            'hymne-mars': 'hymne-mars',
            'uu-pramuka': 'uu-pramuka'
        };
        this.activeTab = validTabs[key] || 'kepanduan-dunia';
    },
    changeTab(tabName) {
        this.activeTab = tabName;
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tabName);
        url.hash = tabName;
        window.history.replaceState({}, '', url);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}" x-init="syncTabFromUrl()" class="bg-slate-50 text-slate-900 py-8 sm:py-16 min-h-screen">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-8 items-start">
            
            <!-- SIDEBAR KIRI -->
            <aside class="order-2 lg:order-1 lg:col-span-4 xl:col-span-3 lg:sticky lg:top-28 self-start z-10">
                <nav class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                    
                    <!-- Kategori: Sejarah -->
                    <div class="border-b border-slate-100 pb-2">
                        <span class="block px-3 py-1.5 text-base font-bold text-slate-950">
                            Sejarah
                        </span>
                        <div class="mt-0.5 space-y-0.5 pl-3">
                            <button @click="changeTab('kepanduan-dunia')" 
                                :class="activeTab === 'kepanduan-dunia' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition">
                                Kepanduan Dunia
                            </button>
                            <button @click="changeTab('kepanduan-indonesia')" 
                                :class="activeTab === 'kepanduan-indonesia' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition">
                                Kepanduan Indonesia
                            </button>
                            <button @click="changeTab('gerakan-pramuka')" 
                                :class="activeTab === 'gerakan-pramuka' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition">
                                Gerakan Pramuka
                            </button>
                            <button @click="changeTab('ad-art-munas-2023')" 
                                :class="activeTab === 'ad-art-munas-2023' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition">
                                AD - ART Munas 2023
                            </button>
                        </div>
                    </div>

                    <!-- Menu Utama Lainnya -->
                    <button @click="changeTab('lambang')" 
                        :class="activeTab === 'lambang' ? 'bg-slate-100 text-slate-950' : 'text-slate-950 hover:bg-slate-50'"
                        class="w-full text-left border-b border-slate-100 px-3 py-2.5 text-base font-bold transition">
                        Lambang
                    </button>

                    <button @click="changeTab('hymne-mars')" 
                        :class="activeTab === 'hymne-mars' ? 'bg-slate-100 text-slate-950' : 'text-slate-950 hover:bg-slate-50'"
                        class="w-full text-left border-b border-slate-100 px-3 py-2.5 text-base font-bold transition">
                        Hymne dan Mars
                    </button>

                    <button @click="changeTab('uu-pramuka')" 
                        :class="activeTab === 'uu-pramuka' ? 'bg-slate-100 text-slate-950' : 'text-slate-950 hover:bg-slate-50'"
                        class="w-full text-left px-3 py-2.5 text-base font-bold leading-snug transition">
                        Undang-undang Nomor 12 Tahun 2010 Tentang Gerakan Pramuka
                    </button>

                </nav>
            </aside>

            <!-- KONTEN UTAMA -->
            <main class="order-1 lg:order-2 lg:col-span-8 xl:col-span-9">
                
                <!-- 1. Kepanduan Dunia -->
                <section id="kepanduan-dunia" x-show="activeTab === 'kepanduan-dunia'" class="pb-2 sm:pb-12 space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-950">
                        <?php echo e($historySections['kepanduan-dunia']['title']); ?>

                    </h2>

                    <div class="mx-auto w-full max-w-[820px] overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-100 shadow-sm">
                        <div class="h-[180px] overflow-hidden bg-slate-100 sm:h-[240px] lg:h-[300px]">
                            <img src="<?php echo e($historySections['kepanduan-dunia']['image']); ?>"
                                 alt="Kepanduan Dunia - Baden Powell"
                                 class="h-full w-full object-cover object-center">
                        </div>
                    </div>

                    <div class="border-0 bg-transparent p-0 px-1 shadow-none sm:rounded-2xl sm:border sm:border-slate-200 sm:bg-white sm:p-5 sm:shadow-sm sm:p-8 space-y-5 text-base leading-relaxed text-slate-700 sm:text-lg text-justify">
                        <?php echo $historySections['kepanduan-dunia']['content']; ?>

                    </div>
                </section>


                <!-- 2. Kepanduan Indonesia -->
                <section x-show="activeTab === 'kepanduan-indonesia'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-950 mb-4">
                        <?php echo e($historySections['kepanduan-indonesia']['title']); ?>

                    </h2>

                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                        <img src="<?php echo e($historySections['kepanduan-indonesia']['image']); ?>"
                             alt="Kepanduan Indonesia"
                             class="mx-auto h-auto w-auto max-h-[280px] object-cover sm:max-h-[320px]">
                    </div>

                    <div class="border-0 bg-transparent p-0 px-1 shadow-none sm:rounded-2xl sm:border sm:border-slate-200 sm:bg-white sm:p-5 sm:shadow-sm sm:p-8 space-y-5 text-base leading-relaxed text-slate-700 sm:text-lg text-justify">
                        <?php echo $historySections['kepanduan-indonesia']['content']; ?>

                    </div>
                </section>


                <!-- 3. Gerakan Pramuka -->
                <section id="gerakan-pramuka" x-show="activeTab === 'gerakan-pramuka'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-950 mb-4">
                        <?php echo e($historySections['gerakan-pramuka']['title']); ?>

                    </h2>

                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                        <img src="<?php echo e($historySections['gerakan-pramuka']['image']); ?>"
                             alt="Gerakan Pramuka"
                             class="mx-auto h-auto w-auto max-h-[240px] object-contain sm:max-h-[280px]">
                    </div>

                    <div class="border-0 bg-transparent p-0 px-1 shadow-none sm:rounded-2xl sm:border sm:border-slate-200 sm:bg-white sm:p-5 sm:shadow-sm sm:p-8 space-y-5 text-base leading-relaxed text-slate-700 sm:text-lg text-justify">
                        <?php echo $historySections['gerakan-pramuka']['content']; ?>

                    </div>
                </section>


                <!-- 4. AD - ART Munas 2023 -->
                <section id="ad-art-munas-2023" x-show="activeTab === 'ad-art-munas-2023'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">
                            <?php echo e($historySections['ad-art-munas-2023']['title']); ?>

                        </h2>
                        <a href="https://drive.google.com/uc?export=download&id=1TsyiuH3zC7vF7Uqkx4F1KrDRhTVj-YVC"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="hidden sm:inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-slate-800">
                            Unduh PDF
                        </a>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
                        <div class="space-y-4 text-base leading-relaxed text-slate-700 sm:text-lg text-justify">
                            <?php echo $historySections['ad-art-munas-2023']['content']; ?>

                        </div>
                    </div>

                    <div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 shadow-sm">
                        <div class="h-[420px] sm:h-[620px]">
                            <iframe
                                src="<?php echo e($historySections['ad-art-munas-2023']['pdf_url'] ? 'https://docs.google.com/gview?embedded=true&url=' . urlencode($historySections['ad-art-munas-2023']['pdf_url']) : 'https://drive.google.com/file/d/1TsyiuH3zC7vF7Uqkx4F1KrDRhTVj-YVC/preview'); ?>"
                                class="h-full w-full border-0"
                                allow="autoplay">
                            </iframe>
                        </div>
                    </div>

                    <a href="<?php echo e($historySections['ad-art-munas-2023']['pdf_url'] ?? 'https://drive.google.com/uc?export=download&id=1TsyiuH3zC7vF7Uqkx4F1KrDRhTVj-YVC'); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex w-full items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-slate-800 sm:hidden">
                        Unduh PDF
                    </a>
                </section>


                <!-- 5. Lambang -->
                <section id="lambang" x-show="activeTab === 'lambang'" x-cloak class="pb-2 sm:pb-12">
                    <div class="space-y-6">
                        <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-950">
                            Lambang Gerakan Pramuka
                        </h2>

                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 sm:p-8 shadow-sm">
                            <div class="flex justify-center mb-6">
                                <img
                                    src="<?php echo e(asset('images/Tunas Kelapa.jpg')); ?>"
                                    alt="Lambang Tunas Kelapa Pramuka"
                                    class="h-auto max-h-[180px] w-auto object-contain drop-shadow-md sm:max-h-[220px]"
                                >
                            </div>

                            <div class="space-y-5 text-base sm:text-lg leading-relaxed text-slate-700 text-justify">
                                <p>
                                    <strong class="text-slate-900">“Satyaku Kudarmakan, Darmaku Kubaktikan.”</strong> Itulah moto dari Gerakan Pramuka. Sebagaimana yang ditetapkan dalam Anggaran Dasar Gerakan Pramuka pasal 48 dan Anggaran Rumah Tangga Gerakan Pramuka Bab VII Pasal 120, lambang dari Gerakan Pramuka adalah <strong class="text-slate-900">tunas kelapa</strong>.
                                </p>

                                <p>
                                    Penjabaran lambang ini ditetapkan dalam <strong class="text-slate-900">SK Kwarnas Nomor 06/KN/72</strong> tentang Lambang Pramuka.
                                </p>

                                <p>
                                    Pencipta lambang ini adalah <strong class="text-slate-900">Sunardjo Atmodipuro</strong>, seorang Andalan Nasional dan Pembina Pramuka yang juga pegawai dari Departemen Pertanian. Beliau lahir pada tanggal <strong class="text-slate-900">29 Februari 1903</strong> di Blora dan meninggal pada tanggal <strong class="text-slate-900">31 Mei 1979</strong>.
                                </p>

                                <p>
                                    <strong class="text-slate-900">Silhouette tunas kelapa</strong> adalah lambang Gerakan Pramuka sesuai dengan Surat Keputusan Kwartir Nasional Nomor 06/KN/72 yang merupakan penyempurna dari surat keputusan sebelumnya yaitu 15/KN/67 Tahun 1967.
                                </p>
                            </div>

                            <div class="space-y-5 pt-4 text-base sm:text-lg leading-relaxed text-slate-700 text-justify">
                                <p>
                                    <strong class="text-slate-900">SATU:</strong> Buah Nyiur dalam keadaan tumbuh dinamakan cikal dan istilah cikal bakal di Indonesia berarti penduduk asli yang pertama, yang menurunkan generasi baru. Jadi lambang buah Nyiur yang tumbuh mengkiaskan bahwa tiap Pramuka merupakan inti bagi kelangsungan hidup bangsa Indonesia.
                                </p>

                                <p>
                                    <strong class="text-slate-900">DUA:</strong> Buah Nyiur dapat bertahan lama dalam keadaan yang bagaimanapun juga. Jadi lambang itu mengkiaskan bahwa setiap Pramuka adalah seorang yang rohaniah dan jasmaniah sehat, kuat, dan ulet serta besar tekadnya dalam menghadapi segala tantangan dalam hidup dan dalam menempuh segala ujian dan kesukaran untuk mengabdi tanah air dan bangsa Indonesia.
                                </p>

                                <p>
                                    <strong class="text-slate-900">TIGA:</strong> Nyiur dapat tumbuh di mana saja, yang membuktikan besarnya daya upaya dalam menyesuaikan dirinya dengan keadaan sekelilingnya. Jadi lambang itu mengkiaskan bahwa tiap Pramuka dapat menyesuaikan diri dalam masyarakat dimana ia berada dan dalam keadaan yang bagaimanapun juga.
                                </p>

                                <p>
                                    <strong class="text-slate-900">EMPAT:</strong> Nyiur bertumbuh menjulang lurus ke atas dan merupakan salah satu pohon yang tertinggi di Indonesia. Jadi lambang itu mengkiaskan bahwa tiap Pramuka mempunyai cita-cita yang tinggi dan lurus, yakni yang mulia dan jujur, dan ia tetap tegak tidak mudah diombang-ambingkan oleh sesuatu.
                                </p>

                                <p>
                                    <strong class="text-slate-900">LIMA:</strong> Akar Nyiur yang tumbuh kuat dan erat di dalam tanah melambangkan bahwa tekad dan keyakinan tiap Pramuka mempunyai dan berpegang kepada dasar-dasar dan landasan-landasan yang baik, benar, kuat dan nyata, ialah tekad dan keyakinan yang dipakai olehnya untuk memperkuat diri guna mencapai cita-citanya.
                                </p>

                                <p>
                                    <strong class="text-slate-900">ENAM:</strong> Nyiur adalah pohon yang serbaguna, dari ujung hingga akarnya. Jadi lambang itu mengkiaskan bahwa tiap Pramuka adalah manusia yang berguna dan membaktikan diri serta kegunaannya kepada kepentingan tanah air, bangsa, dan Negara Kesatuan Republik Indonesia serta kepada umat manusia.
                                </p>
                            </div>

                            <p class="mt-6 text-sm font-medium italic text-slate-500">
                                Tulisan sesuai dengan yang tertera dalam Surat Keputusan Kwartir Nasional Nomor 06/KN/72.
                            </p>
                        </div>
                    </div>
                </section>


                <!-- 6. Hymne dan Mars -->
                <section id="hymne-mars" x-show="activeTab === 'hymne-mars'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-950">
                        Hymne dan Mars Pramuka
                    </h2>
                    
                    <div class="grid gap-6 sm:grid-cols-2">
                        <!-- Card Hymne Pramuka -->
                        <div class="rounded-2xl bg-white p-5 sm:p-6 border border-slate-200 shadow-sm space-y-4">
                            <h3 class="text-xl font-semibold text-slate-900 border-b border-slate-200 pb-3">
                                Hymne Pramuka
                            </h3>
                            
                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                                Hymne Satya Darma Pramuka diciptakan oleh seorang tokoh utama kepanduan sekaligus komponis musik lagu-lagu perjuangan yaitu <strong class="text-slate-900">Kak Husein Mutahar</strong>
                            </p>

                            <!-- Lirik Lagu -->
                            <p class="italic text-slate-700 leading-relaxed font-serif text-sm sm:text-base">
                                Kami pramuka indonesia<br>
                                Manusia pancasila<br>
                                Satyaku kudharmakan<br>
                                Dharmaku kubaktikan<br>
                                Agar jaya Indonesia<br>
                                Indonesia tanah airku<br>
                                Kami jadi pandu mu
                            </p>

                            <!-- Audio Player Hymne -->
                            <audio controls class="w-full rounded-lg pt-2">
                                <source src="<?php echo e(asset('Hymne-Satya-Darma-Pramuka.mp3')); ?>" type="audio/mpeg">
                                Browser Anda tidak mendukung pemutar audio.
                            </audio>
                        </div>

                        <!-- Card Mars Pramuka -->
                        <div class="rounded-2xl bg-white p-5 sm:p-6 border border-slate-200 shadow-sm space-y-4">
                            <h3 class="text-xl font-semibold text-slate-900 border-b border-slate-200 pb-3">
                                Mars Jayalah Pramuka
                            </h3>

                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                                Mars Jayalah Pramuka diciptakan oleh seorang tokoh utama kepanduan sekaligus komponis musik lagu-lagu perjuangan yaitu <strong class="text-slate-900">Kak H. Munatsir Amin</strong>
                            </p>

                            <!-- Lirik Lagu -->
                            <p class="italic text-slate-700 leading-relaxed font-serif text-sm sm:text-base">
                                Gerakan Pramuka Praja Muda Karana<br>
                                Sebagai wahana kaum muda suka berkarya<br>
                                Kader pembangunan sebagai perekat bangsa<br>
                                Disiplin berani dan setia berakhlak mulia<br>
                                Bersatu padu menyongsong masa depan yang gemilang<br>
                                Satu pramuka untuk satu Indonesia<br>
                                Melangkah maju menuju masyarakat yang sentosa<br>
                                Jayalah Pramuka Jayalah Indonesia
                            </p>

                            <!-- Audio Player Mars (Di Bawah Teks Lagu) -->
                            <audio controls class="w-full rounded-lg pt-2">
                                <source src="<?php echo e(asset('Mars-Jayalah-Pramuka.mp3')); ?>" type="audio/mpeg">
                                Browser Anda tidak mendukung pemutar audio.
                            </audio>
                        </div>
                    </div>
                </section>


                <!-- 7. UU No 12 Tahun 2010 -->
                <section id="uu-pramuka" x-show="activeTab === 'uu-pramuka'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight text-slate-950">
                            Sejarah Terbitnya Undang-Undang Nomor 12 Tahun 2010
                        </h2>
                        <p class="mt-1 text-sm text-slate-500 font-semibold">
                            Tentang Gerakan Pramuka
                        </p>
                    </div>

                    <!-- Materi Teks UU -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-8 shadow-sm space-y-5 text-base sm:text-lg leading-relaxed text-slate-700 text-justify">
                        <p>
                            Pendidikan kepramukaan merupakan salah satu pendidikan nonformal yang menjadi wadah pengembangan potensi diri serta memiliki akhlak mulia, pengendalian diri, dan kecakapan hidup untuk melahirkan kader penerus perjuangan bangsa dan negara.
                        </p>

                        <p>
                            Di samping itu, pendidikan kepramukaan yang diselenggarakan oleh organisasi gerakan pramuka merupakan wadah pemenuhan hak warga negara untuk berserikat dan mendapatkan pendidikan sebagaimana tercantum dalam <strong>Pasal 28, Pasal 28C, dan Pasal 31 Undang-Undang Dasar Negara Republik Indonesia Tahun 1945</strong>.
                        </p>

                        <p>
                            Gerakan pramuka yang pada masa pemerintahan Hindia-Belanda tahun 1912 disebut kepanduan terus berkembang dalam dinamika politik didasari oleh politik yang memecah belah bangsa. Namun kegiatan kepanduan di tanah air tetap memiliki komitmen yang sama yaitu menentang kebijakan pemerintahan kolonial Hindia-Belanda dan berjuang menuju kemerdekaan Indonesia.
                        </p>

                        <p>
                            Sejarah mencatat bahwa gerakan kepanduan melahirkan sikap patriotisme kaum muda yang pada muaranya mematangkan momentum <strong>Sumpah Pemuda 28 Oktober 1928</strong> dan <strong>Proklamasi Kemerdekaan Republik Indonesia pada tanggal 17 Agustus 1945</strong>. Setelah kemerdekaan, Presiden Republik Indonesia Ir. Soekarno mengumpulkan 60 (enam puluh) organisasi kepanduan untuk dikonsolidasikan menjadi kekuatan pembangunan nasional.
                        </p>

                        <p>
                            Untuk itu, Presiden Ir. Soekarno mengeluarkan <strong>Keputusan Presiden Nomor 238 Tahun 1961 Tentang Gerakan Pramuka</strong> yang intinya membentuk dan menetapkan Gerakan Pramuka sebagai satu-satunya perkumpulan yang memiliki kewenangan menyelenggarakan pendidikan kepanduan di Indonesia.
                        </p>

                        <p>
                            Perkembangan Gerakan Pramuka mengalami pasang surut dan pada kurun waktu tertentu kurang dirasakan penting oleh kaum muda. Akibatnya, pewarisan nilai-nilai yang terkandung dalam filsafat Pancasila dalam pembentukan kepribadian kaum muda yang merupakan inti dari pendidikan kepramukaan tidak optimal.
                        </p>

                        <p>
                            Pada waktu yang bersamaan dalam tatanan dunia global, bangsa dan negara membutuhkan kaum muda yang memiliki rasa cinta tanah air, kepribadian yang kuat dan tangguh, rasa kesetiakawanan sosial, kejujuran, sikap toleransi, kemampuan bekerja sama, rasa tanggung jawab, serta kedisiplinan untuk membela dan membangun bangsa. Dengan menyadari permasalahan ini, pada peringatan ulang tahun Gerakan Pramuka <strong>14 Agustus 2006 dicanangkan Revitalisasi Gerakan Pramuka</strong>.
                        </p>

                        <p>
                            Momentum revitalisasi Gerakan Pramuka tersebut dirasakan sangat penting dalam upaya pembangunan kepribadian bangsa yang sangat diperlukan dalam menghadapi tantangan sesuai dengan tuntutan perubahan zaman.
                        </p>

                        <p>
                            <strong>Undang-Undang Republik Indonesia Nomor 12 Tahun 2010 Tentang Gerakan Pramuka</strong> disusun dengan maksud untuk menghidupkan dan menggerakkan kembali semangat perjuangan yang dijiwai nilai-nilai Pancasila dalam kehidupan masyarakat yang beraneka ragam dan demokratis. Undang-undang ini menjadi dasar hukum bagi semua komponen bangsa dalam penyelenggaraan pendidikan kepramukaan yang bersifat mandiri, sukarela, dan nonpolitis dengan semangat Bhinneka Tunggal Ika untuk mempertahankan kesatuan dan persatuan bangsa dalam wadah Negara Kesatuan Republik Indonesia.
                        </p>

                        <p>
                            Undang-Undang Republik Indonesia Nomor 12 Tahun 2010 Tentang Gerakan Pramuka ini mengatur aspek pendidikan kepramukaan, kelembagaan, tugas dan wewenang Pemerintah dan pemerintah daerah, hak dan kewajiban para pemangku kepentingan, serta aspek keuangan Gerakan Pramuka.
                        </p>

                        <p>
                            Undang-Undang Republik Indonesia Nomor 12 Tahun 2010 tentang Gerakan Pramuka menegaskan <strong>Pancasila merupakan asas Gerakan Pramuka</strong> dan Gerakan Pramuka berfungsi sebagai wadah untuk mencapai tujuan pramuka melalui kegiatan kepramukaan yaitu pendidikan dan pelatihan, pengembangan, pengabdian masyarakat dan orang tua, serta permainan yang berorientasi pada pendidikan.
                        </p>

                        <p>
                            Selanjutnya, tujuan Gerakan Pramuka adalah membentuk setiap pramuka agar memiliki kepribadian yang beriman, bertakwa, berakhlak mulia, berjiwa patriotik, taat hukum, disiplin, menjunjung tinggi nilai-nilai luhur bangsa, dan memiliki kecakapan hidup sebagai kader bangsa dalam menjaga dan membangun Negara Kesatuan Republik Indonesia, mengamalkan Pancasila, serta melestarikan lingkungan hidup.
                        </p>

                        <!-- Box Catatan Legalitas Pengesahan -->
                        <div class="border-t border-slate-200 pt-5 mt-6 grid gap-2.5 sm:grid-cols-2 text-sm text-slate-600 bg-slate-50 p-4 rounded-xl text-left">
                            <div>
                                <span class="font-bold text-slate-900 block">Pengesahan:</span>
                                Disahkan oleh Presiden Dr. H. Susilo Bambang Yudhoyono di Jakarta pada tanggal 24 November 2010.
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block">Pengundangan:</span>
                                Diundangkan di Jakarta pada tanggal 24 November 2010 oleh Menkumham Patrialis Akbar.
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block">Lembaran Negara:</span>
                                Ditempatkan dalam Lembaran Negara Republik Indonesia Tahun 2010 Nomor 131.
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block">Tambahan Lembaran Negara:</span>
                                Tambahan Lembaran Negara Republik Indonesia Nomor 5169.
                            </div>
                        </div>
                    </div>

                    <!-- PDF Preview & Download UU No 12 Tahun 2010 -->
                    <div class="pt-6 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <h3 class="text-xl font-semibold tracking-tight text-slate-950">
                                Dokumen PDF UU No. 12 Tahun 2010
                            </h3>
                            <!-- Tombol Desktop -->
                            <a href="https://drive.google.com/uc?export=download&id=1XIAsjUAx-uDO_e1v68GqPSJhPFa43He0" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition shadow-sm">
                                Unduh PDF UU No. 12/2010
                            </a>
                        </div>

                        <!-- Viewer PDF Iframe -->
                        <div class="w-full h-[550px] sm:h-[750px] overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 shadow-sm">
                            <iframe 
                                src="https://drive.google.com/file/d/1XIAsjUAx-uDO_e1v68GqPSJhPFa43He0/preview" 
                                class="w-full h-full border-0 rounded-2xl"
                                allow="autoplay">
                            </iframe>
                        </div>

                        <!-- Tombol Mobile (Di bawah preview) -->
                        <a href="https://drive.google.com/uc?export=download&id=1XIAsjUAx-uDO_e1v68GqPSJhPFa43He0" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="sm:hidden flex w-full items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition shadow-sm">
                            Unduh PDF UU No. 12/2010
                        </a>
                    </div>

                    <!-- PDF Preview & Download Penjelasan UU No 12 Tahun 2010 -->
                    <div class="pt-6 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <h3 class="text-xl font-semibold tracking-tight text-slate-950">
                                Penjelasan Undang-undang Republik Indonesia Nomor 12 Tahun 2010 tentang Gerakan Pramuka
                            </h3>
                            <!-- Tombol Desktop -->
                            <a href="https://drive.google.com/uc?export=download&id=1AiHetcK-5IBjq4xFD6XGnoEyPF-1P_jK" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition shadow-sm">
                                Unduh PDF Penjelasan UU
                            </a>
                        </div>

                        <!-- Viewer PDF Iframe -->
                        <div class="w-full h-[550px] sm:h-[750px] overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 shadow-sm">
                            <iframe 
                                src="https://drive.google.com/file/d/1AiHetcK-5IBjq4xFD6XGnoEyPF-1P_jK/preview" 
                                class="w-full h-full border-0 rounded-2xl"
                                allow="autoplay">
                            </iframe>
                        </div>

                        <!-- Tombol Mobile (Di bawah preview) -->
                        <a href="https://drive.google.com/uc?export=download&id=1AiHetcK-5IBjq4xFD6XGnoEyPF-1P_jK" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="sm:hidden flex w-full items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition shadow-sm">
                            Unduh PDF Penjelasan UU
                        </a>
                    </div>
                </section>

            </main>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/about.blade.php ENDPATH**/ ?>