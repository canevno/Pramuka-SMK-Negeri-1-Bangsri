<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated admin users can visit the dashboard', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('dashboard visitor statistics use real session data from the website', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    DB::table('sessions')->insert([
        [
            'id' => 'visit-session-1',
            'user_id' => null,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0',
            'payload' => json_encode(['page' => '/']),
            'last_activity' => now()->subDays(2)->timestamp,
        ],
        [
            'id' => 'visit-session-2',
            'user_id' => null,
            'ip_address' => '127.0.0.2',
            'user_agent' => 'Mozilla/5.0',
            'payload' => json_encode(['page' => '/news']),
            'last_activity' => now()->subDays(1)->timestamp,
        ],
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk()
        ->assertViewHas('visitorStats', function ($stats) {
            return is_array($stats)
                && count($stats) === 7
                && collect($stats)->sum('count') >= 2;
        });
});

test('dashboard petugas teraktif is based on registered absensi petugas', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $petugasA = \App\Models\PetugasAbsensi::query()->create([
        'nama' => 'Petugas Alpha',
        'nta' => 'NTA-ALPHA',
        'kelas_petugas' => 'XI RPL 1',
        'is_active' => true,
        'is_approved' => true,
        'photo_url' => 'storage/petugas/petugas-alpha.jpg',
    ]);

    $petugasB = \App\Models\PetugasAbsensi::query()->create([
        'nama' => 'Petugas Beta',
        'nta' => 'NTA-BETA',
        'kelas_petugas' => 'XI RPL 2',
        'is_active' => true,
        'is_approved' => true,
    ]);

    \App\Models\AttendanceRecord::query()->create([
        'participant_name' => 'Peserta Test',
        'participant_kelas' => 'XI RPL 1',
        'participant_ambalan' => 'Sangga 1',
        'status' => 'Hadir',
        'bulan' => 'September',
        'tanggal' => '15',
        'tahun' => '2026',
        'petugas_name' => 'Petugas Alpha',
        'petugas_nta' => 'NTA-ALPHA',
        'petugas_kelas' => 'XI RPL 1',
        'record_date' => '2026-09-15',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Petugas Teraktif')
        ->assertSee('Petugas Alpha')
        ->assertSee('Petugas Beta')
        ->assertSee(asset('storage/petugas/petugas-alpha.jpg'));
});

test('dashboard shows an absensi card under the latest registrations', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    \App\Models\AttendanceRecord::query()->create([
        'participant_name' => 'Siswa A',
        'participant_kelas' => 'XI RPL 1',
        'participant_ambalan' => 'Putra',
        'participant_sangga' => 'Sangga Perintis',
        'status' => 'Hadir',
        'bulan' => 'September',
        'tanggal' => '15',
        'tahun' => '2026',
        'petugas_name' => 'Petugas Alpha',
        'petugas_nta' => 'NTA-ALPHA',
        'petugas_kelas' => 'XI RPL 1',
        'record_date' => '2026-09-15',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Absensi')
        ->assertSee('Sub Sangga')
        ->assertSee('Ambalan')
        ->assertSee('Total Siswa Hadir')
        ->assertSee('Bulan')
        ->assertSee('Sangga Perintis')
        ->assertSee('Putra')
        ->assertSee('September');
});

test('dashboard shows the real latest registrations from bantara and laksana', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    \App\Models\BantaraRegistration::query()->create([
        'nama' => 'Budi Santoso',
        'kelas' => 'XI RPL 1',
        'jenis_kelamin' => 'L',
        'rt' => '01',
        'rw' => '02',
        'kecamatan' => 'Bangsri',
        'kabupaten' => 'Jepara',
        'tempat_tanggal_lahir' => 'Jepara, 12-09-2009',
        'motivasi' => 'Ingin belajar lebih banyak',
        'whatsapp' => '081234567890',
        'nomor_orang_tua' => '081234567891',
        'surat_izin_path' => 'pendaftaran-bantara/test.pdf',
        'status_verifikasi' => 'disetujui',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    \App\Models\LaksanaRegistration::query()->create([
        'nama' => 'Dina Pratiwi',
        'nta' => 'NTA-001',
        'kelas' => 'XII RPL 2',
        'jenis_kelamin' => 'P',
        'rt' => '03',
        'rw' => '04',
        'kecamatan' => 'Bangsri',
        'kabupaten' => 'Jepara',
        'tempat_tanggal_lahir' => 'Jepara, 05-07-2008',
        'motivasi' => 'Ingin mengembangkan skill',
        'whatsapp' => '081234567892',
        'nomor_orang_tua' => '081234567893',
        'surat_izin_path' => 'pendaftaran-laksana/test.pdf',
        'status_verifikasi' => 'pending',
        'created_at' => now()->subMinute(),
        'updated_at' => now()->subMinute(),
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('Dina Pratiwi')
        ->assertSee('Bantara')
        ->assertSee('Laksana')
        ->assertSee('Disetujui')
        ->assertSee('Pending')
        ->assertDontSee('Siti Aisyah');
});

test('dashboard shows the latest real posts from admin news', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    \App\Models\Post::query()->create([
        'user_id' => $user->id,
        'title' => 'Latihan Pionering di Hutan Kareta',
        'slug' => 'latihan-pionering-di-hutan-kareta',
        'type' => 'Berita',
        'image_path' => 'images/hero/imagehero1.png',
        'excerpt' => 'Latihan pionering untuk membangun kekompakan dan kreativitas anggota.',
        'content' => 'Isi berita utama yang sebenarnya di admin.',
        'published_at' => now(),
        'is_published' => true,
        'sort_order' => 1,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Berita Terbaru')
        ->assertSee('Latihan Pionering di Hutan Kareta')
        ->assertDontSee('Perkemahan Sabtu-Minggu Gugus Depan');
});

test('home achievement cards display the stored description text', function () {
    \App\Models\Achievement::query()->create([
        'title' => 'Juara 1 Lomba Baris Berbaris',
        'category' => 'Tingkat Cabang',
        'year' => 2026,
        'winner' => 'Fajar',
        'winner_social_link' => '',
        'description' => 'Prestasi ini membuktikan semangat dan disiplin anggota pramuka.',
        'image' => 'images/achievement/prestasi1.jpg',
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Prestasi ini membuktikan semangat dan disiplin anggota pramuka.');
});

test('admin achievement entries can be edited and duplicated', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $achievement = \App\Models\Achievement::query()->create([
        'title' => 'Juara 1 Lomba Pertama',
        'category' => 'Tingkat Cabang',
        'year' => 2025,
        'winner' => 'Rafi',
        'winner_social_link' => '',
        'description' => 'Deskripsi lama',
        'image' => 'images/achievement/prestasi1.jpg',
    ]);

    $this->actingAs($user)
        ->put(route('admin.prestasi.update', $achievement->id), [
            'title' => 'Juara 1 Lomba Diperbarui',
            'category' => 'Tingkat Nasional',
            'year' => 2026,
            'winner' => 'Rafi Updated',
            'winner_social_link' => 'https://instagram.com/rafi',
            'description' => 'Deskripsi baru',
            'image_path' => 'images/achievement/prestasi1.jpg',
        ])
        ->assertRedirect(route('admin.prestasi'))
        ->assertSessionHas('success', 'Prestasi berhasil diperbarui.');

    $this->actingAs($user)
        ->post(route('admin.prestasi.duplicate', $achievement->id))
        ->assertRedirect(route('admin.prestasi'))
        ->assertSessionHas('success', 'Prestasi berhasil diduplikasi.');

    $this->assertDatabaseHas('achievements', [
        'title' => 'Juara 1 Lomba Diperbarui',
        'category' => 'Tingkat Nasional',
        'description' => 'Deskripsi baru',
    ]);

    $this->assertDatabaseCount('achievements', 2);
});