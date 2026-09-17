<?php

use App\Models\Mitra;
use App\Models\User;

it('shows mitra data in the public page and admin list', function () {
    $admin = User::factory()->create([
        'email' => 'admin-mitra@example.com',
        'is_admin' => true,
    ]);

    Mitra::query()->create([
        'name' => 'Kwartir Ranting',
        'jabatan' => 'Pendamping Organisasi',
        'status' => 'Aktif',
        'bio' => 'Mendukung koordinasi program dan kegiatan kepramukaan.',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('mitra'))
        ->assertOk()
        ->assertSee('Kwartir Ranting')
        ->assertSee('Pendamping Organisasi');

    $this->actingAs($admin)
        ->get(route('admin.mitra'))
        ->assertOk()
        ->assertSee('Kwartir Ranting')
        ->assertSee('Pendamping Organisasi');
});

it('allows admin to store, update, toggle and delete a mitra', function () {
    $admin = User::factory()->create([
        'email' => 'admin-mitra-actions@example.com',
        'is_admin' => true,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.mitra.store'), [
            'name' => 'Instansi Pendidikan',
            'jabatan' => 'Kolaborator Program',
            'phone' => '08120000005',
            'email' => 'pendidikan@example.com',
            'status' => 'Aktif',
            'bio' => 'Menghubungkan kegiatan ambalan dengan pembelajaran.',
            'is_active' => true,
            'sort_order' => 2,
        ])
        ->assertRedirect(route('admin.mitra'))
        ->assertSessionHas('success');

    $mitra = Mitra::query()->where('name', 'Instansi Pendidikan')->firstOrFail();
    expect($mitra->bio)->toBe('Menghubungkan kegiatan ambalan dengan pembelajaran.');

    $this->actingAs($admin)
        ->put(route('admin.mitra.update', $mitra), [
            'name' => 'Instansi Pendidikan Baru',
            'jabatan' => 'Kolaborator Program Baru',
            'phone' => '08120000006',
            'email' => 'pendidikan.baru@example.com',
            'status' => 'Aktif',
            'bio' => 'Kegiatan kolaborasi baru untuk pengembangan program.',
            'is_active' => true,
            'sort_order' => 5,
        ])
        ->assertRedirect(route('admin.mitra'))
        ->assertSessionHas('success');

    $mitra->refresh();
    expect($mitra->name)->toBe('Instansi Pendidikan Baru');
    expect($mitra->bio)->toBe('Kegiatan kolaborasi baru untuk pengembangan program.');

    $this->actingAs($admin)
        ->post(route('admin.mitra.toggle', $mitra))
        ->assertRedirect(route('admin.mitra'))
        ->assertSessionHas('success');

    $mitra->refresh();
    expect($mitra->is_active)->toBeFalse();
    expect($mitra->status)->toBe('Non-Aktif');

    $this->actingAs($admin)
        ->delete(route('admin.mitra.delete', $mitra))
        ->assertRedirect(route('admin.mitra'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('mitras', ['id' => $mitra->id]);
});
