<?php

use App\Models\Post;

it('public news pages display real published posts instead of dummy content', function () {
    Post::query()->create([
        'title' => 'Kegiatan Pramuka Real 2026',
        'slug' => 'kegiatan-pramuka-real-2026',
        'type' => 'Kegiatan',
        'excerpt' => 'Berita nyata dari database.',
        'content' => 'Isi berita nyata dari database untuk validasi publik.',
        'published_at' => now(),
        'is_published' => true,
    ]);

    $this->get(route('news'))
        ->assertOk()
        ->assertSee('Kegiatan Pramuka Real 2026');

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Kegiatan Pramuka Real 2026');
});

it('public users can open a published news detail route', function () {
    $post = Post::query()->create([
        'title' => 'Survival Pramuka 2026',
        'slug' => 'survival-pramuka-2026',
        'type' => 'Kegiatan',
        'excerpt' => 'Latihan survival pramuka dalam suasana alam terbuka.',
        'content' => '<p>Dalam kegiatan ini peserta mendapatkan materi survival...</p>',
        'published_at' => now(),
        'is_published' => true,
    ]);

    $this->get(route('berita.show', ['slug' => $post->slug]))
        ->assertOk()
        ->assertSee('Survival Pramuka 2026');
});

it('news detail content uses justified text alignment', function () {
    $post = Post::query()->create([
        'title' => 'Rapat Persiapan Kegiatan 2026',
        'slug' => 'rapat-persiapan-kegiatan-2026',
        'type' => 'Kegiatan',
        'excerpt' => 'Rapat persiapan kegiatan pramuka.',
        'content' => 'Dalam rapat ini dibahas penyusunan agenda kegiatan dan pembagian tugas.',
        'published_at' => now(),
        'is_published' => true,
    ]);

    $this->get(route('berita.show', ['slug' => $post->slug]))
        ->assertOk()
        ->assertSee('style="text-align: justify; text-justify: inter-word;"', false);
});
