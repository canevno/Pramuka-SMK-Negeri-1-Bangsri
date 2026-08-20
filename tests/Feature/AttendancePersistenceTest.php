<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('absensi submissions are stored in the database', function () {
    $response = $this->withSession([
        'absensi_verified' => [
            'name' => 'Test Petugas',
            'kelas' => 'X PPLG 1',
            'nta' => '12345',
        ],
    ])->post('/absensi/submit', [
        'status' => [1 => 'Hadir'],
        'participant_name' => [1 => 'Test Peserta'],
        'participant_kelas' => 'X PPLG 1',
        'participant_ambalan' => 'Putra',
        'iuran' => [1 => 'Lunas'],
        'bulan' => 'Agustus',
        'tanggal' => '06',
        'tahun' => '2026',
    ]);

    $response->assertRedirect('/absensi');
    $response->assertSessionHas('absensi_success');

    $this->assertDatabaseHas('attendance_records', [
        'participant_name' => 'Test Peserta',
        'participant_ambalan' => 'Putra',
        'status' => 'Hadir',
        'iuran' => 'Lunas',
        'petugas_name' => 'Test Petugas',
    ]);
});
