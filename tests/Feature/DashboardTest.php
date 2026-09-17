<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

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