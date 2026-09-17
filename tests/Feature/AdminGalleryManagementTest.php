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

test('admin can update an existing gallery album', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $this->actingAs($user);

    $album = \App\Models\GalleryItem::query()->create([
        'title' => 'Album Lama',
        'category' => 'kegiatan',
        'location' => 'Lokasi Lama',
        'image' => 'images/gallery/old.jpg',
        'description' => 'Deskripsi lama',
        'alt_text' => 'Alt lama',
        'published_at' => '2026-09-01',
        'is_published' => true,
        'is_featured' => false,
    ]);

    $response = $this->put(route('admin.gallery.update', $album), [
        'title' => 'Album Baru',
        'category' => 'acara',
        'location' => 'Lokasi Baru',
        'description' => 'Deskripsi baru',
        'alt_text' => 'Alt baru',
        'published_at' => '2026-09-10',
        'is_published' => false,
        'is_featured' => true,
    ]);

    $response->assertRedirect(route('admin.gallery'));
    $this->assertDatabaseHas('gallery_items', [
        'id' => $album->id,
        'title' => 'Album Baru',
        'category' => 'acara',
        'location' => 'Lokasi Baru',
        'description' => 'Deskripsi baru',
        'is_published' => false,
        'is_featured' => true,
    ]);
});

test('admin can duplicate a gallery album', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $this->actingAs($user);

    $album = \App\Models\GalleryItem::query()->create([
        'title' => 'Album Asli',
        'category' => 'kegiatan',
        'location' => 'Lokasi Asli',
        'image' => 'images/gallery/original.jpg',
        'description' => 'Deskripsi asli',
        'alt_text' => 'Alt asli',
        'published_at' => '2026-09-05',
        'is_published' => true,
        'is_featured' => false,
    ]);

    $response = $this->post(route('admin.gallery.duplicate', $album));

    $response->assertRedirect(route('admin.gallery'));
    $this->assertDatabaseHas('gallery_items', [
        'title' => 'Album Asli (Salinan)',
        'category' => 'kegiatan',
        'location' => 'Lokasi Asli',
        'image' => 'images/gallery/original.jpg',
    ]);
    $this->assertDatabaseCount('gallery_items', 2);
});
