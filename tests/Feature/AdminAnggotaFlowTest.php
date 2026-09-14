<?php

use App\Models\Student;
use App\Models\User;

it('shows anggota data in the public page and admin list', function () {
    $admin = User::factory()->create([
        'email' => 'admin-anggota@example.com',
        'is_admin' => true,
    ]);

    Student::query()->create([
        'nama' => 'Rizki Ardi',
        'kelas_asal' => 'XI',
        'sangga' => 'Sangga Merah',
        'sub_sangga' => 'Sub Sangga 1',
        'ambalan' => 'PA',
        'jabatan' => 'Ketua Regu',
        'status' => 'Aktif',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('active-board'))
        ->assertOk()
        ->assertSee('Rizki Ardi')
        ->assertSee('Ketua Regu');

    $this->actingAs($admin)
        ->get(route('admin.anggota'))
        ->assertOk()
        ->assertSee('Rizki Ardi')
        ->assertSee('Ketua Regu');
});

it('allows admin to store, toggle and delete an anggota', function () {
    $admin = User::factory()->create([
        'email' => 'admin-anggota-actions@example.com',
        'is_admin' => true,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.anggota.store'), [
            'nama' => 'Nafa Anjani',
            'kelas_asal' => 'XII',
            'sangga' => 'Sangga Kuning',
            'sub_sangga' => 'Sub Sangga 2',
            'ambalan' => 'PI',
            'jabatan' => 'Sekretaris',
            'status' => 'Aktif',
            'is_active' => true,
            'sort_order' => 2,
        ])
        ->assertRedirect(route('admin.anggota'))
        ->assertSessionHas('success');

    $anggota = Student::query()->where('nama', 'Nafa Anjani')->firstOrFail();

    $this->actingAs($admin)
        ->post(route('admin.anggota.toggle', $anggota))
        ->assertRedirect(route('admin.anggota'))
        ->assertSessionHas('success');

    $anggota->refresh();
    expect($anggota->is_active)->toBeFalse();
    expect($anggota->status)->toBe('Non-Aktif');

    $this->actingAs($admin)
        ->delete(route('admin.anggota.delete', $anggota))
        ->assertRedirect(route('admin.anggota'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('students', ['id' => $anggota->id]);
});

it('allows admin to update a single anggota and delete all anggota', function () {
    $admin = User::factory()->create([
        'email' => 'admin-anggota-bulk@example.com',
        'is_admin' => true,
    ]);

    $anggota = Student::query()->create([
        'nama' => 'Ayu Lestari',
        'kelas_asal' => 'X',
        'sangga' => 'Sangga Biru',
        'sub_sangga' => 'Sub Sangga 3',
        'ambalan' => 'PA',
        'jabatan' => 'Anggota',
        'status' => 'Aktif',
        'is_active' => true,
        'sort_order' => 8,
    ]);

    Student::query()->create([
        'nama' => 'Bimo Prasetyo',
        'kelas_asal' => 'XI',
        'sangga' => 'Sangga Hijau',
        'sub_sangga' => 'Sub Sangga 4',
        'ambalan' => 'PI',
        'jabatan' => 'Sekretaris',
        'status' => 'Aktif',
        'is_active' => true,
        'sort_order' => 9,
    ]);

    $this->actingAs($admin)
        ->put(route('admin.anggota.update', $anggota), [
            'nama' => 'Ayu Lestari Baru',
            'kelas_asal' => 'XI',
            'sangga' => 'Sangga Biru Baru',
            'sub_sangga' => 'Sub Sangga 5',
            'ambalan' => 'PI',
            'jabatan' => 'Ketua',
            'status' => 'Non-Aktif',
            'is_active' => false,
            'sort_order' => 7,
        ])
        ->assertRedirect(route('admin.anggota'))
        ->assertSessionHas('success');

    $anggota->refresh();
    expect($anggota->nama)->toBe('Ayu Lestari Baru');
    expect($anggota->is_active)->toBeFalse();
    expect($anggota->status)->toBe('Non-Aktif');

    $this->actingAs($admin)
        ->delete(route('admin.anggota.delete-all'))
        ->assertRedirect(route('admin.anggota'))
        ->assertSessionHas('success');

    expect(Student::query()->count())->toBe(0);
});
