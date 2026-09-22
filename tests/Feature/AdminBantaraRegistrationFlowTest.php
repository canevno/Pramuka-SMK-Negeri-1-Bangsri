<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

it('public bantara registration saves data to the database', function () {
    $response = $this->post(route('pendaftaran-bantara.submit'), [
        'nama' => 'Rizki Pratama',
        'kelas' => 'X PPLG 1',
        'jenis_kelamin' => 'Laki-laki',
        'rt' => '01',
        'rw' => '02',
        'kecamatan' => 'Bangsri',
        'kabupaten' => 'Jepara',
        'tempat_tanggal_lahir' => 'Jepara, 12 Maret 2010',
        'motivasi' => 'Saya ingin belajar disiplin dan kemandirian.',
        'whatsapp' => '081234567890',
        'nomor_orang_tua' => '081234567891',
        'surat_izin' => UploadedFile::fake()->create('surat-izin.pdf', 200, 'application/pdf'),
    ]);

    $response->assertRedirect(route('pendaftaran-bantara'));
    $this->assertDatabaseHas('bantara_registrations', [
        'nama' => 'Rizki Pratama',
        'kelas' => 'X PPLG 1',
        'jenis_kelamin' => 'L',
        'whatsapp' => '081234567890',
        'status_verifikasi' => 'pending',
    ]);
});

it('admin can view and update bantara registration status', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $registration = \App\Models\BantaraRegistration::query()->create([
        'nama' => 'Sinta Wulandari',
        'kelas' => 'X TKJ 2',
        'jenis_kelamin' => 'P',
        'rt' => '03',
        'rw' => '05',
        'kecamatan' => 'Bangsri',
        'kabupaten' => 'Jepara',
        'tempat_tanggal_lahir' => 'Jepara, 05 Juli 2010',
        'motivasi' => 'Saya ingin menambah pengalaman.',
        'whatsapp' => '081234567892',
        'nomor_orang_tua' => '081234567893',
        'surat_izin_path' => 'pendaftaran-bantara/surat.pdf',
        'status_verifikasi' => 'pending',
    ]);

    $this->get(route('admin.pendaftaran'))
        ->assertOk()
        ->assertSee('Daftar Pendaftar Bantara');

    $this->patch(route('admin.pendaftaran.updateStatus', $registration), [
        'status' => 'approved',
    ])->assertRedirect();

    $this->assertDatabaseHas('bantara_registrations', [
        'id' => $registration->id,
        'status_verifikasi' => 'disetujui',
    ]);
});
