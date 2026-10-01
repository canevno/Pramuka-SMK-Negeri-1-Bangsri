<?php

use App\Models\User;

it('admin can access visi misi management page', function () {
    $user = User::factory()->create([
        'name' => 'Admin Pramuka',
        'email' => 'admin@pramuka.test',
        'is_admin' => true,
    ]);

    $this->actingAs($user)
        ->get('/admin/visi-misi')
        ->assertOk();
});
