

<?php $__env->startSection('content'); ?>
<div x-data="{ 
    activeTab: '<?php echo e(request()->query('tab', 'kepanduan-dunia')); ?>',
    syncTabFromUrl() {
        const params = new URLSearchParams(window.location.search);
        const hash = window.location.hash.replace('#', '');
        const key = params.get('tab') || hash || 'kepanduan-dunia';
        const validTabs = {
            'kepanduan-dunia': 'kepanduan-dunia',
            'kepanduan-indonesia': 'kepanduan-indonesia',
            'gerakan-pramuka': 'gerakan-pramuka',
            'ad-art-munas-2023': 'ad-art-munas-2023',
            'lambang': 'lambang',
            'hymne-mars': 'hymne-mars',
            'uu-pramuka': 'uu-pramuka',
            'visi-misi-kwarnas': 'visi-misi-kwarnas',
            'visi-misi-pangkalan': 'visi-misi-pangkalan'
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
                <nav class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm space-y-3">
                    
                    <!-- Kategori: Profil -->
                    <div class="border-b border-slate-100 pb-2">
                        <span class="block px-3 py-1.5 text-base font-bold text-slate-950">
                            Profil
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
                            <button @click="changeTab('lambang')" 
                                :class="activeTab === 'lambang' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition">
                                Lambang
                            </button>
                            <button @click="changeTab('hymne-mars')" 
                                :class="activeTab === 'hymne-mars' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition">
                                Hymne & Mars
                            </button>
                            <button @click="changeTab('uu-pramuka')" 
                                :class="activeTab === 'uu-pramuka' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition leading-snug">
                                Undang-undang Nomor 12 Tahun 2010 Tentang Gerakan Pramuka
                            </button>
                        </div>
                    </div>

                    <!-- Kategori: Visi & Misi -->
                    <div>
                        <span class="block px-3 py-1.5 text-base font-bold text-slate-950">
                            Visi & Misi
                        </span>
                        <div class="mt-0.5 space-y-0.5 pl-3">
                            <button @click="changeTab('visi-misi-kwarnas')" 
                                :class="activeTab === 'visi-misi-kwarnas' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition">
                                Visi & Misi Kwarnas
                            </button>
                            <button @click="changeTab('visi-misi-pangkalan')" 
                                :class="activeTab === 'visi-misi-pangkalan' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition">
                                Visi & Misi Pangkalan
                            </button>
                        </div>
                    </div>

                </nav>
            </aside>

            <!-- KONTEN UTAMA -->
            <main class="order-1 lg:order-2 lg:col-span-8 xl:col-span-9">
                
                <!-- 1. Kepanduan Dunia -->
                <section id="kepanduan-dunia" x-show="activeTab === 'kepanduan-dunia'" class="pb-2 sm:pb-12 space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">
                        Kepanduan Dunia
                    </h2>
                    
                    <div class="mx-auto w-full max-w-[420px] overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-2 shadow-sm sm:max-w-[460px]">
                        <div class="h-[180px] overflow-hidden rounded-xl bg-slate-100 sm:h-[210px]">
                            <img src="<?php echo e(asset('images/download.jpg')); ?>" 
                                 alt="Kepanduan Dunia - Baden Powell" 
                                 class="h-full w-full object-contain object-center">
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-8 shadow-sm space-y-4 text-base sm:text-lg leading-relaxed text-slate-700 text-justify">
                        <p>
                            Kepanduan dunia berawal dari pemikiran seorang pemuda Inggris yang merangkum atau menulis pengalamannya saat bertugas di Afrika dan India. Pemuda tersebut adalah <strong>Lord Baden-Powell of Gilwell</strong> yang nama lengkapnya adalah <strong>Robert Stephenson Smyth Baden-Powell</strong>, namun lebih dikenal dengan sebutan <strong>BP</strong>.
                        </p>

                        <p>
                            Baden-Powell lahir pada tanggal 22 Februari 1857 di London. Ayahnya adalah seorang Profesor Geometry di Universitas Oxford bernama Baden Powell yang meninggal ketika Stephenson masih kecil. Baden Powell bergabung dengan pasukan Hussars ke-13 di India pada tahun 1876, kemudian dari tahun 1888 – 1895 Baden Powell sukses bertugas di India, Afganistan, Zulu, dan Ashanti.
                        </p>

                        <p>
                            Semasa Perang Boer, Baden-Powell bertugas sebagai staf dari pasukan Kerajaan Inggris (1896 – 1897), menjadi kolonel pasukan berkuda di Afrika Selatan (mengalami pengalaman terkepung oleh bangsa Boer di Kota Mafeking, Afrika Selatan selama 127 hari dengan kekurangan makanan), kemudian mengalahkan bangsa Zulu di Afrika dan mengambil kalung manik kayu milik raja Dinizulu.
                        </p>

                        <p>
                            Pengalamannya tersebut ia tulis menjadi sebuah buku dengan judul <strong>"AIDS TO SCOUTING"</strong> yang sebenarnya untuk memberi petunjuk kepada tentara Inggris agar dapat melakukan tugas penyelidik dengan baik. Buku tersebut memuat cara menjelajahi hutan dan kecakapan tertentu yang diperoleh dari alam ataupun tokoh masyarakat yang dilalui, seperti mengenali jejak perjalanan yang baru dilewati untuk keluar dari rimbunnya hutan, mengenali buah-buahan yang dapat dimakan, air yang boleh diminum, mengetahui arah mata angin tanpa melihat arah matahari karena rimbunnya hutan, dan sebagainya.
                        </p>

                        <p>
                            Untuk menguji kebenaran isi buku itu, 21 orang pemuda yang menamakan kelompok <em>Boys Brigade</em> mengundang Baden-Powell bersama-sama membuktikannya dengan mengadakan perkemahan di Pulau Brownsea (<em>Brownsea Island</em>) pada tanggal 25 Juli 1907 selama 8 hari. Peserta perkemahan melakukan pengembaraan menerapkan isi buku <em>Aids for Scouting</em> bersama Baden-Powell.
                        </p>

                        <p>
                            Pengalaman dalam perkemahan tersebut dicatat setiap hari. Pada akhir perkemahan, catatan tersebut dikumpulkan menjadi satu oleh Baden-Powell dan dijadikanlah sebuah buku dengan judul <strong>"SCOUTING FOR BOYS"</strong> yang diterbitkan tahun 1908.
                        </p>

                        <p>
                            Kelompok anak muda yang melakukan perkemahan di Brownsea tersebut mengubah nama kelompoknya dari <em>Boys Brigade</em> menjadi <strong>BOY SCOUT</strong> dan menjadikan <em>Scouting For Boys</em> sebagai buku panduannya. Kemudian ajaran Baden-Powell ini berkembang dan berdirilah organisasi kepanduan-kepanduan (yang semula hanya untuk anak laki-laki berusia penggalang) yang disebut Boys Scout.
                        </p>

                        <p>
                            Kemudian disusul berdirinya organisasi kepanduan putri yang diberi nama <strong>GIRL GUIDES</strong>, atas bantuan Agnes adik perempuan Baden-Powell dan diteruskan oleh Ny. Baden-Powell dengan buku panduan <em>HANDBOOK GIRL GUIDES</em> (dikerjakan bersama-sama dengan Agnes Baden-Powell tahun 1912) dan <em>GIRL GUIDES</em> (1918).
                        </p>

                        <p>
                            Baden-Powell kembali ke Inggris tahun 1908 menjadi Letnan Jenderal dan dianugerahi Ksatria tahun 1909. Pada tahun 1910 Baden-Powell meminta pensiun dari tentara dengan pangkat terakhir Letnan Jenderal. Ia menikah dengan Olave St. Clair Soames pada tahun 1912 dan dianugerahi tiga orang anak (Peter, Heather, Betty). Pada tahun 1912 berdiri pandu usia siaga yang disebut <strong>CUB</strong> (anak serigala) dengan buku <em>Jungle Book</em> berisi cerita tentang Mowgli anak didikan rimba (anak yang dipelihara oleh Serigala) karangan Rudyard Kipling sebagai cerita pembungkus kegiatan Cub ini.
                        </p>

                        <p>
                            Kemudian tahun 1918 Baden-Powell membentuk <strong>Rover Scout</strong> (Pramuka usia Penegak) untuk menampung mereka yang sudah lewat usia 17 tahun tetapi masih sering giat di bidang kepanduan, dengan buku panduan <strong>ROVERING TO SUCCESS</strong> (Mengembara Menuju Kebahagiaan) yang telah diterbitkan tahun 1912.
                        </p>

                        <p>
                            Pada tahun 1920 para pandu sedunia berkumpul di Olympia, London, Inggris dalam acara Jambore Dunia yang pertama. Ketika hari terakhir kegiatan jambore tanggal 6 Agustus 1920, Baden-Powell diangkat sebagai <strong>Chief Scout of The World</strong> atau Bapak Pandu Sedunia. Sejak tahun 1920 itu dibentuklah Dewan Internasional dengan 9 orang anggota dan Biro Sekretariatnya berada di London, Inggris.
                        </p>

                        <p>
                            Pada tahun 1929 Baden-Powell mendapat gelar kehormatan "Lord" hingga namanya menjadi <strong>Lord Baden-Powell of Gilwell</strong> dengan julukan Baron, gelar tersebut diberikan oleh Raja George V. Setelah berkeliling dunia termasuk berkunjung ke Batavia (Sekarang: Jakarta, Indonesia) tanggal 3 Desember 1934 sepulang meninjau Jambore di Australia, Baden-Powell beserta istrinya menghabiskan waktu tinggal di Inggris (sekitar tahun 1935-1938).
                        </p>

                        <p>
                            Kemudian ia kembali ke Afrika tanah yang amat dicintainya, dan menghabiskan masa tuanya di Nyeri, Kenya. Beliau wafat tanggal 8 Januari 1941 dan diantar di atas kereta yang ditarik oleh para pandu yang sangat mencintainya ke tempat peristirahatan terakhir.
                        </p>

                        <p>
                            Pada tahun 1958 Biro Kepanduan Sedunia (Putra) dipindahkan dari London ke Ottawa, Kanada. Pada tanggal 1 Mei 1968 dipindahkan lagi ke Geneva, Swiss (Jenewa Swiss). Biro Kepanduan Dunia (Putra) hanya mempunyai 40 orang staf yang ada di Geneva dan 5 kantor kawasan yakni: Costa Rica, Mesir, Filipina, Swiss, dan Nigeria. Biro Kepanduan Dunia (Putri) sampai dengan sekarang tetap berada di London dan mempunyai 5 kawasan yakni: Eropa, Asia Pasifik, Arab, Afrika, dan Amerika Latin.
                        </p>
                    </div>
                </section>


                <!-- 2. Kepanduan Indonesia -->
                <section x-show="activeTab === 'kepanduan-indonesia'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">
                        Kepanduan Indonesia
                    </h2>

                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                        <img src="<?php echo e(asset('images/kepanduan indonesia.jpg')); ?>" 
                             alt="Kepanduan Indonesia" 
                             class="mx-auto h-auto w-auto max-h-[280px] object-cover sm:max-h-[320px]">
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-8 shadow-sm space-y-4 text-base sm:text-lg leading-relaxed text-slate-700 text-justify">
                        <p>
                            Gerakan pendidikan kepanduan di Tanah Air sudah muncul sejak zaman Hindia-Belanda. Pada 1912, dimulai latihan sekelompok pandu di Batavia (nama Jakarta pada masa penjajahan Belanda), yang kemudian menjadi cabang dari <em>Nederlandsche Padvinders Organisatie</em> (NPO). Dua tahun kemudian cabang tersebut disahkan berdiri sendiri dan dinamakan <em>Nederlands-Indische Padvinders Vereeniging</em> (NIPV) atau Persatuan Pandu-Pandu Hindia Belanda.
                        </p>

                        <p>
                            Pada saat itu, sebagian besar anggota NIPV adalah pandu-pandu keturunan Belanda. Namun, pada 1916 berdiri suatu organisasi kepanduan yang sepenuhnya merupakan pandu-pandu bumiputera. Adalah Mangkunegara VII, pemimpin Keraton Solo yang membentuk Javaansche Padvinders Organisatie. Setelah itu muncul organisasi kepanduan berbasis agama, kesukuan dan lainnya. Antara lain Padvinder Muhammadiyah (Hizbul Wathan), Nationale Padvinderij, Syarikat Islam Afdeling Pandu, Kepanduan Bangsa Indonesia, Indonesisch Nationale Padvinders Organisatie, Pandu Indonesia, Padvinders Organisatie Pasundan, Pandu Kesultanan, El-Hilaal, Pandu Ansor, Al Wathoni, Tri Darma (Kristen), Kepanduan Asas Katolik Indonesia, dan Kepanduan Masehi Indonesia.
                        </p>

                        <p>
                            Kepanduan yang ada di Hindia-Belanda ternyata berkembang cukup baik. Hal itu menarik perhatian pula dari Bapak Pandu Sedunia, Lord Baden-Powell, yang bersama istrinya, Lady Baden-Powell, dan anak-anak mereka, mengunjungi organisasi kepanduan di Batavia, Semarang, dan Surabaya, pada awal Desember 1934. Para pandu di Hindia-Belanda pernah pula mengikuti Jambore Kepanduan Sedunia.
                        </p>

                        <p>
                            Bila pada Jambore Sedunia 1933 di Hungaria hanya sebatas pada kunjungan delegasi kecil untuk menyaksikan kegiatan akbar itu, maka pada Jambore Sedunia 1937 di Belanda, ikut pula Kontingen Pandu Hindia-Belanda yang terdiri dari Pandu-pandu keturunan Belanda, bumiputera khususnya dari Batavia dan Bandung, lalu dari Pandu Mangkunegaran, dari Ambon, dan sejumlah Pandu keturunan Tionghoa dan Arab. Sementara di dalam negeri, kegiatan perkemahan dan jamboree kepanduan juga diadakan di sejumlah tempat. Di antaranya pada 19-23 Juli 1941 di Yogyakarta berlangsung All Indonesian Jamboree atau “Perkemahan Kepanduan Indonesia Oemoem.”
                        </p>

                        <p>
                            Pada 27-29 Desember 1945 berlangsung Kongres Kesatuan Kepanduan Indonesia di Surakarta. Kongres tersebut menghasilkan Pandu Rakyat Indonesia sebagai satu-satunya organisasi kepramukaan di Indonesia. Namun, ketika Belanda kembali mengadakan agresi militer pada 1948, Pandu Rakyat dilarang berdiri di daerah-daerah yang sudah dikuasai Belanda. Hal tersebut memicu munculnya organisasi lain, seperti Kepanduan Putera Indonesia (KPI), Pandu Puteri Indonesia (PPI), dan Kepanduan Indonesia Muda (KIM).
                        </p>

                        <p>
                            Pada perkembangannya, kepanduan Indonesia kemudian terpecah menjadi 100 organisasi yang tergabung dalam Persatuan Kepanduan Indonesia (Perkindo). Namun, jumlah perkumpulan kepramukaan di Indonesia tidak sebanding dengan jumlah anggota perkumpulan. Selain itu masih ada rasa golongan yang tinggi, sehingga membuat Perkindo menjadi lemah. Untuk mencegah hal itu, Presiden Soekarno bersama Sri Sultan Hamengku Buwono IX yang saat itu merupakan Pandu Agung, menggagas peleburuan berbagai organisasi kepanduan dalam satu wadah.
                        </p>
                    </div>
                </section>


                <!-- 3. Gerakan Pramuka -->
                <section x-show="activeTab === 'gerakan-pramuka'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">
                        Gerakan Pramuka
                    </h2>

                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                        <img src="<?php echo e(asset('images/gerakanpramuka.jpg')); ?>" 
                             alt="Gerakan Pramuka" 
                             class="mx-auto h-auto w-auto max-h-[240px] object-contain sm:max-h-[280px]">
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-8 shadow-sm space-y-4 text-base sm:text-lg leading-relaxed text-slate-700 text-justify">
                        <p>
                            Gerakan Pramuka adalah organisasi pendidikan nonformal yang menyelenggarakan pendidikan kepanduan yang dilaksanakan di Indonesia. Kata Pramuka merupakan singkatan dari <strong>Praja Muda Karana</strong>, yang memiliki arti Orang Muda yang Suka Berkarya. Sebutan "Pramuka" diperuntukkan bagi Anggota Gerakan Pramuka yang terbagi dalam beberapa tingkatan usia: Pramuka Siaga (7-10 tahun), Pramuka Penggalang (11-15 tahun), Pramuka Penegak (16-20 tahun), dan Pramuka Pandega (21-25 tahun), sedangkan kelompok anggota lainnya disebut anggota dewasa.
                        </p>

                        <p>
                            Adapun yang dimaksud dengan "Kepramukaan" adalah proses pendidikan di luar lingkungan sekolah dan keluarga dalam bentuk kegiatan yang menarik, menyenangkan, sehat, teratur, terarah, dan praktis yang dilakukan di alam terbuka dengan menerapkan Prinsip Dasar Kepramukaan dan Metode Kepramukaan. Sasaran akhir dari kepramukaan adalah pembentukan watak, akhlak, dan budi pekerti luhur sebagai sistem pendidikan kepanduan yang disesuaikan dengan keadaan, kepentingan, dan perkembangan masyarakat serta bangsa Indonesia.
                        </p>

                        <p>
                            Sejarah awal kepanduan di Indonesia telah dimulai sejak tahun 1923 yang ditandai dengan didirikannya <em>Nationale Padvinderij Organisatie</em> (NPO) di Bandung dan <em>Jong Indonesische Padvinderij Organisatie</em> (JIPO) di Jakarta. Kedua organisasi cikal bakal kepanduan tersebut kemudian meleburkan diri menjadi satu organisasi bernama <em>Indonesische Nationale Padvinderij Organisatie</em> (INPO) di Bandung pada tahun 1926.
                        </p>

                        <p>
                            Gagasan peleburan seluruh organisasi kepanduan kemudian diungkapkan Presiden Soekarno ketika mengunjungi Perkemahan Besar Persatuan Kepanduan Putri Indonesia di Desa Semanggi, Ciputat, Tangerang, pada awal Oktober 1959. Presiden mengumpulkan tokoh dan pemimpin gerakan kepanduan di Indonesia untuk melebur seluruh organisasi ke dalam satu wadah bernama Pramuka, dengan menunjuk panitia pembentuk yang terdiri atas Sri Sultan Hamengku Buwono IX, Prijono, Azis Saleh, Achmadi, dan Muljadi Djojo Martono.
                        </p>

                        <p>
                            Pembentukan Gerakan Pramuka diawali dengan serangkaian peristiwa bersejarah: diresmikannya nama Pramuka pada 9 Maret 1961 sebagai Hari Tunas Gerakan Pramuka, diterbitkannya Keputusan Presiden Nomor 238 Tahun 1961 pada 20 Mei 1961 sebagai Hari Permulaan Tahun Kerja, serta ikrar peleburan seluruh organisasi kepanduan di Istora Senayan pada 20 Juli 1961 sebagai Hari Ikrar Gerakan Pramuka. Pada 14 Agustus 1961, Gerakan Pramuka diperkenalkan secara resmi kepada masyarakat luas melalui upacara di Istana Negara, ditandai penyerahan Panji Gerakan Pramuka dari Presiden Soekarno kepada Sri Sultan Hamengku Buwono IX, momen yang kini diperingati sebagai Hari Pramuka setiap tahunnya.
                        </p>

                        <p>
                            Gerakan Pramuka bertujuan untuk membentuk setiap Pramuka agar memiliki kepribadian yang beriman, bertakwa, berakhlak mulia, berjiwa patriotik, taat hukum, disiplin, menjunjung tinggi nilai-nilai luhur bangsa, dan memiliki kecakapan hidup sebagai kader bangsa dalam menjaga dan membangun Negara Kesatuan Republik Indonesia, mengamalkan Pancasila, serta melestarikan lingkungan.
                        </p>

                        <p>
                            Pelaksanaan pendidikan kepramukaan berlandaskan pada Prinsip Dasar Kepramukaan yang meliputi iman dan taqwa kepada Tuhan Yang Maha Esa, peduli terhadap bangsa dan tanah air, sesama hidup dan alam seisinya, peduli terhadap diri pribadi, serta taat kepada Kode Kehormatan Pramuka.
                        </p>

                        <p>
                            Prinsip tersebut diterapkan melalui Metode Kepramukaan yang mencakup pengamalan Kode Kehormatan Pramuka, belajar sambil melakukan, kegiatan berkelompok, bekerjasama, dan berkompetisi, kegiatan yang menarik dan menantang di alam terbuka, kehadiran orang dewasa yang memberikan bimbingan, dorongan, dan dukungan, penghargaan berupa tanda kecakapan, serta sistem satuan terpisah antara putra dan putri.
                        </p>

                        <p>
                            Berdasarkan resolusi Konferensi Kepanduan Sedunia tahun 1924 di Kopenhagen, Denmark, Kepanduan memiliki tiga sifat utama: <strong>Nasional</strong> (menyesuaikan pendidikannya dengan kebutuhan dan kepentingan negara), <strong>Internasional</strong> (membina persaudaraan tanpa membedakan agama, ras, dan suku), serta <strong>Universal</strong> (dapat dipergunakan di mana saja untuk mendidik anak-anak dari bangsa apa saja).
                        </p>
                    </div>
                </section>


                <!-- 4. AD - ART Munas 2023 -->
                <section id="ad-art-munas-2023" x-show="activeTab === 'ad-art-munas-2023'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">
                            AD - ART Munas 2023
                        </h2>
                        <!-- Tombol Desktop -->
                        <a href="https://drive.google.com/uc?export=download&id=1TsyiuH3zC7vF7Uqkx4F1KrDRhTVj-YVC" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition shadow-sm">
                            Unduh PDF
                        </a>
                    </div>

                    <!-- Viewer PDF Iframe Responsif -->
                    <div class="w-full h-[550px] sm:h-[750px] overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 shadow-sm">
                        <iframe 
                            src="https://drive.google.com/file/d/1TsyiuH3zC7vF7Uqkx4F1KrDRhTVj-YVC/preview" 
                            class="w-full h-full border-0 rounded-2xl"
                            allow="autoplay">
                        </iframe>
                    </div>

                    <!-- Tombol Mobile (Di bawah preview) -->
                    <a href="https://drive.google.com/uc?export=download&id=1TsyiuH3zC7vF7Uqkx4F1KrDRhTVj-YVC" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="sm:hidden flex w-full items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition shadow-sm">
                        Unduh PDF
                    </a>
                </section>


                <!-- 5. Lambang -->
                <section x-show="activeTab === 'lambang'" x-cloak class="pb-2 sm:pb-12">
                    <div class="space-y-6">
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">
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
                <section x-show="activeTab === 'hymne-mars'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">
                        Hymne dan Mars Pramuka
                    </h2>
                    
                    <div class="grid gap-6 sm:grid-cols-2">
                        <!-- Card Hymne Pramuka -->
                        <div class="rounded-2xl bg-white p-5 sm:p-6 border border-slate-200 shadow-sm space-y-4">
                            <h3 class="text-xl font-bold text-slate-900 border-b border-slate-200 pb-3">
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
                            <h3 class="text-xl font-bold text-slate-900 border-b border-slate-200 pb-3">
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

                            <!-- Audio Player Mars -->
                            <audio controls class="w-full rounded-lg pt-2">
                                <source src="<?php echo e(asset('Mars-Jayalah-Pramuka.mp3')); ?>" type="audio/mpeg">
                                Browser Anda tidak mendukung pemutar audio.
                            </audio>
                        </div>
                    </div>
                </section>


                <!-- 7. UU No 12 Tahun 2010 -->
                <section x-show="activeTab === 'uu-pramuka'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">
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
                            <h3 class="text-xl font-bold tracking-tight text-slate-950">
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
                            <h3 class="text-xl font-bold tracking-tight text-slate-950">
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


                <!-- 8. Visi & Misi Kwarnas -->
                <section id="visi-misi-kwarnas" x-show="activeTab === 'visi-misi-kwarnas'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <!-- Judul + Logo Kwarnas -->
                    <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-4 sm:gap-6">
                        <img src="<?php echo e(asset('kwarnaslogo.png')); ?>" 
                             alt="Logo Kwarnas" 
                             class="h-28 sm:h-40 w-auto object-contain shrink-0 order-1 sm:order-2">
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950 flex-1 order-2 sm:order-1 text-center sm:text-left">
                            Visi, Misi, Dan Tujuan Kwartir Nasional (Kwarnas)
                        </h2>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-8 shadow-sm space-y-6 text-base sm:text-lg leading-relaxed text-slate-700 text-justify">
                        
                        <!-- VISI -->
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold text-slate-900">
                                Visi Pengembangan Gerakan Pramuka
                            </h3>

                            <p>
                                Gerakan Pramuka sebagai organisasi pendidikan nonformal yang turut berperan dalam pendidikan kaum muda Indonesia. Tantangan utama yang dihadapi adalah bagaimana menempatkan Pramuka sebagai bagian penting dalam lingkungan strategis Indonesia serta memposisikan kegiatan Pramuka sebagai <em>centre of excellence</em> bagi para pemuda.
                            </p>

                            <p>
                                Gerakan Pramuka merupakan bagian dari sistem pendidikan nasional yang termasuk ke dalam jalur pendidikan nonformal yang berupaya membentuk kepribadian kaum muda yang berakhlak mulia, berjiwa patriotik, taat hukum, disiplin, menjunjung tinggi nilai-nilai luhur bangsa dan memiliki kecakapan hidup. Melalui kegiatan Gerakan Pramuka diharapkan karakter dan kepribadian kaum muda dapat dibina dan dikembangkan guna turut serta dalam pembangunan nasional.
                            </p>

                            <p>
                                Dalam hal ini, Gerakan Pramuka menjadi wadah pembentukan karakter dan kepribadian kaum muda. Berdasarkan hal tersebut, dalam upaya Penyusunan Arah Kebijakan Gerakan Pramuka Indonesia Tahun 2014–2045 ditetapkan Visi Gerakan Pramuka yang akan diwujudkan selama 25 tahun ke depan, yaitu: <strong>”Gerakan Pramuka Wadah Utama Pembentukan Kader Pemimpin Bangsa”</strong>.
                            </p>
                        </div>

                        <!-- MISI -->
                        <div class="space-y-4 pt-4 border-t border-slate-100">
                            <h3 class="text-xl font-bold text-slate-900">
                                Misi Perencanaan dan Pengembangan Gerakan Pramuka
                            </h3>

                            <p>
                                Gerakan Pramuka sebagaimana diamanatkan dalam Undang-Undang RI Nomor 12 Tahun 2010 tentang Gerakan Pramuka memiliki tugas berat sebagai wahana negara dan bangsa dalam rangka menyiapkan kader-kader muda pemimpin bangsa di masa depan.
                            </p>

                            <p>
                                Tugas ini sangat berat jika hanya dipikul sendiri oleh Gerakan Pramuka. Dalam praktiknya, tentu saja memerlukan dukungan seluruh pemangku kepentingan negara dan bangsa agar cita-cita bersama tersebut dapat terwujud dengan seksama, sistematis, dan terstruktur.
                            </p>

                            <p>
                                Keluaran yang dihasilkan oleh Gerakan Pramuka harus memenuhi kualifikasi objektif yang menjadi bekal kader pramuka dalam mengarungi tantangan lokal, nasional, regional, dan global di semua lini kehidupan yang akan dijalaninya.
                            </p>

                            <p>
                                Dalam kaca mata Gerakan Pramuka, kualifikasi itu berwujud pada empat hal yaitu karakter, kecakapan hidup, bela negara, dan kerelawanan. Keempat hal ini adalah modal fundamental bagi seorang calon pemimpin bangsa dan negara di masa depan.
                            </p>

                            <p>
                                Untuk itu, kualitas keluaran Gerakan Pramuka harus dippproses melalui serangkaian program, kegiatan, dan latihan-latihan keorganisasian yang terus menerus tanpa henti.
                            </p>

                            <p class="font-semibold text-slate-900">
                                Gerakan Pramuka menetapkan Misi:
                            </p>

                            <ol class="list-decimal pl-6 space-y-2 text-slate-700">
                                <li>Mewujudkan Sistem Pendidikan Kepramukaan yang Mampu Menjawab tantangan Lingkungan Strategis Bangsa dan Menghasilkan Pemimpin-pemimpin Bangsa yang Berkualitas sesuai Satya dan Darma Pramuka.</li>
                                <li>Mewujudkan sistem keorganisasian dan kepengelolaan Gerakan Pramuka yang menyeimbangkan voluntarisme dan profesionalisme, modern, dan melayani seluruh pemangku kepentingan kepramukaan.</li>
                                <li>Mewujudkan kapasitas keuangan, usaha, dan aset Gerakan Pramuka yang memenuhi kebutuhan penyelenggaraan pendidikan kepramukaan dan memiliki kemandirian mendasar bagi keberlanjutan Gerakan Pramuka.</li>
                                <li>Mewujudkan kiprah dan pengabdian Gerakan Pramuka kepada masyarakat, bangsa, dan negara secara maksimal melalui pendekatan informatika, komunikasi publik dan semangat kerelewanan yang berkelanjutan.</li>
                            </ol>

                            <p>
                                Misi Gerakan Pramuka ini mempersiapkan kaum muda untuk menjadi pemimpin yang berkarakter dan berbudi pekerti luhur sebagai generasi penerus bangsa yang menjadi penentu arah kebijakan pembangunan nasional, mengedepankan pendidikan watak, kepribadian, dan budi pekerti luhur serta memberikan pembekalan kecakapan hidup agar menjadi kader pembangunan yang handal guna menghadapi tantangan persaingan global dengan berlandaskan sistem nilai Satya dan Darma Pramuka.
                            </p>
                        </div>

                        <!-- TUJUAN -->
                        <div class="space-y-4 pt-4 border-t border-slate-100">
                            <h3 class="text-xl font-bold text-slate-900">
                                Tujuan Pengembangan Gerakan Pramuka
                            </h3>

                            <p>
                                Gerakan Pramuka bertujuan untuk melahirkan lapisan dan barisan pemimpin bangsa Indonesia yang sesuai dengan Satya dan Darma Pramuka, mengingat situasi dan kondisi bangsa yang semakin terbelah secara sosial, ekonomi, dan politik.
                            </p>

                            <p>
                                Karakteristik dari pemimpin yang akan dilahirkan adalah berkarakter, berkecakapan, bela negara, dan berkerelawan yang tinggi. Berkenaan dengan hal tersebut, maka ditetapkan tujuan, diantaranya:
                            </p>

                            <ol class="list-decimal pl-6 space-y-2 text-slate-700">
                                <li>Gerakan Pramuka memiliki ketahanan diri (<em>scout resilience</em>) yang ditopang dengan infrastruktur minimum yang berkelanjutan.</li>
                                <li>Gerakan Pramuka menjadi paling unggul dalam pendidikan nonformal di Indonesia.</li>
                                <li>Gerakan Pramuka menjadi reservoir yang strategis bagi bangsa dan negara Indonesia dalam mengamalkan nilai-nilai Pancasila.</li>
                                <li>Gerakan Pramuka memiliki citra yang positif dan mampu bekerjasama dengan seluruh pemangku kepentingan secara konstitusional dan terintegrasi.</li>
                                <li>Gerakan Pramuka memiliki kelembagaan, sumberdaya manusia, dan produktivitas yang bermutu. Gerakan Pramuka menyiapkan kader pemimpin bangsa yang berakhlak mulia.</li>
                            </ol>

                            <p>
                                Berdasarkan tujuan pengembangan Gerakan Pramuka, kaum muda dibentuk menjadi pramuka yang memiliki kepribadian yang beriman, bertakwa, berahlak mulia, berjiwa patriotik, taat hukum, disiplin, menjunjung tinggi nilai-nilai luhur bangsa, berkecakapan hidup, sehat jasmani dan rohani untuk diciptakan sebagai pemimpin yang berkarakter dan berbudi pekerti luhur dalam upaya pembangunan bangsa dan negara.
                            </p>

                            <p>
                                Tujuan tersebut menjadi cita-cita Gerakan Pramuka yang mengarah kepada upaya pembentukan karakter dan kepribadian dengan menjunjung tinggi persatuan dan kesatuan bangsa Indonesia.
                            </p>
                        </div>

                    </div>
                </section>


                <!-- 9. Visi & Misi Pangkalan / Ambalan -->
                <section id="visi-misi-pangkalan" x-show="activeTab === 'visi-misi-pangkalan'" x-cloak class="pb-2 sm:pb-12 space-y-6">
                    <!-- Judul + Dual Logo Ambalan (Bersebelahan) -->
                    <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-4 sm:gap-6">
                        <!-- Container Dua Logo Bersebelahan -->
                        <div class="flex items-center justify-center gap-3 sm:gap-4 shrink-0 order-1 sm:order-2">
                            <img src="<?php echo e(asset('images/logos/aflogo.png')); ?>" 
                                 alt="Logo Ambalan Putra" 
                                 class="h-24 sm:h-36 w-auto object-contain">
                            <img src="<?php echo e(asset('images/logos/dslogo.png')); ?>" 
                                 alt="Logo Ambalan Putri" 
                                 class="h-24 sm:h-36 w-auto object-contain">
                        </div>
                        
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950 flex-1 order-2 sm:order-1 text-center sm:text-left">
                            Visi, Misi, Dan Tujuan Ambalan Pangkalan
                        </h2>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-8 shadow-sm space-y-6 text-base sm:text-lg leading-relaxed text-slate-700 text-justify">
                        
                        <!-- VISI -->
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold text-slate-900">
                                Visi Ambalan
                            </h3>

                            <p>
                                Ambalan Penegak Pangkalan bertekad menjadi wadah pembinaan generasi muda yang unggul, berkarakter, dan berdaya saing tinggi di tingkat pangkalan maupun lingkungan masyarakat. Melalui pendidikan kepramukaan yang berkesinambungan, Ambalan berkomitmen membentuk Pramuka Penegak yang tangguh, mandiri, dan berjiwa kepemimpinan.
                            </p>

                            <p>
                                Berlandaskan asas Pancasila serta Kode Kehormatan Pramuka, Ambalan berusaha mengarahkan seluruh potensi anggotanya agar siap menjadi pelopor kebaikan, inovasi, dan pengabdian bagi lingkungan sekolah serta masyarakat sekitar.
                            </p>

                            <p>
                                Berdasarkan semangat tersebut, ditetapkan Visi Ambalan Pangkalan, yaitu: <strong>”Mewujudkan Pramuka Penegak yang Berkarakter Luhur, Cerdas, Mandiri, Berwawasan Global, serta Berlandaskan Tri Satya dan Dasa Darma.”</strong>
                            </p>
                        </div>

                        <!-- MISI -->
                        <div class="space-y-4 pt-4 border-t border-slate-100">
                            <h3 class="text-xl font-bold text-slate-900">
                                Misi Ambalan
                            </h3>

                            <p>
                                Untuk mewujudkan visi tersebut, Ambalan Penegak menjalankan serangkaian misi strategis yang berfokus pada pengembangan kualitas karakter, keterampilan teknis kepramukaan, dan jiwa kepemimpinan setiap anggota.
                            </p>

                            <p class="font-semibold text-slate-900">
                                Ambalan Pangkalan menetapkan Misi:
                            </p>

                            <ol class="list-decimal pl-6 space-y-2 text-slate-700">
                                <li>Meningkatkan kualitas keimanan dan ketakwaan kepada Tuhan Yang Maha Esa melalui pengamalan Kode Kehormatan Pramuka dalam kehidupan sehari-hari.</li>
                                <li>Menyelenggarakan kegiatan kepramukaan yang interaktif, edukatif, inovatif, dan menantang di alam terbuka berbasis kecakapan hidup (<em>life skills</em>).</li>
                                <li>Membina potensi kepemimpinan, kedisiplinan, dan jiwa kewirausahaan (<em>scoutpreneurship</em>) anggota Ambalan guna menghadapi tantangan zaman.</li>
                                <li>Mengembangkan sikap kepedulian sosial, kerelawanan, dan bakti masyarakat demi terwujudnya hubungan yang harmonis dengan lingkungan pangkalan dan masyarakat.</li>
                                <li>Membangun tata kelola organisasi Ambalan yang tertib, transparan, modern, dan berorientasi pada persaudaraan bakti.</li>
                            </ol>

                            <p>
                                Pelaksanaan misi ini diharapkan mampu membentuk anggota Ambalan yang siap melangkah ke jenjang Penegak Bantara, Laksana, hingga mencapai tingkatan Pramuka Garuda.
                            </p>
                        </div>

                        <!-- TUJUAN -->
                        <div class="space-y-4 pt-4 border-t border-slate-100">
                            <h3 class="text-xl font-bold text-slate-900">
                                Tujuan Ambalan
                            </h3>

                            <p>
                                Pembinaan dan kegiatan di Ambalan Pangkalan diarahkan untuk meletakkan pondasi kepemimpinan yang kuat pada diri setiap Penegak. Tujuan utama yang ingin dicapai meliputi:
                            </p>

                            <ol class="list-decimal pl-6 space-y-2 text-slate-700">
                                <li>Membentuk anggota Penegak yang beriman, bertakwa, berakhlak mulia, dan berjiwa patriotik.</li>
                                <li>Mencetak calon pemimpin muda yang memiliki kedisiplinan tinggi, tanggung jawab, serta kecakapan berorganisasi.</li>
                                <li>Meningkatkan keterampilan kepramukaan (<em>scout skill</em>) dan wawasan kebangsaan seluruh anggota Ambalan.</li>
                                <li>Menghasilkan Pramuka Garuda yang mampu menjadi teladan baik di lingkungan sekolah maupun masyarakat luas.</li>
                                <li>Menciptakan iklim persaudaraan yang erat antar-anggota Penegak, Dewan Ambalan, dan Pembina Pangkalan.</li>
                            </ol>

                            <p>
                                Dengan tercapainya tujuan tersebut, Ambalan Pangkalan diharapkan terus mencetak kader-kader bangsa yang siap mengabdi demi kemajuan Indonesia.
                            </p>
                        </div>

                    </div>
                </section>

            </main>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/visi-misi.blade.php ENDPATH**/ ?>