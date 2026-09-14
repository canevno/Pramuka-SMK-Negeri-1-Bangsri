<?php

use App\Models\User;
use App\Support\AchievementStore;

beforeEach(function () {
    if (method_exists(AchievementStore::class, 'save')) {
        AchievementStore::save([]);
    }
});

test('public achievement page renders stored achievements', function () {
    AchievementStore::save([
        [
            'id' => 1,
            'title' => 'Juara 1 Lomba Tulis Ilmiah',
            'category' => 'Tingkat Kabupaten',
            'year' => 2024,
            'winner' => 'Rizki Ardi',
            'description' => 'Prestasi membanggakan di bidang literasi dan penelitian.',
            'image' => 'images/achievement/prestasi1.jpg',
        ],
    ]);

    $response = $this->get(route('achievement'));

    $response->assertOk()
        ->assertSee('Juara 1 Lomba Tulis Ilmiah');
});

test('admin can create a new achievement', function () {
    $user = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);
    $this->actingAs($user);

    $response = $this->post(route('admin.prestasi.store'), [
        'title' => 'Juara 2 Pencak Silat',
        'category' => 'Tingkat Cabang',
        'year' => 2025,
        'winner' => 'Nafa Anjani',
        'description' => 'Mendapatkan medali perak dalam kompetisi pencak silat.',
        'image' => 'images/achievement/prestasi1.jpg',
    ]);

    $response->assertRedirect(route('admin.prestasi'));
    expect(AchievementStore::all())->toHaveCount(1)
        ->and(AchievementStore::all()[0]['title'])->toBe('Juara 2 Pencak Silat');
});

test('achievement category pages show the matching level data', function () {
    AchievementStore::save([
        ['id' => 1, 'title' => 'Juara Ranting', 'category' => 'Tingkat Ranting', 'year' => 2024, 'winner' => 'Ranti', 'description' => 'Lomba ranting', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 2, 'title' => 'Juara Cabang', 'category' => 'Tingkat Cabang', 'year' => 2024, 'winner' => 'Candra', 'description' => 'Lomba cabang', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 3, 'title' => 'Juara Jateng', 'category' => 'Tingkat Jateng', 'year' => 2024, 'winner' => 'Dewa', 'description' => 'Lomba jateng', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 4, 'title' => 'Juara Nasional', 'category' => 'Tingkat Nasional', 'year' => 2024, 'winner' => 'Ega', 'description' => 'Lomba nasional', 'image' => 'images/achievement/prestasi1.jpg'],
    ]);

    $this->get(route('prestasi.ranting'))->assertOk()->assertSee('Juara Ranting');
    $this->get(route('prestasi.cabang'))->assertOk()->assertSee('Juara Cabang');
    $this->get(route('prestasi.jateng'))->assertOk()->assertSee('Juara Jateng');
    $this->get(route('prestasi.nasional'))->assertOk()->assertSee('Juara Nasional');
});

test('achievement route redirects to the home achievement section and home links to category pages', function () {
    $this->get(route('achievement'))
        ->assertRedirect(url('/#prestasi'));

    $home = $this->get(route('home'));

    $home->assertOk()
        ->assertSee(route('prestasi.ranting'))
        ->assertSee(route('prestasi.cabang'))
        ->assertSee(route('prestasi.jateng'))
        ->assertSee(route('prestasi.nasional'));
});
