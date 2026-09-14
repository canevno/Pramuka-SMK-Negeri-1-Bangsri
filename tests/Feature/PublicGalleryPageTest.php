<?php

use App\Models\GalleryItem;

test('public gallery page displays published gallery items from the database', function () {
    GalleryItem::query()->create([
        'title' => 'Latihan Kemah',
        'category' => 'kegiatan',
        'image' => 'storage/gallery/demo-gallery.jpg',
        'description' => 'Dokumentasi latihan kemah.',
        'alt_text' => 'Latihan kemah pramuka',
        'published_at' => now()->toDateString(),
        'is_published' => true,
        'is_featured' => true,
    ]);

    $response = $this->get(route('gallery'));

    $response->assertOk();
    $response->assertSee('Latihan Kemah');
    $response->assertSee('storage/gallery/demo-gallery.jpg');
});

test('search redirects directly when there is only one relevant result', function () {
    $response = $this->get('/search?q=berita');

    $response->assertRedirect(route('news'));
});

test('public gallery page resolves public-prefixed uploaded images without falling back to the default template', function () {
    GalleryItem::query()->create([
        'title' => 'Latihan Keterampilan Baru',
        'category' => 'pelatihan',
        'image' => 'public/storage/gallery/demo-gallery-public.jpg',
        'description' => 'Dokumentasi latihan keterampilan baru.',
        'alt_text' => 'Latihan keterampilan baru pramuka',
        'published_at' => now()->toDateString(),
        'is_published' => true,
        'is_featured' => true,
    ]);

    $response = $this->get(route('gallery'));

    $response->assertOk();
    $response->assertSee('/storage/gallery/demo-gallery-public.jpg');
    $response->assertDontSee('images/gallery/default.jpg');
});

test('search redirects directly to absensi when that keyword is used', function () {
    $response = $this->get('/search?q=absensi');

    $response->assertRedirect(route('absensi.index'));
});

test('search redirects directly to the strongest relevant page for broader keywords', function () {
    $response = $this->get('/search?q=dewan');

    $response->assertRedirect(route('dewan-kehormatan'));
});
