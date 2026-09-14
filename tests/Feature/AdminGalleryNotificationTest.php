<?php

use App\Models\Notification;
use App\Models\User;

test('creating a gallery item adds an admin notification', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $this->actingAs($user);

    $this->post(route('admin.gallery.store'), [
        'title' => 'Latihan Baru',
        'category' => 'kegiatan',
        'description' => 'Dokumentasi baru.',
        'alt_text' => 'Latihan baru',
        'published_at' => now()->toDateString(),
        'is_published' => true,
        'is_featured' => false,
    ]);

    $this->assertDatabaseHas('notifications', [
        'title' => 'Album galeri ditambahkan',
    ]);

    $this->assertTrue(Notification::query()->where('title', 'Album galeri ditambahkan')->exists());
});
