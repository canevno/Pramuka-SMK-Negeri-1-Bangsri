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
