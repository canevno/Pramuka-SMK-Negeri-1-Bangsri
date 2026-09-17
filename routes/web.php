<?php

use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\AttendanceController;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');

Route::view('/tentang-kami', 'pages.about')->name('about');
Route::view('/visi-misi', 'pages.visi-misi')->name('visi-misi');
Route::view('/ambalan', 'pages.ambalan')->name('ambalan');
Route::view('/organisasi', 'pages.organisasi')->name('organisasi');
Route::get('/pembina', function () {
    $pembinas = \Illuminate\Support\Facades\Schema::hasTable('pembinas')
        ? \App\Models\Pembina::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
        : collect();

    $dewanAnggota = \Illuminate\Support\Facades\Schema::hasTable('students')
        ? \App\Models\Student::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('jabatan', 'like', '%dewan%')
                    ->orWhere('jabatan', 'like', '%ketua%')
                    ->orWhere('jabatan', 'like', '%sekretaris%')
                    ->orWhere('jabatan', 'like', '%bendahara%')
                    ->orWhere('nama', 'like', '%dewan%');
            })
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->get()
        : collect();

    return view('pages.pembina', compact('pembinas', 'dewanAnggota'));
})->name('pembina');

Route::get('/dewan-kehormatan', function () {
    $members = [
        [
            'name' => 'Ketua Dewan Kehormatan',
            'jabatan' => 'Ketua',
            'status' => 'Utama',
            'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=800',
            'description' => 'Mengawasi integritas, etika, dan penegakan kode kehormatan Pramuka dalam setiap keputusan organisasi.',
        ],
        [
            'name' => 'Wakil Ketua Dewan Kehormatan',
            'jabatan' => 'Wakil Ketua',
            'status' => 'Pendamping',
            'photo_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=800',
            'description' => 'Mendukung evaluasi etika dan memastikan keputusan kehormatan berjalan adil dan konsisten.',
        ],
        [
            'name' => 'Sekretaris Dewan Kehormatan',
            'jabatan' => 'Sekretaris',
            'status' => 'Dokumentasi',
            'photo_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=800',
            'description' => 'Mengelola agenda, catatan keputusan, dan pendokumentasian proses evaluasi kehormatan.',
        ],
    ];

    return view('pages.dewan-kehormatan', ['members' => $members]);
})->name('dewan-kehormatan');

Route::get('/dewan-ambalan', function () {
    $members = \Illuminate\Support\Facades\Schema::hasTable('dewan_ambalans')
        ? \App\Models\DewanAmbalan::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(function ($member) {
                return [
                    'name' => $member->name,
                    'jabatan' => $member->jabatan,
                    'status' => $member->status,
                    'photo_url' => $member->photo_url ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600',
                    'description' => $member->bio ?: 'Anggota aktif yang mendorong program kerja dan pembinaan ambalan.',
                ];
            })
            ->all()
        : [];

    return view('pages.dewan-ambalan', ['members' => $members]);
})->name('dewan-ambalan');

Route::get('/anggota-dewan', function () {
    $dewanAnggota = \Illuminate\Support\Facades\Schema::hasTable('students')
        ? \App\Models\Student::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->get()
        : collect();

    return view('pages.anggota-dewan', compact('dewanAnggota'));
})->name('anggota-dewan');

