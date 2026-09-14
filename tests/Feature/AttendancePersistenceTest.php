<?php

use App\Models\PetugasAbsensi;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('absensi verification stores ambalan and sangga and submissions reach the database', function () {
    PetugasAbsensi::query()->create([
        'nama' => 'Test Petugas',
        'nta' => '12345',
        'kelas_petugas' => 'X PPLG 1',
        'is_active' => true,
        'is_approved' => true,
        'status' => 'Aktif',
    ]);

    $verifyResponse = $this->post('/absensi/verify', [
        'name' => 'Test Petugas',
        'kelas' => 'X PPLG 1',
        'nta' => '12345',
        'ambalan' => 'PA',
        'sangga' => 'Perintis',
    ]);

    $verifyResponse->assertRedirect('/absensi');
    $this->assertSame('Test Petugas', session('absensi_verified.name'));
    $this->assertSame('PA', session('absensi_verified.ambalan'));
    $this->assertSame('Perintis', session('absensi_verified.sangga'));

    $response = $this->withSession([
        'absensi_verified' => [
            'name' => 'Test Petugas',
            'kelas' => 'X PPLG 1',
            'nta' => '12345',
            'ambalan' => 'PA',
            'sangga' => 'Perintis',
        ],
    ])->post('/absensi/submit', [
        'status' => [1 => 'Hadir'],
        'participant_name' => [1 => 'Test Peserta'],
        'participant_kelas' => [1 => 'X PPLG 1'],
        'participant_ambalan' => [1 => 'PA'],
        'participant_sangga' => [1 => 'Perintis 1'],
        'iuran' => [1 => 'Lunas'],
        'bulan' => 'Agustus',
        'tanggal' => '06',
        'tahun' => '2026',
    ]);

    $response->assertRedirect('/absensi');
    $response->assertSessionHas('absensi_success');

    $this->assertDatabaseHas('attendance_records', [
        'participant_name' => 'Test Peserta',
        'participant_ambalan' => 'PA',
        'participant_sangga' => 'Perintis 1',
        'status' => 'Hadir',
        'iuran' => 'Lunas',
        'petugas_name' => 'Test Petugas',
    ]);
});

test('absensi verification blocks unregistered or inactive petugas nta', function () {
    PetugasAbsensi::query()->create([
        'nama' => 'Petugas Non Aktif',
        'nta' => 'NTA-NON-AKTIF',
        'kelas_petugas' => 'XII RPL 1',
        'is_active' => false,
        'is_approved' => true,
        'status' => 'Non-Aktif',
    ]);

    $inactiveResponse = $this->from('/absensi')->post('/absensi/verify', [
        'name' => 'Petugas Non Aktif',
        'kelas' => 'XII RPL 1',
        'nta' => 'NTA-NON-AKTIF',
        'ambalan' => 'PA',
        'sangga' => 'Perintis',
    ]);

    $inactiveResponse->assertRedirect('/absensi');
    $inactiveResponse->assertSessionHas('absensi_verify_error', 'NTA petugas tidak aktif atau belum terdaftar di daftar admin.');
    $this->assertFalse(session()->has('absensi_verified'));

    $unregisteredResponse = $this->from('/absensi')->post('/absensi/verify', [
        'name' => 'Petugas Baru',
        'kelas' => 'XI RPL 2',
        'nta' => 'NTA-BELUM-TERDAFTAR',
        'ambalan' => 'PI',
        'sangga' => 'Penegas',
    ]);

    $unregisteredResponse->assertRedirect('/absensi');
    $unregisteredResponse->assertSessionHas('absensi_verify_error', 'NTA petugas tidak aktif atau belum terdaftar di daftar admin.');
    $this->assertFalse(session()->has('absensi_verified'));
});

