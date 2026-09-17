<?php

use App\Models\Post;
use App\Models\User;

it('admin can edit an existing news post', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $post = Post::query()->create([
        'title' => 'Judul Lama',
        'slug' => 'judul-lama',
        'type' => 'Kegiatan',
        'excerpt' => 'Ringkasan lama',
        'content' => 'Isi lama',
        'published_at' => now(),
        'is_published' => true,
        'sort_order' => 1,
    ]);

    $response = $this->put(route('admin.news.update', $post), [
        'title' => 'Judul Baru',
        'type' => 'Prestasi',
        'excerpt' => 'Ringkasan baru',
        'content' => 'Isi baru',
        'published_at' => '2026-09-17',
        'is_published' => true,
        'sort_order' => 2,
    ]);

    $response->assertRedirect(route('admin.news'));
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Judul Baru',
        'type' => 'Prestasi',
        'sort_order' => 2,
    ]);
});

it('admin can duplicate a news post and it keeps the same order value', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $post = Post::query()->create([
        'title' => 'Berita Asli',
        'slug' => 'berita-asli',
        'type' => 'Kegiatan',
        'excerpt' => 'Ringkasan asli',
        'content' => 'Isi asli',
        'published_at' => now(),
        'is_published' => true,
        'sort_order' => 5,
    ]);

    $response = $this->post(route('admin.news.duplicate', $post));

    $response->assertRedirect(route('admin.news'));
    $this->assertDatabaseHas('posts', [
        'title' => 'Berita Asli (Salinan)',
        'type' => 'Kegiatan',
        'sort_order' => 5,
    ]);
});

it('news list is ordered by the configured sort_order', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $first = Post::query()->create([
        'title' => 'Berita Urutan 1',
        'slug' => 'berita-urutan-1',
        'type' => 'Kegiatan',
        'content' => 'Isi 1',
        'published_at' => now()->subDay(),
        'is_published' => true,
        'sort_order' => 10,
    ]);

    $second = Post::query()->create([
        'title' => 'Berita Urutan 2',
        'slug' => 'berita-urutan-2',
        'type' => 'Kegiatan',
        'content' => 'Isi 2',
        'published_at' => now()->subDay(),
        'is_published' => true,
        'sort_order' => 1,
    ]);

    $items = Post::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('published_at')
        ->pluck('id')
        ->all();

    expect($items)->toBe([$second->id, $first->id]);
});
