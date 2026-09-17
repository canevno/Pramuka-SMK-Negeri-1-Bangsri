<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

it('admin can create a new petugas record', function () {
    $user = User::factory()->create([
        'name' => 'Admin Absensi',
        'email' => 'admin.absensi@example.com',
        'is_admin' => true,
    ]);

    $this->actingAs($user)
        ->post(route('admin.petugas.store'), [
            'nama' => 'Petugas Baru',
            'nta' => 'NTA-NEW-001',
            'kelas_petugas' => 'XI RPL 2',
            'jenis_kelamin' => 'L',
            'photo' => UploadedFile::fake()->image('petugas-profile.jpg'),
        ])
        ->assertRedirect(route('admin.petugas'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('petugas_absensis', [
        'nama' => 'Petugas Baru',
        'nta' => 'NTA-NEW-001',
        'kelas_petugas' => 'XI RPL 2',
        'is_active' => true,
    ]);

    $this->assertDatabaseHas('petugas_absensis', [
        'nta' => 'NTA-NEW-001',
    ]);

    $petugas = \App\Models\PetugasAbsensi::query()->where('nta', 'NTA-NEW-001')->first();
    expect($petugas)->not->toBeNull();
    expect($petugas->photo_url ?? null)->not->toBeNull();

    $this->actingAs($user)
        ->get(route('admin.petugas'))
        ->assertOk()
        ->assertSee('Petugas Baru');
});

it('admin can delete a petugas record', function () {
    $user = User::factory()->create([
        'name' => 'Admin Absensi',
        'email' => 'admin.absensi.delete@example.com',
        'is_admin' => true,
    ]);

    $petugas = \App\Models\PetugasAbsensi::query()->create([
        'nama' => 'Petugas Dihapus',
        'nta' => 'NTA-DELETE-001',
        'kelas_petugas' => 'XII RPL 1',
        'is_active' => true,
        'is_approved' => true,
        'status' => 'Aktif',
    ]);

    $this->actingAs($user)
        ->post(route('admin.petugas.destroy', $petugas->id))
        ->assertRedirect(route('admin.petugas'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('petugas_absensis', [
        'id' => $petugas->id,
    ]);
});
