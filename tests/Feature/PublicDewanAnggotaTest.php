<?php

use App\Models\Student;

it('shows active dewan anggota from the student data source', function () {
    Student::query()->delete();

    Student::query()->create([
        'nama' => 'Rizki Dewan',
        'jabatan' => 'Ketua Dewan Ambalan',
        'status' => 'Aktif',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    Student::query()->create([
        'nama' => 'Santi Tidak Aktif',
        'jabatan' => 'Sekretaris Dewan',
        'status' => 'Non-Aktif',
        'is_active' => false,
        'sort_order' => 2,
    ]);

    $this->get(route('pembina'))
        ->assertOk()
        ->assertSee('Rizki Dewan')
        ->assertSee('Ketua Dewan Ambalan')
        ->assertDontSee('Santi Tidak Aktif');
});
