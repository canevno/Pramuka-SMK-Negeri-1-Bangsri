        <?php

        use App\Http\Controllers\AbsensiController;
        use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
        use App\Http\Controllers\Admin\PendaftaranAdminController;
        use App\Http\Controllers\AdminAuthController;
        use App\Http\Controllers\AttendanceController;
        use App\Http\Controllers\BantaraRegistrationController;
        use App\Http\Controllers\DashboardController;
        use App\Http\Controllers\Admin\PetugasController;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Route;

        /*
        |--------------------------------------------------------------------------
        | Web Routes - Frontend Public
        |--------------------------------------------------------------------------
        */

        Route::view('/', 'pages.home')->name('home');
        Route::view('/tentang-kami', 'pages.about')->name('about');
        Route::view('/pengurus-aktif', 'pages.active-board')->name('active-board');
        Route::view('/alumni', 'pages.alumni')->name('alumni');
        Route::view('/prestasi', 'pages.achievement')->name('achievement');
        Route::view('/event', 'pages.event')->name('event');
        Route::view('/artikel', 'pages.article')->name('article');
        Route::get('/admin/absensi/detail-data', [App\Http\Controllers\Admin\AttendanceController::class, 'getDetailData'])->name('admin.absensi.detail-data');
        Route::get('/admin/absensi/export-excel', [App\Http\Controllers\Admin\AttendanceController::class, 'exportExcel'])->name('admin.absensi.export');

        // Route Berita Publik
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

        Route::view('/galeri', 'pages.gallery')->name('gallery');

        /*
        |--------------------------------------------------------------------------
        | Pendaftaran Bantara (Frontend)
        |--------------------------------------------------------------------------
        */
        // Menampilkan form pendaftaran
        Route::get('/pendaftaran-bantara', [BantaraRegistrationController::class, 'index'])->name('pendaftaran-bantara');
        // Memproses pendaftaran & simpan ke database
        Route::post('/pendaftaran-bantara', [BantaraRegistrationController::class, 'store'])->name('pendaftaran-bantara.submit');

        /*
        |--------------------------------------------------------------------------
        | Pendaftaran Laksana (Frontend)
        |--------------------------------------------------------------------------
        */
        Route::view('/pendaftaran-laksana', 'pages.pendaftaran-laksana')->name('pendaftaran-laksana');
        Route::post('/pendaftaran-laksana', function (Request $request) {
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

        /*
        |--------------------------------------------------------------------------
        | Autentikasi Admin
        |--------------------------------------------------------------------------
        */
        Route::redirect('/login', '/admin/login');
        Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/admin/login', [AdminAuthController::class, 'login']);
        Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

        /*
        |--------------------------------------------------------------------------
        | Panel Admin (Protected Middleware)
        |--------------------------------------------------------------------------
        */
        Route::middleware(['auth', 'verified', \App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
            
            // Dashboard Utama Admin
            Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');

            // Section Berita
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

            // Section Galeri
            Route::get('/admin/gallery', function () {
                return view('admin.section', [
                    'title' => 'Kelola Galeri',
                    'description' => 'Kelola foto dan galeri acara Pramuka.',
                    'publicRoute' => route('gallery'),
                    'publicLabel' => 'Lihat Halaman Galeri',
                    'fields' => [
                        'Judul foto / album',
                        'Kategori galeri',
                        'File gambar',
                        'Deskripsi singkat',
                        'Tag acara',
                        'Tanggal pengambilan',
                    ],
                ]);
            })->name('admin.gallery');

            // Section Agenda
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

            // Section Absensi
            // Ensure explicit export routes are defined before the wildcard {id}
            // Export by session id
            Route::get('/admin/absensi/{id}/export-word', [AdminAttendanceController::class, 'exportWord'])->name('admin.absensi.exportWord');
            // Export by query params (date, kelas, ambalan) - used by modal JS fallback
            Route::get('/admin/absensi/export-word', [AdminAttendanceController::class, 'exportWord'])->name('admin.absensi.exportWord.query');
            Route::get('/admin/absensi/export', [AdminAttendanceController::class, 'exportExcel'])->name('admin.absensi.export');
            Route::get('/admin/absensi', [AdminAttendanceController::class, 'index'])->name('admin.absensi');
            Route::get('/admin/absensi/{id}', [AdminAttendanceController::class, 'show'])->name('admin.absensi.show');

            // Section Pendaftaran Laksana
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

            // Section Pembina
            Route::get('/admin/pembina', function () {
                return view('admin.section', [
                    'title' => 'Kelola Pembina',
                    'description' => 'Kelola data pembina dan penanggung jawab acara.',
                    'fields' => [
                        'Nama pembina',
                        'Jabatan / peran',
                        'Foto profil',
                        'Kontak email / telepon',
                        'Ringkasan pengalaman',
                    ],
                ]);
            })->name('admin.pembina');

            // Section Anggota
            Route::get('/admin/anggota', function () {
                return view('admin.section', [
                    'title' => 'Kelola Anggota',
                    'description' => 'Lihat dan kelola anggota Pramuka yang terdaftar.',
                    'publicRoute' => route('active-board'),
                    'publicLabel' => 'Lihat Halaman Anggota',
                    'fields' => [
                        'Nama lengkap',
                        'Golongan',
                        'Tingkat / kelas',
                        'Email / nomor HP',
                        'Foto profil',
                        'Status keaktifan',
                    ],
                ]);
            })->name('admin.anggota');

            // Section Prestasi
            Route::get('/admin/prestasi', function () {
                return view('admin.section', [
                    'title' => 'Kelola Prestasi',
                    'description' => 'Tambah dan kelola prestasi anggota.',
                    'publicRoute' => route('achievement'),
                    'publicLabel' => 'Lihat Halaman Prestasi',
                    'fields' => [
                        'Judul prestasi',
                        'Tingkat / kategori',
                        'Tahun',
                        'Deskripsi pencapaian',
                        'Nama peserta / regu',
                        'Bukti foto / sertifikat',
                    ],
                ]);
            })->name('admin.prestasi');

            // Section File Downloads
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

            /*
            |--------------------------------------------------------------------------
            | Kelola Pendaftaran Bantara (Admin Terhubung ke Database)
            |--------------------------------------------------------------------------
            */
            // Menampilkan tabel pendaftar di dashboard admin
            Route::get('/admin/pendaftaran', [PendaftaranAdminController::class, 'index'])->name('admin.pendaftaran');
            // Memperbarui status verifikasi (Pending/Disetujui/Ditolak)
            Route::patch('/admin/pendaftaran/{id}/status', [PendaftaranAdminController::class, 'updateStatus'])->name('admin.pendaftaran.update-status');
            // Menghapus data pendaftar & berkasnya
            Route::delete('/admin/pendaftaran/{id}', [PendaftaranAdminController::class, 'destroy'])->name('admin.pendaftaran.destroy');

            // Section User & Management
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

            // Section Settings
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

            // Section Komentar
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

            // Store new petugas (from modal form)
            // Toggle Aktif/Nonaktif Petugas
            Route::patch('/admin/petugas/{id}/toggle', [App\Http\Controllers\Admin\PetugasController::class, 'toggleStatus'])->name('admin.petugas.toggle');

            // Tandai Notifikasi Sudah Dibaca
            Route::post('/admin/notifications/read-all', [App\Http\Controllers\Admin\PetugasController::class, 'markAllNotificationsRead'])->name('admin.notifications.readAll');
            // Fetch latest notifications (JSON) untuk polling
            Route::get('/admin/notifications/fetch', [App\Http\Controllers\Admin\PetugasController::class, 'fetchNotifications'])->name('admin.notifications.fetch');
            // Mark single notification read
            Route::post('/admin/notifications/{id}/read', [App\Http\Controllers\Admin\PetugasController::class, 'markNotificationRead'])->name('admin.notifications.read');

            Route::post('/admin/petugas', [PetugasController::class, 'storePetugas'])->name('admin.petugas.store');
        });

        require __DIR__.'/settings.php';

        /*
        |--------------------------------------------------------------------------
        | System Absensi (Fitur Luar Admin)
        |--------------------------------------------------------------------------
        */
        Route::prefix('absensi')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('absensi.index');
            Route::post('/verify', [AbsensiController::class, 'verify'])->name('absensi.verify');
            // Redirect otomatis jika /absensi/verify diakses lewat GET / di-refresh
            Route::get('/verify', function () {
                return redirect()->to('/absensi'); // Ubah '/absensi' sesuai URL halaman form awal Anda
            });
            Route::get('/lanjut', [AbsensiController::class, 'showAbsensiForm'])->name('absensi.lanjut');

            Route::post('/forget', function () {
                session()->forget('absensi_verified');
                return redirect()->route('absensi.index');
            })->name('absensi.forget');

            Route::post('/submit', [AttendanceController::class, 'submit'])->name('absensi.submit');
        });