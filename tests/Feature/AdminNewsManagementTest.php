<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('admin users can access the news management page even without a verified email', function () {
    $user = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->get(route('admin.news'))
        ->assertOk()
        ->assertSee('Kelola Berita');
});

it('admin users can create a news post and it appears in the database', function () {
    $user = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('admin.news.store'), [
            'title' => 'Pelatihan Pramuka Baru',
            'type' => 'Kegiatan',
            'excerpt' => 'Kegiatan pelatihan pramuka yang menarik.',
            'content' => 'Isi berita pelatihan pramuka untuk siswa.',
            'published_at' => '2026-09-17',
            'is_published' => true,
        ])
        ->assertRedirect(route('admin.news'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('posts', [
        'title' => 'Pelatihan Pramuka Baru',
        'type' => 'Kegiatan',
        'is_published' => true,
    ]);
});

it('admin users can upload an image when creating and updating news', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => null,
    ]);

    $image = UploadedFile::fake()->image('news-cover.jpg', 800, 600);

    $this->actingAs($user)
        ->post(route('admin.news.store'), [
            'title' => 'Berita dengan Gambar',
            'type' => 'Kegiatan',
            'excerpt' => 'Contoh berita dengan gambar.',
            'content' => 'Isi lengkap berita.',
            'published_at' => '2026-09-17',
            'is_published' => true,
            'image' => $image,
        ])
        ->assertRedirect(route('admin.news'))
        ->assertSessionHas('success');

    $post = Post::query()->where('title', 'Berita dengan Gambar')->firstOrFail();

    expect($post->image_path)->not->toBeEmpty()
        ->and(Storage::disk('public')->exists($post->image_path))->toBeTrue();

    $newImage = UploadedFile::fake()->image('updated-news-cover.jpg', 900, 700);

    $this->actingAs($user)
        ->put(route('admin.news.update', $post), [
            'title' => 'Berita dengan Gambar Baru',
            'type' => 'Kegiatan',
            'excerpt' => 'Update contoh berita dengan gambar baru.',
            'content' => 'Isi lengkap berita hasil update.',
            'published_at' => '2026-09-18',
            'is_published' => true,
            'image' => $newImage,
        ])
        ->assertRedirect(route('admin.news'))
        ->assertSessionHas('success');

    $post->refresh();

    expect($post->title)->toBe('Berita dengan Gambar Baru')
        ->and($post->image_path)->not->toBeEmpty()
        ->and(Storage::disk('public')->exists($post->image_path))->toBeTrue();
});