Route::get('/mitra', function () {
    $partners = \Illuminate\Support\Facades\Schema::hasTable('mitras')
        ? \App\Models\Mitra::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn ($partner) => [
                'name' => $partner->name,
                'jabatan' => $partner->jabatan,
                'status' => $partner->status ?: ($partner->is_active ? 'Aktif' : 'Non-Aktif'),
                'photo_url' => $partner->photo_url ?: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800',
                'description' => $partner->bio ?: 'Mitra yang mendukung program, pembinaan, dan penguatan kegiatan Pramuka.',
            ])
            ->all()
        : [
            [
                'name' => 'Kwartir Ranting',
                'jabatan' => 'Pendamping Organisasi',
                'status' => 'Resmi',
                'photo_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800',
                'description' => 'Mendukung koordinasi program, pembinaan, serta pelaksanaan kegiatan kepramukaan di tingkat ranting.',
            ],
            [
                'name' => 'Instansi Pendidikan',
                'jabatan' => 'Kolaborator Program',
                'status' => 'Strategis',
                'photo_url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800',
                'description' => 'Menghubungkan kegiatan ambalan dengan proses pembelajaran, pelatihan, dan pengembangan sekolah.',
            ],
            [
                'name' => 'Komunitas Lingkungan',
                'jabatan' => 'Mitra Sosial',
                'status' => 'Terlibat',
                'photo_url' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&q=80&w=800',
                'description' => 'Bersama-sama menyelenggarakan aksi peduli lingkungan, kebersamaan, dan pengabdian masyarakat.',
            ],
        ];

    return view('pages.mitra', ['partners' => $partners]);
})->name('mitra');

Route::get('/pengurus-aktif', function () {
    $hasStudentsTable = \Illuminate\Support\Facades\Schema::hasTable('students');

    if (! $hasStudentsTable) {
        return view('pages.active-board', ['anggota' => collect()]);
    }

    $query = \App\Models\Student::query();

    if (\Illuminate\Support\Facades\Schema::hasColumn('students', 'is_active')) {
        $query->where('is_active', true);
    }

    if (\Illuminate\Support\Facades\Schema::hasColumn('students', 'sort_order')) {
        $query->orderBy('sort_order');
    }

    if (\Illuminate\Support\Facades\Schema::hasColumn('students', 'nama')) {
        $query->orderBy('nama');
    }

    return view('pages.active-board', ['anggota' => $query->get()]);
})->name('active-board');

Route::get('/alumni', function () {
    $members = \Illuminate\Support\Facades\Schema::hasTable('alumni')
        ? \App\Models\Alumni::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn ($member) => [
                'name' => $member->name,
                'jabatan' => $member->jabatan,
                'status' => $member->status ?: ($member->is_active ? 'Aktif' : 'Non-Aktif'),
                'photo_url' => $member->photo_url ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600',
                'description' => $member->bio ?: 'Alumni aktif yang terus mendukung dan menyalurkan semangat Pramuka untuk generasi berikutnya.',
            ])
            ->all()
        : [
            [
                'name' => 'Muhammad Rafi S.',
                'jabatan' => 'Ketua Alumni',
                'status' => 'Aktif',
                'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=800',
                'description' => 'Alumni yang aktif menjaga silaturahmi dan mendukung pengembangan kegiatan Pramuka.',
            ],
            [
                'name' => 'Siti Nuraeni',
                'jabatan' => 'Sekretaris Alumni',
                'status' => 'Aktif',
                'photo_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=800',
                'description' => 'Berperan dalam penguatan jaringan alumni dan kegiatan sosial serta pembinaan generasi muda.',
            ],
            [
                'name' => 'Dimas Pratama',
                'jabatan' => 'Koordinator Kegiatan',
                'status' => 'Aktif',
                'photo_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=800',
                'description' => 'Mensinergikan alumni dengan ambalan untuk menjaga kesinambungan semangat Pramuka.',
            ],
        ];

    return view('pages.alumni', ['members' => $members]);
})->name('alumni');

Route::redirect('/prestasi', '/#prestasi')->name('achievement');
Route::view('/prestasi/ranting', 'pages.prestasi.ranting')->name('prestasi.ranting');
Route::view('/prestasi/cabang', 'pages.prestasi.cabang')->name('prestasi.cabang');
Route::view('/prestasi/jateng', 'pages.prestasi.jateng')->name('prestasi.jateng');
Route::view('/prestasi/nasional', 'pages.prestasi.nasional')->name('prestasi.nasional');

Route::get('/event', function () {
    $events = \Illuminate\Support\Facades\Schema::hasTable('timeline_events')
        ? \App\Models\TimelineEvent::query()
            ->where('is_active', true)
            ->orderBy('date')
            ->orderBy('sort_order')
            ->get()
        : collect();

    return view('pages.event', compact('events'));
})->name('event');