test('admin pages use the registered active status for petugas', function () {
    $user = \App\Models\User::factory()->create([
        'email' => 'admin@example.com',
        'is_admin' => true,
    ]);

    PetugasAbsensi::query()->create([
        'nama' => 'Petugas Inaktif',
        'nta' => 'NTA-INACTIVE-1',
        'kelas_petugas' => 'XII RPL 1',
        'is_active' => false,
        'is_approved' => true,
        'status' => 'Non-Aktif',
    ]);

    \App\Models\AttendanceRecord::query()->create([
        'participant_name' => 'Siswa 1',
        'participant_kelas' => 'X PPLG 1',
        'participant_ambalan' => 'PA',
        'participant_sangga' => 'Perintis 1',
        'status' => 'Hadir',
        'iuran' => 'Lunas',
        'iuran_amount' => 2000,
        'record_date' => '2026-09-08',
        'petugas_name' => 'Petugas Inaktif',
        'petugas_kelas' => 'XII RPL 1',
        'petugas_nta' => 'NTA-INACTIVE-1',
        'bulan' => 'September',
        'tanggal' => '08',
        'tahun' => '2026',
        'week_label' => 'Minggu 36 September 2026',
        'month_key' => '09-2026',
        'year_key' => '2026',
    ]);

    $this->actingAs($user)
        ->get(route('admin.absensi'))
        ->assertOk()
        ->assertViewHas('petugasSummary', function ($summary) {
            $record = collect($summary)->first();

            return $record['status'] === 'Non-Aktif';
        });

    $this->actingAs($user)
        ->get(route('admin.petugas'))
        ->assertOk()
        ->assertSee('Non-Aktif');
});

test('admin absensi summary excludes petugas removed from the admin petugas list', function () {
    $user = \App\Models\User::factory()->create([
        'email' => 'admin-absensi-summary@example.com',
        'is_admin' => true,
    ]);

    \App\Models\AttendanceRecord::query()->create([
        'participant_name' => 'Siswa 2',
        'participant_kelas' => 'X PPLG 1',
        'participant_ambalan' => 'PA',
        'participant_sangga' => 'Perintis 1',
        'status' => 'Hadir',
        'iuran' => 'Lunas',
        'iuran_amount' => 2000,
        'record_date' => '2026-09-09',
        'petugas_name' => 'Petugas Sudah Dihapus',
        'petugas_kelas' => 'XII RPL 1',
        'petugas_nta' => 'NTA-REMOVED-9',
        'bulan' => 'September',
        'tanggal' => '09',
        'tahun' => '2026',
        'week_label' => 'Minggu 36 September 2026',
        'month_key' => '09-2026',
        'year_key' => '2026',
    ]);

    $this->actingAs($user)
        ->get(route('admin.absensi'))
        ->assertOk()
        ->assertViewHas('petugasSummary', function ($summary) {
            return collect($summary)->every(fn ($item) => $item['nta'] !== 'NTA-REMOVED-9');
        });
});

test('admin absorption detail exports produce non-empty excel and pdf files', function () {
    $user = \App\Models\User::factory()->create([
        'email' => 'admin-export@example.com',
        'is_admin' => true,
    ]);

    \App\Models\AttendanceRecord::query()->create([
        'participant_name' => 'Siswa Export',
        'participant_kelas' => 'X PPLG 1',
        'participant_ambalan' => 'PA',
        'participant_sangga' => 'Perintis 1',
        'status' => 'Hadir',
        'iuran' => 'Lunas',
        'iuran_amount' => 2000,
        'record_date' => '2026-09-10',
        'petugas_name' => 'Petugas Valid',
        'petugas_kelas' => 'XI RPL',
        'petugas_nta' => 'NTA-VALID-1',
        'bulan' => 'September',
        'tanggal' => '10',
        'tahun' => '2026',
        'week_label' => 'Minggu 37 September 2026',
        'month_key' => '09-2026',
        'year_key' => '2026',
    ]);

    $params = [
        'record_date' => '2026-09-10',
        'participant_kelas' => 'X PPLG 1',
        'participant_ambalan' => 'PA',
        'petugas_name' => 'Petugas Valid',
    ];

    $excel = $this->actingAs($user)
        ->get(route('admin.absensi.export.excel', $params));

    $excel->assertOk()
        ->assertDownload('detail-absensi-2026-09-10-PA-petugas-valid.xlsx')
        ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    $pdf = $this->actingAs($user)
        ->get(route('admin.absensi.export.pdf', $params));

    $pdf->assertOk()
        ->assertDownload('detail-absensi-2026-09-10.pdf')
        ->assertHeader('Content-Type', 'application/pdf');
});
