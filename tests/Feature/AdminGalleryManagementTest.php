<?php

use App\Models\User;

test('authenticated admin users can access the gallery management page', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('admin.gallery'));

    $response->assertOk();
    $response->assertSee('Kelola Galeri');
});

test('admin can create a gallery album', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $this->actingAs($user);

    $response = $this->post(route('admin.gallery.store'), [
        'title' => 'Latihan Camping',
        'category' => 'pelatihan',
        'location' => 'Lapangan SMK Negeri 1 Bangsri',
        'date' => '2026-09-08',
        'description' => 'Kegiatan camping bersama anggota.',
        'image' => 'images/gallery/demo.jpg',
        'is_published' => true,
        'is_featured' => true,
    ]);

    $response->assertRedirect(route('admin.gallery'));
    $this->assertDatabaseHas('gallery_items', [
        'title' => 'Latihan Camping',
        'category' => 'pelatihan',
        'location' => 'Lapangan SMK Negeri 1 Bangsri',
    ]);
});
