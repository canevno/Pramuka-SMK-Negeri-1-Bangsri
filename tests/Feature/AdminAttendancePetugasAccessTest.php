<?php

use App\Models\AttendanceRecord;
use App\Models\User;

it('admin can access the attendance and petugas management screens', function () {
    $user = User::factory()->create([
        'name' => 'Admin Absensi',
        'email' => 'admin.absensi@example.com',
        'is_admin' => true,
    ]);

    AttendanceRecord::query()->create([
        'participant_name' => 'Raisa Pramudya',
        'participant_kelas' => 'X PPLG 1',
        'participant_ambalan' => 'Putra',
        'participant_sangga' => 'Perintis 1',
        'status' => 'Hadir',
        'iuran' => 'Membayar',
        'iuran_amount' => 2000,
        'record_date' => '2026-09-08',
        'petugas_name' => 'Petugas Uji',
        'petugas_kelas' => 'XI RPL',
        'petugas_nta' => '12345',
        'bulan' => 'September',
        'tanggal' => '08',
        'tahun' => '2026',
        'week_label' => 'Minggu 36 September 2026',
        'month_key' => '09-2026',
        'year_key' => '2026',
    ]);

    AttendanceRecord::query()->create([
        'participant_name' => 'Rian Pratama',
        'participant_kelas' => 'X PPLG 1',
        'participant_ambalan' => 'Putra',
        'participant_sangga' => 'Perintis 2',
        'status' => 'Hadir',
        'iuran' => 'Membayar',
        'iuran_amount' => 2000,
        'record_date' => '2026-09-08',
        'petugas_name' => 'Petugas Uji',
        'petugas_kelas' => 'XI RPL',
        'petugas_nta' => '12345',
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
        ->assertSee('Rekam Absensi Terbaru')
        ->assertSee('No')
        ->assertSee('Sangga')
        ->assertSee('Ambalan')
        ->assertSee('Petugas')
        ->assertSee('Tanggal')
        ->assertSee('Minggu-ke')
        ->assertSee('Detail')
        ->assertViewHas('petugasSummary', function ($summary) {
            return collect($summary)->first()['total_records'] === 1;
        });

    $this->actingAs($user)
        ->get(route('admin.petugas'))
        ->assertOk()
        ->assertSee('Tambah Petugas');

    $this->actingAs($user)
        ->post(route('admin.petugas.store'), [
            'nama' => 'Petugas Baru',
            'nta' => 'NTA-NEW-001',
            'kelas_petugas' => 'XI RPL 2',
            'jenis_kelamin' => 'L',
        ])
        ->assertRedirect(route('admin.petugas'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('petugas_absensis', [
        'nama' => 'Petugas Baru',
        'nta' => 'NTA-NEW-001',
        'kelas_petugas' => 'XI RPL 2',
    ]);

    $this->actingAs($user)
        ->get(route('admin.absensi.detail', [
            'record_date' => '2026-09-08',
            'participant_kelas' => 'X PPLG 1',
            'participant_ambalan' => 'Putra',
            'petugas_name' => 'Petugas Uji',
        ]))
        ->assertOk()
        ->assertSee('Nama Lengkap')
        ->assertSee('Kelas Asal')
        ->assertSee('Ambalan')
        ->assertSee('Sangga')
        ->assertSee('Keterangan')
        ->assertSee('Iuran');

    $this->actingAs($user)
        ->get(route('admin.absensi.export.excel', [
            'record_date' => '2026-09-08',
            'participant_kelas' => 'X PPLG 1',
            'participant_ambalan' => 'Putra',
            'petugas_name' => 'Petugas Uji',
        ]))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    $this->actingAs($user)
        ->get(route('admin.absensi.export.pdf', [
            'record_date' => '2026-09-08',
            'participant_kelas' => 'X PPLG 1',
            'participant_ambalan' => 'Putra',
            'petugas_name' => 'Petugas Uji',
        ]))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');
});
