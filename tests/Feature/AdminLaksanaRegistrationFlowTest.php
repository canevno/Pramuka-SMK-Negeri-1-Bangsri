<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

it('public laksana registration saves data to the database', function () {
    $response = $this->post(route('pendaftaran-laksana.submit'), [
        'nama' => 'Dewi Lestari',
        'nta' => '123456',
        'kelas' => 'XI TKJ 2',
        'jenis_kelamin' => 'Perempuan',
        'rt' => '02',
        'rw' => '04',
        'kecamatan' => 'Bangsri',
        'kabupaten' => 'Jepara',
        'tempat_tanggal_lahir' => 'Jepara, 18 Agustus 2009',
        'motivasi' => 'Saya ingin menambah kemampuan kepemimpinan.',
        'whatsapp' => '081234567894',
        'nomor_orang_tua' => '081234567895',
        'surat_izin' => UploadedFile::fake()->create('surat-laksana.pdf', 200, 'application/pdf'),
    ]);

    $response->assertRedirect(route('pendaftaran-laksana'));
    $this->assertDatabaseHas('laksana_registrations', [
        'nama' => 'Dewi Lestari',
        'nta' => '123456',
        'kelas' => 'XI TKJ 2',
        'jenis_kelamin' => 'P',
        'whatsapp' => '081234567894',
        'status_verifikasi' => 'pending',
    ]);
});

it('admin can view and update laksana registration status', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $registration = \App\Models\LaksanaRegistration::query()->create([
        'nama' => 'Agus Santoso',
        'nta' => '654321',
        'kelas' => 'XI RPL 1',
        'jenis_kelamin' => 'L',
        'rt' => '05',
        'rw' => '07',
        'kecamatan' => 'Bangsri',
        'kabupaten' => 'Jepara',
        'tempat_tanggal_lahir' => 'Jepara, 02 Februari 2009',
        'motivasi' => 'Saya ingin melanjutkan pengembangan diri.',
        'whatsapp' => '081234567896',
        'nomor_orang_tua' => '081234567897',
        'surat_izin_path' => 'pendaftaran-laksana/surat.pdf',
        'status_verifikasi' => 'pending',
    ]);

    $this->get(route('admin.pendaftaran-laksana'))
        ->assertOk()
        ->assertSee('Daftar Pendaftar Laksana');

    $this->patch(route('admin.pendaftaran-laksana.updateStatus', $registration), [
        'status' => 'approved',
    ])->assertRedirect();

    $this->assertDatabaseHas('laksana_registrations', [
        'id' => $registration->id,
        'status_verifikasi' => 'disetujui',
    ]);
});