Route::view('/artikel', 'pages.article')->name('article');

Route::get('/berita', [ModuleController::class, 'publicNewsPage'])->name('news');
Route::get('/berita/{slug}', [ModuleController::class, 'showNewsDetail'])->name('berita.show');

Route::get('/galeri', function () {
    $galleryItems = \App\Models\GalleryItem::query()
        ->where('is_published', true)
        ->orderByDesc('is_featured')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->get();

    return view('pages.gallery', compact('galleryItems'));
})->name('gallery');

Route::get('/search', function (Illuminate\Http\Request $request) {
    $q = trim((string) $request->query('q', ''));

    $pages = [
        ['title' => 'Beranda', 'route' => route('home'), 'keywords' => 'beranda utama home'],
        ['title' => 'Absensi', 'route' => route('absensi.index'), 'keywords' => 'absensi kehadiran siswa daftar hadir'],
        ['title' => 'Tentang Kami', 'route' => route('about'), 'keywords' => 'tentang kami sejarah profil'],
        ['title' => 'Visi & Misi', 'route' => route('visi-misi'), 'keywords' => 'visi misi tujuan program'],
        ['title' => 'Ambalan', 'route' => route('ambalan'), 'keywords' => 'ambalan gugus pramuka satuan'],
        ['title' => 'Pembina', 'route' => route('pembina'), 'keywords' => 'pembina pembimbing ketua pengurus'],
        ['title' => 'Dewan Kehormatan', 'route' => route('dewan-kehormatan'), 'keywords' => 'dewan kehormatan pengurus organisasi'],
        ['title' => 'Dewan Ambalan', 'route' => route('dewan-ambalan'), 'keywords' => 'dewan ambalan pengurus ambalan'],
        ['title' => 'Pengurus Aktif', 'route' => route('active-board'), 'keywords' => 'pengurus aktif anggota dewan'],
        ['title' => 'Alumni', 'route' => route('alumni'), 'keywords' => 'alumni mantan anggota'],
        ['title' => 'Prestasi', 'route' => route('achievement'), 'keywords' => 'prestasi juara lomba tingkat nasional daerah'],
        ['title' => 'Prestasi Ranting', 'route' => route('prestasi.ranting'), 'keywords' => 'prestasi ranting juara lomba tingkat ranting'],
        ['title' => 'Prestasi Cabang', 'route' => route('prestasi.cabang'), 'keywords' => 'prestasi cabang juara lomba tingkat cabang'],
        ['title' => 'Prestasi Jateng', 'route' => route('prestasi.jateng'), 'keywords' => 'prestasi jateng juara lomba provinsi'],
        ['title' => 'Prestasi Nasional', 'route' => route('prestasi.nasional'), 'keywords' => 'prestasi nasional juara lomba nasional'],
        ['title' => 'Event', 'route' => route('event'), 'keywords' => 'event agenda kegiatan'],
        ['title' => 'Artikel', 'route' => route('article'), 'keywords' => 'artikel tulisan informasi edukasi'],
        ['title' => 'Berita', 'route' => route('news'), 'keywords' => 'berita informasi kegiatan'],
        ['title' => 'Galeri', 'route' => route('gallery'), 'keywords' => 'galeri foto dokumentasi acara'],
        ['title' => 'Pendaftaran Bantara', 'route' => route('pendaftaran-bantara'), 'keywords' => 'bantara pendaftaran calon anggota'],
        ['title' => 'Pendaftaran Laksana', 'route' => route('pendaftaran-laksana'), 'keywords' => 'laksana pendaftaran calon anggota'],
        ['title' => 'Kontak', 'route' => route('contact'), 'keywords' => 'kontak hubungi cs'],
    ];

    $results = [];
    $bestMatch = null;
    $bestScore = -1;

    if ($q !== '') {
        $needle = mb_strtolower($q);

        foreach ($pages as $page) {
            $title = mb_strtolower($page['title']);
            $keywords = mb_strtolower($page['keywords']);
            $haystack = $title . ' ' . $keywords;
            $score = 0;

            if ($title === $needle) {
                $score += 100;
            }

            if (str_starts_with($title, $needle)) {
                $score += 40;
            }

            if (str_contains($title, $needle)) {
                $score += 25;
            }

            if (str_contains($keywords, $needle)) {
                $score += 15;
            }

            if (str_contains($haystack, $needle)) {
                $score += 10;
            }

            if ($score > 0) {
                $results[] = [
                    'title' => $page['title'],
                    'route' => $page['route'],
                    'keywords' => $page['keywords'],
                    'score' => $score,
                ];

                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestMatch = $page['route'];
                }
            }
        }

        if ($bestMatch) {
            return redirect()->to($bestMatch);
        }
    }

    return view('pages.search-results', compact('q', 'results'));
})->name('search');

