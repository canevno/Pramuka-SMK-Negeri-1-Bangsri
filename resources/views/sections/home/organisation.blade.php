@php
    $organizationTitle = \App\Models\Setting::getValue('organization_title') ?: 'Our Organisation';
    $organizationDescription = \App\Models\Setting::getValue('organization_description') ?: 'Kami merupakan Satuan Gugus Depan yang memiliki jumlah anggota yang besar dan struktur organisasi yang baik dan selalu menjunjung Tinggi Dasa Dharma Pramuka di Kehidupan Sehari - Hari';
    $orgImages = [
        \App\Models\Setting::getValue('organization_card_1_image'),
        \App\Models\Setting::getValue('organization_card_2_image'),
        \App\Models\Setting::getValue('organization_card_3_image'),
        \App\Models\Setting::getValue('organization_card_4_image'),
    ];
@endphp

<section class="w-full bg-white dark:bg-gray-950 py-10 md:py-14">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        
        <!-- Main Container -->
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10 lg:items-start">

            <!-- Left Section - Title & Description -->
            <div class="w-full lg:w-72 flex-shrink-0 text-center lg:text-left">
                <h2 class="mb-4 text-4xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white lg:text-5xl">
                    {{ $organizationTitle }}
                </h2>
                <p class="text-sm font-normal leading-relaxed text-gray-600 dark:text-gray-400">
                    {{ $organizationDescription }}
                </p>
            </div>

            <!-- Right Section - Cards Grid -->
            <div class="flex-1 min-w-0">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">

                    @foreach([
                        ['title' => 'Pembina', 'desc' => 'Kami adalah pembina putra dan putri di ambalan KH. Acmad Fauzan Dan Dewi sartika. Pangkalan SMK Negeri 1 bangsri'],
                        ['title' => 'Dewan Ambalan', 'desc' => 'Kami adalah pembina putra dan putri di ambalan KH. Acmad Fauzan Dan Dewi sartika. Pangkalan SMK Negeri 1 bangsri'],
                        ['title' => 'Anggota Dewan', 'desc' => 'Kami adalah pembina putra dan putri di ambalan KH. Acmad Fauzan Dan Dewi sartika. Pangkalan SMK Negeri 1 bangsri'],
                        ['title' => 'Mitra', 'desc' => 'Kami adalah pembina putra dan putri di ambalan KH. Acmad Fauzan Dan Dewi sartika. Pangkalan SMK Negeri 1 bangsri'],
                    ] as $index => $card)
                        <div class="border-2 border-slate-300 dark:border-slate-500 bg-white dark:bg-gray-950 flex flex-col">
                            <div class="p-2">
                                <img src="{{ isset($orgImages[$index]) && $orgImages[$index] ? asset('storage/' . $orgImages[$index]) : asset('images/visimisi/visimisi1.jpg') }}" alt="{{ $card['title'] }}"
                                    class="w-full aspect-video object-cover border-2 border-slate-300 dark:border-slate-500">
                            </div>
                            <div class="px-3 pb-3 pt-2 flex flex-col flex-1">
                                <h3 class="mb-2 text-center text-base font-bold text-gray-900 dark:text-white lg:text-lg">
                                    {{ $card['title'] }}
                                </h3>
                                <p class="text-center text-xs font-medium leading-snug text-gray-600 dark:text-gray-400">
                                    {{ $card['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</section>