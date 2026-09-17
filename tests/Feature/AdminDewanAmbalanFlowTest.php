<?php

use App\Models\DewanAmbalan;
use App\Models\User;

it('shows dewan ambalan data in the public page and admin list', function () {
    $admin = User::factory()->create([
        'email' => 'admin-dewan-ambalan@example.com',
        'is_admin' => true,
    ]);

    DewanAmbalan::query()->create([
        'name' => 'Bapak Raka',
        'jabatan' => 'Ketua Dewan Ambalan',
        'status' => 'Aktif',
        'bio' => 'Memimpin program dan koordinasi ambalan.',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('dewan-ambalan'))
        ->assertOk()
        ->assertSee('Bapak Raka')
        ->assertSee('Ketua Dewan Ambalan');

    $this->actingAs($admin)
        ->get(route('admin.dewan-ambalan'))
        ->assertOk()
        ->assertSee('Bapak Raka')
        ->assertSee('Ketua Dewan Ambalan');
});

it('allows admin to store a new dewan ambalan', function () {
    $admin = User::factory()->create([
        'email' => 'admin-dewan-ambalan-store@example.com',
        'is_admin' => true,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.dewan-ambalan.store'), [
            'name' => 'Ibu Lestari',
            'jabatan' => 'Sekretaris Dewan Ambalan',
            'phone' => '08120000005',
            'email' => 'lestari@example.com',
            'status' => 'Aktif',
            'bio' => 'Mengelola dokumentasi dan koordinasi rapat.',
            'is_active' => true,
            'sort_order' => 2,
        ])
        ->assertRedirect(route('admin.dewan-ambalan'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('dewan_ambalans', ['name' => 'Ibu Lestari', 'jabatan' => 'Sekretaris Dewan Ambalan']);
});

it('allows admin to update a dewan ambalan', function () {
    $admin = User::factory()->create([
        'email' => 'admin-dewan-ambalan-update@example.com',
        'is_admin' => true,
    ]);

    $member = DewanAmbalan::query()->create([
        'name' => 'Bapak Yuda',
        'jabatan' => 'Ketua Lama',
        'status' => 'Aktif',
        'is_active' => true,
        'sort_order' => 4,
    ]);

    $this->actingAs($admin)
        ->put(route('admin.dewan-ambalan.update', $member), [
            'name' => 'Bapak Yuda Baru',
            'jabatan' => 'Ketua Dewan Ambalan Baru',
            'phone' => '08120000006',
            'email' => 'yuda.baru@example.com',
            'status' => 'Aktif',
            'bio' => 'Tugas baru dalam pengelolaan program.',
            'is_active' => true,
            'sort_order' => 8,
        ])
        ->assertRedirect(route('admin.dewan-ambalan'))
        ->assertSessionHas('success');

    $member->refresh();
    expect($member->name)->toBe('Bapak Yuda Baru');
    expect($member->jabatan)->toBe('Ketua Dewan Ambalan Baru');
    expect($member->bio)->toBe('Tugas baru dalam pengelolaan program.');
    expect($member->sort_order)->toBe(8);
});

it('allows admin to toggle and delete a dewan ambalan', function () {
    $admin = User::factory()->create([
        'email' => 'admin-dewan-ambalan-actions@example.com',
        'is_admin' => true,
    ]);

    $member = DewanAmbalan::query()->create([
        'name' => 'Bapak Naryo',
        'jabatan' => 'Bendahara Dewan Ambalan',
        'status' => 'Aktif',
        'is_active' => true,
        'sort_order' => 3,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.dewan-ambalan.toggle', $member))
        ->assertRedirect(route('admin.dewan-ambalan'))
        ->assertSessionHas('success');

    $member->refresh();
    expect($member->is_active)->toBeFalse();
    expect($member->status)->toBe('Non-Aktif');

    $this->actingAs($admin)
        ->delete(route('admin.dewan-ambalan.delete', $member))
        ->assertRedirect(route('admin.dewan-ambalan'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('dewan_ambalans', ['id' => $member->id]);
});
