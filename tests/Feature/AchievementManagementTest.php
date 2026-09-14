<?php

use App\Models\User;
use App\Support\AchievementStore;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    if (method_exists(AchievementStore::class, 'save')) {
        AchievementStore::save([]);
    }
});

test('public achievement page redirects to the home achievement section', function () {
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

    $this->get(route('achievement'))
        ->assertRedirect(url('/#prestasi'));
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

    expect(AchievementStore::all())->toHaveCount(1);
    expect(AchievementStore::all()[0]['title'])->toBe('Juara 2 Pencak Silat');
});

test('admin can upload a photo for an achievement', function () {
    $user = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);
    $this->actingAs($user);

    $file = UploadedFile::fake()->image('achievement-upload.jpg', 1200, 900);

    $response = $this->post(route('admin.prestasi.store'), [
        'title' => 'Juara 1 Lomba Karya Tulis',
        'category' => 'Tingkat Cabang',
        'year' => 2025,
        'winner' => 'Aisyah',
        'winner_social_link' => 'https://instagram.com/aisyah',
        'description' => 'Prestasi di bidang karya tulis yang membanggakan.',
        'image' => $file,
    ]);

    $response->assertRedirect(route('admin.prestasi'));
    $stored = AchievementStore::all()[0] ?? [];

    expect($stored['title'] ?? '')->toBe('Juara 1 Lomba Karya Tulis')
        ->and($stored['image'] ?? '')->toContain('images/achievement/')
        ->and($stored['winner_social_link'] ?? '')->toBe('https://instagram.com/aisyah');
});

test('achievement admin form submits image uploads with multipart encoding', function () {
    $user = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);
    $this->actingAs($user);

    $response = $this->get(route('admin.prestasi'));

    $response->assertOk();
    $response->assertSee('enctype="multipart/form-data"', false);
});

test('achievement category pages show the matching level data', function () {
    AchievementStore::save([
        ['id' => 1, 'title' => 'Juara Ranting', 'category' => 'Tingkat Ranting', 'year' => 2024, 'winner' => 'Ranti', 'description' => 'Lomba ranting', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 2, 'title' => 'Juara Cabang', 'category' => 'Tingkat Cabang', 'year' => 2024, 'winner' => 'Candra', 'description' => 'Lomba cabang', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 3, 'title' => 'Juara Jateng', 'category' => 'Tingkat Jateng', 'year' => 2024, 'winner' => 'Dewa', 'description' => 'Lomba jateng', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 4, 'title' => 'Juara Nasional', 'category' => 'Tingkat Nasional', 'year' => 2024, 'winner' => 'Ega', 'description' => 'Lomba nasional', 'image' => 'images/achievement/prestasi1.jpg'],
    ]);

    expect(AchievementStore::byLevel('ranting'))->toHaveCount(1)
        ->and(AchievementStore::byLevel('cabang'))->toHaveCount(1)
        ->and(AchievementStore::byLevel('jateng'))->toHaveCount(1)
        ->and(AchievementStore::byLevel('nasional'))->toHaveCount(1);

    $this->get(route('prestasi.ranting'))->assertOk()->assertSee('Juara Ranting');
    $this->get(route('prestasi.cabang'))->assertOk()->assertSee('Juara Cabang');
    $this->get(route('prestasi.jateng'))->assertOk()->assertSee('Juara Jateng');
    $this->get(route('prestasi.nasional'))->assertOk()->assertSee('Juara Nasional');
});

test('home achievement cards link to their matching level page', function () {
    AchievementStore::save([
        ['id' => 1, 'title' => 'Juara Ranting', 'category' => 'Tingkat Ranting', 'year' => 2024, 'winner' => 'Ranti', 'description' => 'Lomba ranting', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 2, 'title' => 'Juara Cabang', 'category' => 'Tingkat Cabang', 'year' => 2024, 'winner' => 'Candra', 'description' => 'Lomba cabang', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 3, 'title' => 'Juara Jateng', 'category' => 'Tingkat Jateng', 'year' => 2024, 'winner' => 'Dewa', 'description' => 'Lomba jateng', 'image' => 'images/achievement/prestasi1.jpg'],
        ['id' => 4, 'title' => 'Juara Nasional', 'category' => 'Tingkat Nasional', 'year' => 2024, 'winner' => 'Ega', 'description' => 'Lomba nasional', 'image' => 'images/achievement/prestasi1.jpg'],
    ]);

    $home = $this->get(route('home'));

    $home->assertOk()
        ->assertSee(route('prestasi.ranting'))
        ->assertSee(route('prestasi.cabang'))
        ->assertSee(route('prestasi.jateng'))
        ->assertSee(route('prestasi.nasional'));
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