Route::view('/pendaftaran-bantara', 'pages.pendaftaran-bantara')->name('pendaftaran-bantara');
Route::post('/pendaftaran-bantara', function (Illuminate\Http\Request $request) {
    $request->validate([
        'nama' => 'required|string',
        'kelas' => 'required|string',
        'jenis_kelamin' => 'required|string',
        'rt' => 'required|string',
        'rw' => 'required|string',
        'kecamatan' => 'required|string',
        'kabupaten' => 'required|string',
        'tempat_tanggal_lahir' => 'required|string',
        'motivasi' => 'required|string',
        'whatsapp' => 'required|string',
        'nomor_orang_tua' => 'required|string',
        'surat_izin' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
    ]);

    if ($request->hasFile('surat_izin') && $request->file('surat_izin')->isValid()) {
        $request->file('surat_izin')->store('pendaftaran-bantara');
    }

    return redirect()->route('pendaftaran-bantara')->with('pendaftaran_success', 'Pendaftaran berhasil!');
})->name('pendaftaran-bantara.submit');

Route::view('/pendaftaran-laksana', 'pages.pendaftaran-laksana')->name('pendaftaran-laksana');
Route::post('/pendaftaran-laksana', function (Illuminate\Http\Request $request) {
    $request->validate([
        'nama' => 'required|string',
        'nta' => 'required|string',
        'kelas' => 'required|string',
        'jenis_kelamin' => 'required|string',
        'rt' => 'required|string',
        'rw' => 'required|string',
        'kecamatan' => 'required|string',
        'kabupaten' => 'required|string',
        'tempat_tanggal_lahir' => 'required|string',
        'motivasi' => 'required|string',
        'whatsapp' => 'required|string',
        'nomor_orang_tua' => 'required|string',
        'surat_izin' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
    ]);

    if ($request->hasFile('surat_izin') && $request->file('surat_izin')->isValid()) {
        $request->file('surat_izin')->store('pendaftaran-laksana');
    }

    return redirect()->route('pendaftaran-laksana')->with('pendaftaran_success', 'Pendaftaran berhasil!');
})->name('pendaftaran-laksana.submit');

Route::view('/kontak', 'pages.contact')->name('contact');

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;

// Redirect default login route to admin login
Route::redirect('/login', '/admin/login');

