<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('admin can update profile with NTA and photo data', function () {
    $user = User::factory()->create([
        'name' => 'Administrator',
        'email' => 'admin@scoutmind.id',
        'nta' => 'NTA-OLD',
        'is_admin' => true,
    ]);

    $this->actingAs($user);

    $photo = UploadedFile::fake()->image('profile.jpg');

    $this->put(route('admin.profile.update'), [
        'name' => 'Admin Baru',
        'email' => 'adminbaru@scoutmind.id',
        'nta' => 'NTA-2026-001',
        'phone' => '081234567890',
        'jabatan' => 'Ketua Admin',
        'bio' => 'Mengelola data organisasi dan admin panel.',
        'photo' => $photo,
    ])->assertRedirect(route('admin.profile.edit'))
      ->assertSessionHas('success', 'Profil admin berhasil diperbarui.');

    $user->refresh();

    expect($user->name)->toBe('Admin Baru')
        ->and($user->email)->toBe('adminbaru@scoutmind.id')
        ->and($user->nta)->toBe('NTA-2026-001')
        ->and($user->phone)->toBe('081234567890')
        ->and($user->jabatan)->toBe('Ketua Admin')
        ->and($user->bio)->toBe('Mengelola data organisasi dan admin panel.')
        ->and($user->photo_url)->not->toBeNull()
        ->and($user->photo_url)->toContain('profiles');
});
