<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\PendaftaranAdminController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Public Pages Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');
Route::view('/tentang-kami', 'pages.about')->name('about');
Route::view('/visi-misi', 'pages.visi-misi')->name('visi-misi');
Route::view('/ambalan', 'pages.ambalan')->name('ambalan');
Route::view('/pengurus-aktif', 'pages.active-board')->name('active-board');
Route::view('/alumni', 'pages.alumni')->name('alumni');
Route::view('/prestasi', 'pages.achievement')->name('achievement');
Route::view('/event', 'pages.event')->name('event');
Route::view('/artikel', 'pages.article')->name('article');
Route::view('/galeri', 'pages.gallery')->name('gallery');
Route::view('/kontak', 'pages.contact')->name('contact');

// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Berita Dynamic Page
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

// Pendaftaran Bantara & Laksana (Public)
Route::view('/pendaftaran-bantara', 'pages.pendaftaran-bantara')->name('pendaftaran-bantara');
Route::post('/pendaftaran-bantara', function (Request $request) {
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

/*
|--------------------------------------------------------------------------
| Public Absensi Routes
|--------------------------------------------------------------------------
*/

Route::prefix('absensi')->name('absensi.')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
    Route::post('/verify', [AttendanceController::class, 'verifyPetugas'])->name('verify');
    Route::post('/submit', [AttendanceController::class, 'submit'])->name('submit');
    Route::post('/logout-petugas', [AttendanceController::class, 'logoutPetugas'])->name('logoutPetugas');
    Route::post('/logout', [AttendanceController::class, 'logoutPetugas'])->name('logout_petugas'); // Alias fleksibel

    Route::post('/forget', function () {
        session()->forget(['absensi_verified', 'absensi_petugas_id']);
        return redirect()->route('absensi.index');
    })->name('forget');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/settings.php';

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login'); // Fallback untuk middleware auth
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Area Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', \App\Http\Middleware\EnsureUserIsAdmin::class])
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('admin.absensi');
        })->name('dashboard');

        // Attendance Admin Routes
        Route::prefix('absensi')->group(function () {
            Route::get('/', [AdminAttendanceController::class, 'adminIndex'])->name('absensi');
            Route::post('/', [AdminAttendanceController::class, 'store'])->name('absensi.store');
            
            Route::get('/detail-data', [AdminAttendanceController::class, 'getDetailData'])->name('absensi.detail-data');
            Route::get('/detail', [AdminAttendanceController::class, 'getDetailData'])->name('absensi.detail');
            
            Route::get('/export', [AdminAttendanceController::class, 'exportExcel'])->name('absensi.export');
            Route::get('/export-word/{id?}', [AdminAttendanceController::class, 'exportWord'])->name('absensi.exportWord');
            Route::get('/{id}', [AdminAttendanceController::class, 'show'])->name('absensi.show');
        });

        // Module Routes
        Route::get('/news', [ModuleController::class, 'news'])->name('news');
        Route::get('/gallery', [ModuleController::class, 'gallery'])->name('gallery');
        Route::get('/agenda', [ModuleController::class, 'agenda'])->name('agenda');
        Route::get('/pendaftaran-laksana', [ModuleController::class, 'pendaftaranLaksana'])->name('pendaftaran-laksana');
        Route::get('/prestasi', [ModuleController::class, 'prestasi'])->name('prestasi');
        Route::get('/pembina', [ModuleController::class, 'pembina'])->name('pembina');
        Route::get('/anggota', [ModuleController::class, 'anggota'])->name('anggota');
        Route::get('/comments', [ModuleController::class, 'comments'])->name('comments');
        Route::get('/users', [ModuleController::class, 'users'])->name('users');
        Route::get('/settings', [ModuleController::class, 'settings'])->name('settings');

        // Registration Admin Management
        Route::prefix('pendaftaran')->group(function () {
            Route::get('/', [PendaftaranAdminController::class, 'index'])->name('pendaftaran');
            Route::post('/{id}/status', [PendaftaranAdminController::class, 'updateStatus'])->name('pendaftaran.update-status');
            Route::get('/surat/{id}', [PendaftaranAdminController::class, 'showSurat'])->name('pendaftaran.showSurat');
            Route::get('/surat/download/{id}', [PendaftaranAdminController::class, 'downloadSurat'])->name('pendaftaran.surat.download');
            Route::delete('/{id}', [PendaftaranAdminController::class, 'destroy'])->name('pendaftaran.destroy');
        });

        // Petugas & Notifications
        Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas');
        Route::post('/petugas', [PetugasController::class, 'storePetugas'])->name('petugas.store');
        Route::post('/petugas/{id}/toggle', [PetugasController::class, 'toggleStatus'])->name('petugas.toggle');
        
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::post('/read-all', [PetugasController::class, 'markAllNotificationsRead'])->name('readAll');
            Route::get('/fetch', [PetugasController::class, 'fetchNotifications'])->name('fetch');
            Route::post('/{id}/read', [PetugasController::class, 'markNotificationRead'])->name('read');
        });

    });