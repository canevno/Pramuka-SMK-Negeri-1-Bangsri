<?php

use App\Models\Pembina;
use App\Models\User;

it('shows pembina data in the public page and admin list', function () {
    $admin = User::factory()->create([
        'email' => 'admin-pembina@example.com',
        'is_admin' => true,
    ]);

    Pembina::query()->create([
        'name' => 'Bapak Surya',
        'jabatan' => 'Pembina Utama',
        'phone' => '08120000001',
        'email' => 'surya@example.com',
        'status' => 'Aktif',
        'bio' => 'Membina kegiatan lapangan.',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('pembina'))
        ->assertOk()
        ->assertSee('Bapak Surya')
        ->assertSee('Pembina Utama');

    $this->actingAs($admin)
        ->get(route('admin.pembina'))
        ->assertOk()
        ->assertSee('Bapak Surya')
        ->assertSee('Pembina Utama');
});

it('allows admin to store a new pembina', function () {
    $admin = User::factory()->create([
        'email' => 'admin-pembina-store@example.com',
        'is_admin' => true,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.pembina.store'), [
            'name' => 'Ibu Wati',
            'jabatan' => 'Koordinator',
            'phone' => '08120000002',
            'email' => 'wati@example.com',
            'status' => 'Aktif',
            'bio' => 'Koordinator kegiatan.',
            'is_active' => true,
            'sort_order' => 2,
        ])
        ->assertRedirect(route('admin.pembina'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('pembinas', ['name' => 'Ibu Wati', 'jabatan' => 'Koordinator']);
});

it('allows admin to toggle and delete a pembina', function () {
    $admin = User::factory()->create([
        'email' => 'admin-pembina-actions@example.com',
        'is_admin' => true,
    ]);

    $pembina = Pembina::query()->create([
        'name' => 'Bapak Narto',
        'jabatan' => 'Pembina Lapangan',
        'status' => 'Aktif',
        'is_active' => true,
        'sort_order' => 3,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.pembina.toggle', $pembina))
        ->assertRedirect(route('admin.pembina'))
        ->assertSessionHas('success');

    $pembina->refresh();
    expect($pembina->is_active)->toBeFalse();
    expect($pembina->status)->toBe('Non-Aktif');

    $this->actingAs($admin)
        ->delete(route('admin.pembina.delete', $pembina))
        ->assertRedirect(route('admin.pembina'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('pembinas', ['id' => $pembina->id]);
});
