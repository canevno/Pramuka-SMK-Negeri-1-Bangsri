<section class="relative w-full overflow-hidden bg-white dark:bg-gray-950 transition-colors duration-200 hero-section">

    {{-- Foto Putra (tengah-kiri) --}}
    <img
        src="{{ asset('images/logos/iconambalan1.png') }}"
        alt="Anggota Pramuka Putra"
        class="absolute object-contain object-bottom blend-fade-top icon-ambalan-1"
        style="
            width: 32%;
            left: 25%;
            bottom: 0;
        "
    />

    {{-- Foto Putri (tengah-kanan) --}}
    <img
        src="{{ asset('images/logos/iconambalan2.png') }}"
        alt="Anggota Pramuka Putri"
        class="absolute object-contain object-bottom blend-fade-top icon-ambalan-2"
        style="
            width: 30%;
            left: 50%;
            bottom: 0;
        "
    />

    {{-- Logo KH. Achmad Fauzan --}}
    <img
        src="{{ asset('images/logos/aflogo.png') }}"
        alt="Logo KH. Achmad Fauzan"
        class="absolute hero-logo hero-logo-af"
        style="
            width: 11.93%;
            left: 9.9%;
            top: 61.39%;
        "
    />

    {{-- Logo Dewi Sartika --}}
    <img
        src="{{ asset('images/logos/dslogo.png') }}"
        alt="Logo Dewi Sartika"
        class="absolute hero-logo hero-logo-ds"
        style="
            width: 11.93%;
            left: 79.27%;
            top: 61.39%;
        "
    />

    {{-- Nama & Deskripsi KH. Achmad Fauzan --}}
    <div class="absolute text-center hero-text" style="left: 7.76%; top: 82.5%;">
        <p class="font-semibold text-black dark:text-white font-['Poppins'] transition-colors duration-200"
           style="font-size: clamp(14px, 1.5625vw, 30px);">
            KH. Achmad Fauzan
        </p>
        <p class="text-black dark:text-white font-semibold font-['Poppins'] max-w-[15vw] leading-snug mt-1 transition-colors duration-200"
           style="font-size: clamp(8px, 0.729vw, 14px);">
            Merupakan Ambalan Pramuka Penegak Putra di Pangkalan SMK Negeri 1 Bangsri, Gugus Depan 03.161
        </p>
    </div>

    {{-- Nama & Deskripsi Dewi Sartika --}}
    <div class="absolute text-center hero-text" style="left: 77.19%; top: 82.5%;">
        <p class="font-semibold text-black dark:text-white font-['Poppins'] transition-colors duration-200"
           style="font-size: clamp(14px, 1.5625vw, 30px);">
            Dewi Sartika
        </p>
        <p class="text-black dark:text-white font-semibold font-['Poppins'] max-w-[15vw] leading-snug mt-1 transition-colors duration-200"
           style="font-size: clamp(8px, 0.729vw, 14px);">
            Merupakan Ambalan Pramuka Penegak Putri di Pangkalan SMK Negeri 1 Bangsri, Gugus Depan 03.162
        </p>
    </div>

    {{-- Button (Mobile Only) --}}
    <a 
        href="{{ route('about') }}"
        class="hero-button lg:hidden text-black dark:text-white border-2 border-slate-300 dark:border-slate-500 rounded-full px-6 py-2 font-semibold transition-colors duration-200 inline-block">
        Lihat Selengkapnya
    </a>

</section>

<style>
    .blend-fade-top {
        mask-image: linear-gradient(to top, transparent 0%, rgba(0, 0, 0, 0.5) 8%, rgba(0, 0, 0, 1) 16%);
        -webkit-mask-image: linear-gradient(to top, transparent 0%, rgba(0, 0, 0, 0.5) 8%, rgba(0, 0, 0, 1) 16%);
    }

    /* Hide buttons by default (desktop) */
    .hero-button {
        display: none;
    }

    /* Mobile styles */
    @media (max-width: 1023px) {
        .hero-section {
            min-height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            margin-top: -40px; /* Dekatkan ke navbar */
            gap: 15px;
        }

        /* Hide icon ambalan di mobile */
        .icon-ambalan-1,
        .icon-ambalan-2 {
            display: none;
        }

        /* Show logo dan text di mobile */
        .hero-logo,
        .hero-text {
            display: block !important;
            position: static !important;
            width: auto !important;
            left: auto !important;
            top: auto !important;
            text-align: center;
            margin: 0;
        }

        .hero-logo {
            width: 140px !important;
            height: auto;
        }

        /* Description styling for mobile */
        .hero-text p:first-child {
            font-size: 16px !important;
            margin-bottom: 8px;
        }

        .hero-text p:last-child {
            font-size: 13px !important;
            max-width: 280px !important;
            margin-top: 0 !important;
            line-height: 1.5;
        }

        /* Show buttons di mobile */
        .hero-button {
            display: block !important;
            position: static !important;
            margin-top: 20px !important;
            margin-bottom: 0 !important;
        }

        /* Order: Logo KH (3), Text KH (5), Logo DS (4), Text DS (6), Button (7) */
        .hero-section > :nth-child(3) {
            order: 1;
        }

        .hero-section > :nth-child(5) {
            order: 2;
        }

        .hero-section > :nth-child(4) {
            order: 3;
        }

        .hero-section > :nth-child(6) {
            order: 4;
        }

        .hero-section > :nth-child(7) {
            order: 5;
        }
    }

    /* Desktop - maintain aspect-video with negative margin */
    @media (min-width: 1024px) {
        .hero-section {
            aspect-ratio: 16 / 9;
            margin-top: -248px; /* -mt-62 */
            min-height: auto;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 0;
            gap: 0;
        }

        /* Show icon ambalan di desktop */
        .icon-ambalan-1,
        .icon-ambalan-2 {
            display: block;
            position: absolute;
        }

        /* Reset icon ambalan to original size on desktop */
        .icon-ambalan-1 {
            width: 32% !important;
            left: 25% !important;
            bottom: 0 !important;
        }

        .icon-ambalan-2 {
            width: 30% !important;
            left: 50% !important;
            bottom: 0 !important;
        }

        /* Reset logo dan text positioning di desktop */
        .hero-logo,
        .hero-text {
            position: absolute !important;
            width: auto;
            display: block;
            order: auto;
        }

        .hero-logo {
            width: 11.93% !important;
            animation: heroLogoFloat 6s ease-in-out infinite alternate;
            will-change: transform;
        }

        .hero-logo-af {
            animation-delay: 0s;
        }

        .hero-logo-ds {
            animation-delay: 0.3s;
        }

        .hero-text {
            text-align: center;
            animation: heroTextFadeIn 0.8s ease-out forwards;
            animation-delay: 0.4s;
        }

        /* Hide buttons di desktop */
        .hero-button {
            display: none !important;
        }

        .icon-ambalan-1 {
            animation: heroIconFloat 8s ease-in-out infinite alternate;
        }

        .icon-ambalan-2 {
            animation: heroIconFloat 10s ease-in-out infinite alternate;
        }

        @keyframes heroLogoFloat {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-12px);
            }
        }

        @keyframes heroIconFloat {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-24px);
            }
        }

        @keyframes heroTextFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .hero-logo,
            .hero-text,
            .icon-ambalan-1,
            .icon-ambalan-2 {
                animation: none !important;
                transition: none !important;
            }
        }
    }
</style>

