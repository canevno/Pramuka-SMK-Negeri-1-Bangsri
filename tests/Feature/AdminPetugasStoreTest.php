<?php

use App\Models\User;

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
        ])
        ->assertRedirect(route('admin.petugas'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('petugas_absensis', [
        'nama' => 'Petugas Baru',
        'nta' => 'NTA-NEW-001',
        'kelas_petugas' => 'XI RPL 2',
        'is_active' => true,
    ]);

    $this->actingAs($user)
        ->get(route('admin.petugas'))
        ->assertOk()
        ->assertSee('Petugas Baru');
});