// Admin auth routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
    // Admin panel is mounted at /admin to keep it separate from public site
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/news', [ModuleController::class, 'news'])->name('admin.news');
    Route::post('/admin/news', [ModuleController::class, 'storeNews'])->name('admin.news.store');
    Route::put('/admin/news/{post}', [ModuleController::class, 'updateNews'])->name('admin.news.update');
    Route::post('/admin/news/{post}/duplicate', [ModuleController::class, 'duplicateNews'])->name('admin.news.duplicate');
    Route::delete('/admin/news/{post}', [ModuleController::class, 'deleteNews'])->name('admin.news.delete');

    Route::get('/admin/hero', [ModuleController::class, 'hero'])->name('admin.hero');
    Route::post('/admin/hero', [ModuleController::class, 'storeHero'])->name('admin.hero.store');
    Route::put('/admin/hero/{heroSlide}', [ModuleController::class, 'updateHero'])->name('admin.hero.update');
    Route::post('/admin/hero/{heroSlide}/toggle', [ModuleController::class, 'toggleHero'])->name('admin.hero.toggle');
    Route::delete('/admin/hero/{heroSlide}', [ModuleController::class, 'deleteHero'])->name('admin.hero.delete');

    Route::get('/admin/gallery', [ModuleController::class, 'gallery'])->name('admin.gallery');
    Route::post('/admin/gallery/store', [ModuleController::class, 'storeGallery'])->name('admin.gallery.store');
    Route::put('/admin/gallery/{id}', [ModuleController::class, 'updateGallery'])->name('admin.gallery.update');
    Route::post('/admin/gallery/{id}/duplicate', [ModuleController::class, 'duplicateGallery'])->name('admin.gallery.duplicate');
    Route::delete('/admin/gallery/{id}', [ModuleController::class, 'deleteGallery'])->name('admin.gallery.delete');

    Route::get('/admin/agenda', function () {
        return view('admin.section', [
            'title' => 'Kelola Agenda',
            'description' => 'Atur kegiatan dan jadwal Pramuka.',
            'publicRoute' => route('event'),
            'publicLabel' => 'Lihat Halaman Agenda',
            'fields' => [
                'Judul kegiatan',
                'Tanggal dan waktu',
                'Lokasi',
                'Deskripsi acara',
                'Penanggung jawab',
                'Status kegiatan',
            ],
        ]);
    })->name('admin.agenda');

    Route::get('/admin/absensi', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.absensi');
    Route::get('/admin/absensi/detail', [\App\Http\Controllers\Admin\AttendanceController::class, 'detail'])->name('admin.absensi.detail');
    Route::get('/admin/absensi/detail/export/excel', [\App\Http\Controllers\Admin\AttendanceController::class, 'exportExcel'])->name('admin.absensi.export.excel');
    Route::get('/admin/absensi/detail/export/pdf', [\App\Http\Controllers\Admin\AttendanceController::class, 'exportPdf'])->name('admin.absensi.export.pdf');

    Route::get('/admin/petugas', [\App\Http\Controllers\Admin\PetugasController::class, 'index'])->name('admin.petugas');
    Route::post('/admin/petugas/store', [\App\Http\Controllers\Admin\PetugasController::class, 'store'])->name('admin.petugas.store');
    Route::post('/admin/petugas/{id}/toggle', [\App\Http\Controllers\Admin\PetugasController::class, 'toggle'])->name('admin.petugas.toggle');
    Route::post('/admin/petugas/{id}/destroy', [\App\Http\Controllers\Admin\PetugasController::class, 'destroy'])->name('admin.petugas.destroy');

    Route::get('/admin/pendaftaran-laksana', function () {
        return view('admin.section', [
            'title' => 'Kelola Pendaftaran Laksana',
            'description' => 'Kelola pendaftaran khusus peserta Laksana.',
            'publicRoute' => route('pendaftaran-laksana'),
            'publicLabel' => 'Lihat Halaman Pendaftaran Laksana',
            'fields' => [
                'Nama lengkap',
                'Golongan',
                'Asal sekolah / gugus',
                'Tanggal lahir',
                'Surat izin / dokumen',
                'Status verifikasi',
            ],
        ]);
    })->name('admin.pendaftaran-laksana');

    Route::get('/admin/pembina', [\App\Http\Controllers\Admin\ModuleController::class, 'pembina'])->name('admin.pembina');
    Route::post('/admin/pembina/store', [\App\Http\Controllers\Admin\ModuleController::class, 'storePembina'])->name('admin.pembina.store');
    Route::put('/admin/pembina/{pembina}/update', [\App\Http\Controllers\Admin\ModuleController::class, 'updatePembina'])->name('admin.pembina.update');
    Route::post('/admin/pembina/{pembina}/toggle', [\App\Http\Controllers\Admin\ModuleController::class, 'togglePembina'])->name('admin.pembina.toggle');
    Route::delete('/admin/pembina/{pembina}', [\App\Http\Controllers\Admin\ModuleController::class, 'deletePembina'])->name('admin.pembina.delete');

    Route::get('/admin/dewan-ambalan', [\App\Http\Controllers\Admin\ModuleController::class, 'dewanAmbalan'])->name('admin.dewan-ambalan');
    Route::post('/admin/dewan-ambalan/store', [\App\Http\Controllers\Admin\ModuleController::class, 'storeDewanAmbalan'])->name('admin.dewan-ambalan.store');
    Route::put('/admin/dewan-ambalan/{dewanAmbalan}/update', [\App\Http\Controllers\Admin\ModuleController::class, 'updateDewanAmbalan'])->name('admin.dewan-ambalan.update');
    Route::post('/admin/dewan-ambalan/{dewanAmbalan}/toggle', [\App\Http\Controllers\Admin\ModuleController::class, 'toggleDewanAmbalan'])->name('admin.dewan-ambalan.toggle');
    Route::delete('/admin/dewan-ambalan/{dewanAmbalan}', [\App\Http\Controllers\Admin\ModuleController::class, 'deleteDewanAmbalan'])->name('admin.dewan-ambalan.delete');

    Route::get('/admin/mitra', [\App\Http\Controllers\Admin\ModuleController::class, 'mitra'])->name('admin.mitra');
    Route::post('/admin/mitra/store', [\App\Http\Controllers\Admin\ModuleController::class, 'storeMitra'])->name('admin.mitra.store');
    Route::put('/admin/mitra/{mitra}/update', [\App\Http\Controllers\Admin\ModuleController::class, 'updateMitra'])->name('admin.mitra.update');
    Route::post('/admin/mitra/{mitra}/toggle', [\App\Http\Controllers\Admin\ModuleController::class, 'toggleMitra'])->name('admin.mitra.toggle');
    Route::delete('/admin/mitra/{mitra}', [\App\Http\Controllers\Admin\ModuleController::class, 'deleteMitra'])->name('admin.mitra.delete');

    Route::get('/admin/alumni', [\App\Http\Controllers\Admin\ModuleController::class, 'alumni'])->name('admin.alumni');
    Route::post('/admin/alumni/store', [\App\Http\Controllers\Admin\ModuleController::class, 'storeAlumni'])->name('admin.alumni.store');
    Route::put('/admin/alumni/{alumni}/update', [\App\Http\Controllers\Admin\ModuleController::class, 'updateAlumni'])->name('admin.alumni.update');
    Route::post('/admin/alumni/{alumni}/toggle', [\App\Http\Controllers\Admin\ModuleController::class, 'toggleAlumni'])->name('admin.alumni.toggle');
    Route::delete('/admin/alumni/{alumni}', [\App\Http\Controllers\Admin\ModuleController::class, 'deleteAlumni'])->name('admin.alumni.delete');

    Route::get('/admin/anggota', [\App\Http\Controllers\Admin\ModuleController::class, 'anggota'])->name('admin.anggota');
    Route::post('/admin/anggota/store', [\App\Http\Controllers\Admin\ModuleController::class, 'storeAnggota'])->name('admin.anggota.store');
    Route::delete('/admin/anggota/delete-all', [\App\Http\Controllers\Admin\ModuleController::class, 'deleteAllAnggota'])->name('admin.anggota.delete-all');
    Route::put('/admin/anggota/{student}/update', [\App\Http\Controllers\Admin\ModuleController::class, 'updateAnggota'])->name('admin.anggota.update');
    Route::post('/admin/anggota/{student}/toggle', [\App\Http\Controllers\Admin\ModuleController::class, 'toggleAnggota'])->name('admin.anggota.toggle');
    Route::delete('/admin/anggota/{student}', [\App\Http\Controllers\Admin\ModuleController::class, 'deleteAnggota'])->name('admin.anggota.delete');

    Route::get('/admin/timeline', [\App\Http\Controllers\Admin\ModuleController::class, 'timeline'])->name('admin.timeline');
    Route::post('/admin/timeline/store', [\App\Http\Controllers\Admin\ModuleController::class, 'storeTimeline'])->name('admin.timeline.store');
    Route::put('/admin/timeline/{timelineEvent}/update', [\App\Http\Controllers\Admin\ModuleController::class, 'updateTimeline'])->name('admin.timeline.update');
    Route::post('/admin/timeline/{timelineEvent}/toggle', [\App\Http\Controllers\Admin\ModuleController::class, 'toggleTimeline'])->name('admin.timeline.toggle');
    Route::delete('/admin/timeline/{timelineEvent}', [\App\Http\Controllers\Admin\ModuleController::class, 'deleteTimeline'])->name('admin.timeline.delete');

    Route::get('/admin/prestasi', function () {
        return view('admin.modules.prestasi', [
            'title' => 'Kelola Prestasi',
            'description' => 'Tambah dan kelola prestasi anggota.',
            'publicRoute' => route('achievement'),
            'publicLabel' => 'Lihat Halaman Prestasi',
            'achievements' => App\Support\AchievementStore::all(),
        ]);
    })->name('admin.prestasi');

    Route::post('/admin/prestasi/store', function (Illuminate\Http\Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => ['required', 'string', 'in:Tingkat Ranting,Tingkat Cabang,Tingkat Jateng,Tingkat Nasional'],
            'year' => 'required|integer|min:2000|max:2100',
            'winner' => 'required|string|max:255',
            'winner_social_link' => 'nullable|url|max:255',
            'description' => 'required|string',
            'image' => 'nullable',
            'image_path' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->input('image_path', $request->input('image', 'images/achievement/prestasi1.jpg'));
        $winnerSocialLink = $request->input('winner_social_link', '');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]+/', '-', strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))) . '.' . $file->getClientOriginalExtension();
            $directory = public_path('images/achievement');

            if (! is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            $file->move($directory, $filename);
            $imagePath = 'images/achievement/' . $filename;
        }

        if (is_string($imagePath) && trim($imagePath) === '') {
            $imagePath = 'images/achievement/prestasi1.jpg';
        }

        $payload = $request->only(['title', 'category', 'year', 'winner', 'description']) + [
            'image' => $imagePath,
            'winner_social_link' => $winnerSocialLink,
        ];

        if ($request->filled('edit_id')) {
            App\Support\AchievementStore::update((int) $request->input('edit_id'), $payload);

            return redirect()->route('admin.prestasi')->with('success', 'Prestasi berhasil diperbarui.');
        }

        App\Support\AchievementStore::add($payload);

        return redirect()->route('admin.prestasi')->with('success', 'Prestasi berhasil ditambahkan.');
    })->name('admin.prestasi.store');

    Route::put('/admin/prestasi/{id}/update', function (Illuminate\Http\Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => ['required', 'string', 'in:Tingkat Ranting,Tingkat Cabang,Tingkat Jateng,Tingkat Nasional'],
            'year' => 'required|integer|min:2000|max:2100',
            'winner' => 'required|string|max:255',
            'winner_social_link' => 'nullable|url|max:255',
            'description' => 'required|string',
            'image' => 'nullable',
            'image_path' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->input('image_path', 'images/achievement/prestasi1.jpg');
        $winnerSocialLink = $request->input('winner_social_link', '');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]+/', '-', strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))) . '.' . $file->getClientOriginalExtension();
            $directory = public_path('images/achievement');

            if (! is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            $file->move($directory, $filename);
            $imagePath = 'images/achievement/' . $filename;
        }

        if (is_string($imagePath) && trim($imagePath) === '') {
            $imagePath = 'images/achievement/prestasi1.jpg';
        }

        App\Support\AchievementStore::update((int) $id, $request->only(['title', 'category', 'year', 'winner', 'description']) + [
            'image' => $imagePath,
            'winner_social_link' => $winnerSocialLink,
        ]);

        return redirect()->route('admin.prestasi')->with('success', 'Prestasi berhasil diperbarui.');
    })->name('admin.prestasi.update');

    Route::post('/admin/prestasi/{id}/duplicate', function ($id) {
        App\Support\AchievementStore::duplicate((int) $id);

        return redirect()->route('admin.prestasi')->with('success', 'Prestasi berhasil diduplikasi.');
    })->name('admin.prestasi.duplicate');

    Route::delete('/admin/prestasi/{id}', function ($id) {
        App\Support\AchievementStore::delete((int) $id);

        return redirect()->route('admin.prestasi')->with('success', 'Prestasi berhasil dihapus.');
    })->name('admin.prestasi.delete');

    Route::get('/admin/downloads', function () {
        return view('admin.section', [
            'title' => 'Kelola File Download',
            'description' => 'Kelola berkas yang dapat diunduh oleh pengguna.',
            'fields' => [
                'Judul berkas',
                'Kategori / tipe file',
                'File upload',
                'Deskripsi singkat',
                'Tanggal publikasi',
            ],
        ]);
    })->name('admin.downloads');

    Route::get('/admin/pendaftaran', function () {
        return view('admin.section', [
            'title' => 'Kelola Pendaftaran',
            'description' => 'Kelola form dan data pendaftaran peserta.',
            'publicRoute' => route('pendaftaran-bantara'),
            'publicLabel' => 'Lihat Halaman Pendaftaran Bantara',
            'fields' => [
                'Jenis pendaftaran',
                'Nama peserta',
                'Golongan',
                'Sekolah / asal',
                'Tanggal lahir',
                'File surat izin',
                'Status verifikasi',
            ],
        ]);
    })->name('admin.pendaftaran');

    Route::get('/admin/users', function () {
        return view('admin.section', [
            'title' => 'Pengguna/Admin',
            'description' => 'Kelola akun pengguna dan hak akses admin.',
            'fields' => [
                'Nama lengkap',
                'Email',
                'Password',
                'Role / hak akses',
                'Status aktif',
            ],
        ]);
    })->name('admin.users');

    Route::get('/admin/settings', function () {
        return view('admin.section', [
            'title' => 'Pengaturan Website',
            'description' => 'Atur konfigurasi umum website dan tampilan publik.',
            'fields' => [
                'Judul website',
                'Deskripsi singkat',
                'Logo situs',
                'Warna brand',
                'Kontak admin',
            ],
        ]);
    })->name('admin.settings');

    Route::get('/admin/comments', function () {
        return view('admin.section', [
            'title' => 'Kelola Komentar',
            'description' => 'Review dan moderasi komentar pengguna.',
            'fields' => [
                'Nama pengirim',
                'Email',
                'Isi komentar',
                'Status moderasi',
                'Tanggal komentar',
                'Balasan admin',
            ],
        ]);
    })->name('admin.comments');
});

