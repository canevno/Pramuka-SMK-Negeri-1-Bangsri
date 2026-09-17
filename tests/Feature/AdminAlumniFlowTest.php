<?php

use App\Models\Alumni;
use App\Models\User;

it('shows alumni data in the public page and admin list', function () {
    $admin = User::factory()->create([
        'email' => 'admin-alumni@example.com',
        'is_admin' => true,
    ]);

    Alumni::query()->create([
        'name' => 'Muhammad Rafi S.',
        'jabatan' => 'Ketua Alumni',
        'status' => 'Aktif',
        'bio' => 'Alumni yang aktif menjaga silaturahmi dan mendukung kegiatan Pramuka.',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('alumni'))
        ->assertOk()
        ->assertSee('Muhammad Rafi S.')
        ->assertSee('Ketua Alumni');

    $this->actingAs($admin)
        ->get(route('admin.alumni'))
        ->assertOk()
        ->assertSee('Muhammad Rafi S.')
        ->assertSee('Ketua Alumni');
});

it('allows admin to store, update, toggle and delete an alumni', function () {
    $admin = User::factory()->create([
        'email' => 'admin-alumni-actions@example.com',
        'is_admin' => true,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.alumni.store'), [
            'name' => 'Siti Nuraeni',
            'jabatan' => 'Sekretaris Alumni',
            'status' => 'Aktif',
            'bio' => 'Berperan dalam penguatan jaringan alumni dan kegiatan sosial.',
            'is_active' => true,
            'sort_order' => 2,
        ])
        ->assertRedirect(route('admin.alumni'))
        ->assertSessionHas('success');

    $alumni = Alumni::query()->where('name', 'Siti Nuraeni')->firstOrFail();
    expect($alumni->bio)->toBe('Berperan dalam penguatan jaringan alumni dan kegiatan sosial.');

    $this->actingAs($admin)
        ->put(route('admin.alumni.update', $alumni), [
            'name' => 'Siti Nuraeni Baru',
            'jabatan' => 'Koordinator Alumni',
            'status' => 'Aktif',
            'bio' => 'Kegiatan kolaborasi baru untuk pengembangan alumni.',
            'is_active' => true,
            'sort_order' => 5,
        ])
        ->assertRedirect(route('admin.alumni'))
        ->assertSessionHas('success');

    $alumni->refresh();
    expect($alumni->name)->toBe('Siti Nuraeni Baru');
    expect($alumni->bio)->toBe('Kegiatan kolaborasi baru untuk pengembangan alumni.');

    $this->actingAs($admin)
        ->post(route('admin.alumni.toggle', $alumni))
        ->assertRedirect(route('admin.alumni'))
        ->assertSessionHas('success');

    $alumni->refresh();
    expect($alumni->is_active)->toBeFalse();
    expect($alumni->status)->toBe('Non-Aktif');

    $this->actingAs($admin)
        ->delete(route('admin.alumni.delete', $alumni))
        ->assertRedirect(route('admin.alumni'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('alumni', ['id' => $alumni->id]);
});
