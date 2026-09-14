<?php

use App\Http\Controllers\AttendanceController;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');

Route::view('/tentang-kami', 'pages.about')->name('about');
Route::view('/visi-misi', 'pages.visi-misi')->name('visi-misi');
Route::view('/ambalan', 'pages.ambalan')->name('ambalan');
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
Route::view('/dewan-kehormatan', 'pages.dewan-kehormatan')->name('dewan-kehormatan');
Route::view('/dewan-ambalan', 'pages.dewan-ambalan')->name('dewan-ambalan');

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

Route::view('/alumni', 'pages.alumni')->name('alumni');

Route::redirect('/prestasi', '/#prestasi')->name('achievement');
Route::view('/prestasi/ranting', 'pages.prestasi.ranting')->name('prestasi.ranting');
Route::view('/prestasi/cabang', 'pages.prestasi.cabang')->name('prestasi.cabang');
Route::view('/prestasi/jateng', 'pages.prestasi.jateng')->name('prestasi.jateng');
Route::view('/prestasi/nasional', 'pages.prestasi.nasional')->name('prestasi.nasional');

Route::view('/event', 'pages.event')->name('event');

Route::view('/artikel', 'pages.article')->name('article');

Route::get('/berita', function () {
    $templateNews = [
        ['category' => 'Sosial', 'title' => 'Pramuka Peduli Lingkungan Pantai', 'date' => 'Januari 8, 2024', 'description' => 'Aksi membersihkan sampah plastik pantai Bangsri sebagai bentuk pengabdian.', 'image' => 'images/hero/imagehero1.png', 'alt' => 'Pramuka Peduli Lingkungan Pantai'],
        ['category' => 'Camping', 'title' => 'Kemping Karakter di Hutan Kareta', 'date' => 'Januari 8, 2024', 'description' => 'Perkemahan tiga hari memperkuat kemandirian, kerja tim, dan ketahanan fisik.', 'image' => 'images/hero/imagehero.png', 'alt' => 'Kemping Karakter di Hutan Kareta'],
        ['category' => 'Budaya', 'title' => 'Gelar Seni Budaya Nusantara', 'date' => 'Januari 8, 2024', 'description' => 'Pertunjukan seni daerah memadukan tradisi dan kreativitas Pramuka.', 'image' => 'images/logokegiatan1.png', 'alt' => 'Gelar Seni Budaya Nusantara'],
        ['category' => 'Skills', 'title' => 'Latihan Navigasi Darat Menantang', 'date' => 'Januari 8, 2024', 'description' => 'Menguji orientasi lapangan dengan kompas dan peta di medan nyata.', 'image' => 'images/logos/smklogo.png', 'alt' => 'Latihan Navigasi Darat Menantang'],
        ['category' => 'Event', 'title' => 'Pertemuan Alumni dan Prestasi', 'date' => 'Januari 8, 2024', 'description' => 'Forum alumni merayakan capaian anggota dan memperkuat koneksi Pramuka.', 'image' => 'images/hero/imagehero.png', 'alt' => 'Pertemuan Alumni dan Prestasi'],
    ];

    $newsItems = [];
    foreach (range(1, 6) as $row) {
        foreach ($templateNews as $item) {
            $newsItems[] = array_merge($item, [
                'title' => $item['title'] . ' #' . $row,
                'description' => $item['description'],
            ]);
        }
    }

    return view('pages.news', compact('newsItems'));
})->name('news');

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
        ['title' => 'Tentang Kami', 'route' => route('about'), 'keywords' => 'tentang kami sejarah profil'],
        ['title' => 'Visi & Misi', 'route' => route('visi-misi'), 'keywords' => 'visi misi tujuan program'],
        ['title' => 'Ambalan', 'route' => route('ambalan'), 'keywords' => 'ambalan gugus pramuka satuan'],
        ['title' => 'Berita', 'route' => route('news'), 'keywords' => 'berita informasi kegiatan'],
        ['title' => 'Galeri', 'route' => route('gallery'), 'keywords' => 'galeri foto dokumentasi acara'],
        ['title' => 'Event', 'route' => route('event'), 'keywords' => 'event agenda kegiatan'],
        ['title' => 'Prestasi', 'route' => route('achievement'), 'keywords' => 'prestasi juara lomba'],
        ['title' => 'Pendaftaran Bantara', 'route' => route('pendaftaran-bantara'), 'keywords' => 'bantara pendaftaran calon anggota'],
        ['title' => 'Pendaftaran Laksana', 'route' => route('pendaftaran-laksana'), 'keywords' => 'laksana pendaftaran calon anggota'],
        ['title' => 'Kontak', 'route' => route('contact'), 'keywords' => 'kontak hubungi cs'],
    ];

    $results = [];

    if ($q !== '') {
        $needle = mb_strtolower($q);

        foreach ($pages as $page) {
            $haystack = mb_strtolower($page['title'] . ' ' . $page['keywords']);

            if (str_contains($haystack, $needle)) {
                $results[] = $page;
            }
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

use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;

// Redirect default login route to admin login
Route::redirect('/login', '/admin/login');

// Admin auth routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

Route::middleware(['auth', 'verified', \App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
    // Admin panel is mounted at /admin to keep it separate from public site
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/news', function () {
        return view('admin.section', [
            'title' => 'Kelola Berita',
            'description' => 'Tambahkan, edit, dan hapus berita yang tampil di website.',
            'publicRoute' => route('news'),
            'publicLabel' => 'Lihat Halaman Berita',
            'fields' => [
                'Judul berita',
                'Kategori berita',
                'Ringkasan / excerpt',
                'Konten utama',
                'Gambar utama',
                'Tanggal publikasi',
                'Status: draft / terbit',
            ],
        ]);
    })->name('admin.news');

    Route::get('/admin/gallery', [ModuleController::class, 'gallery'])->name('admin.gallery');
    Route::post('/admin/gallery/store', [ModuleController::class, 'storeGallery'])->name('admin.gallery.store');
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
    Route::post('/admin/pembina/{pembina}/toggle', [\App\Http\Controllers\Admin\ModuleController::class, 'togglePembina'])->name('admin.pembina.toggle');
    Route::delete('/admin/pembina/{pembina}', [\App\Http\Controllers\Admin\ModuleController::class, 'deletePembina'])->name('admin.pembina.delete');

    Route::get('/admin/anggota', [\App\Http\Controllers\Admin\ModuleController::class, 'anggota'])->name('admin.anggota');
    Route::post('/admin/anggota/store', [\App\Http\Controllers\Admin\ModuleController::class, 'storeAnggota'])->name('admin.anggota.store');
    Route::delete('/admin/anggota/delete-all', [\App\Http\Controllers\Admin\ModuleController::class, 'deleteAllAnggota'])->name('admin.anggota.delete-all');
    Route::put('/admin/anggota/{student}/update', [\App\Http\Controllers\Admin\ModuleController::class, 'updateAnggota'])->name('admin.anggota.update');
    Route::post('/admin/anggota/{student}/toggle', [\App\Http\Controllers\Admin\ModuleController::class, 'toggleAnggota'])->name('admin.anggota.toggle');
    Route::delete('/admin/anggota/{student}', [\App\Http\Controllers\Admin\ModuleController::class, 'deleteAnggota'])->name('admin.anggota.delete');

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
            'category' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2100',
            'winner' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:255',
        ]);

        App\Support\AchievementStore::add($request->only(['title', 'category', 'year', 'winner', 'description', 'image']));

        return redirect()->route('admin.prestasi')->with('success', 'Prestasi berhasil ditambahkan.');
    })->name('admin.prestasi.store');

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