require __DIR__.'/settings.php';

use App\Models\PetugasAbsensi;

// Absensi routes (no database required initially)
Route::prefix('absensi')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('absensi.index');

    Route::post('/verify', function (Illuminate\Http\Request $req) {
        $name = trim((string) $req->input('name'));
        $kelas = trim((string) $req->input('kelas'));
        $nta = trim((string) $req->input('nta'));
        $ambalan = trim((string) $req->input('ambalan'));
        $sangga = trim((string) $req->input('sangga'));

        // Simple safety: check fields length
        if (!$name || !$kelas || !$nta || strlen($nta) < 3) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'Data verifikasi tidak valid.');
        }

        $petugas = PetugasAbsensi::query()
            ->whereRaw('LOWER(nta) = ?', [strtolower($nta)])
            ->first();

        if (! $petugas || ! $petugas->is_active) {
            return redirect()->route('absensi.index')->with('absensi_verify_error', 'NTA petugas tidak aktif atau belum terdaftar di daftar admin.');
        }

        session(['absensi_verified' => [
            'name' => $name,
            'kelas' => $kelas,
            'nta' => $nta,
            'ambalan' => $ambalan ?: 'PA',
            'sangga' => $sangga ?: 'Perintis',
        ]]);

        return redirect()->route('absensi.index');
    })->name('absensi.verify');

    Route::post('/forget', function () {
        session()->forget('absensi_verified');
        return redirect()->route('absensi.index');
    })->name('absensi.forget');

    Route::post('/submit', [AttendanceController::class, 'submit'])->name('absensi.submit');
});