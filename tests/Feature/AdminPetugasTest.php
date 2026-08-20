<?php

use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated admin can access absensi page and see petugas summary', function () {
    $admin = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);

    AttendanceRecord::create([
        'user_id' => $admin->id,
        'participant_id' => 1,
        'participant_name' => 'Siswa Tes',
        'participant_kelas' => 'XI IPA 1',
        'participant_ambalan' => 'Putra',
        'status' => 'Hadir',
        'iuran' => '5000',
        'bulan' => 'Agustus',
        'tanggal' => '10',
        'tahun' => '2026',
        'week_label' => 'Minggu ke-2
Agustus 2026',
        'month_key' => '2026-08',
        'year_key' => '2026',
        'record_date' => now()->toDateString(),
        'petugas_name' => 'Abdul',
        'petugas_kelas' => 'XI IPA 2',
        'petugas_nta' => 'NTA12345',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.absensi'));

    $response->assertOk();
    $response->assertSee('Daftar Petugas Absensi');
    $response->assertSee('Abdul');
    $response->assertSee('NTA12345');
});

test('guest is redirected from absensi page to login', function () {
    $response = $this->get(route('admin.absensi'));

    $response->assertRedirect(route('login'));
});
