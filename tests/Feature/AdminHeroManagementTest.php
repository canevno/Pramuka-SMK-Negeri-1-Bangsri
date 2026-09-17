<?php

use App\Models\HeroSlide;
use App\Models\User;

it('admin can create and list active hero slides', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $response = $this->post(route('admin.hero.store'), [
        'title' => 'Judul Hero Baru',
        'excerpt' => 'Deskripsi hero baru',
        'href' => route('news'),
        'image' => null,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $response->assertRedirect(route('admin.hero'));
    $this->assertDatabaseHas('hero_slides', [
        'title' => 'Judul Hero Baru',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $html = $this->get(route('admin.hero'))->assertOk()->getContent();
    expect($html)->toContain('Judul Hero Baru');
});

it('public home shows hero slides from database when available', function () {
    HeroSlide::query()->create([
        'title' => 'Slide Publik',
        'excerpt' => 'Deskripsi publik',
        'image' => 'images/hero/kegiatan-1.jpg',
        'href' => route('news'),
        'is_active' => true,
        'sort_order' => 2,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Slide Publik');
});
