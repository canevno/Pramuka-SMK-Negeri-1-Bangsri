<?php

use App\Models\TimelineEvent;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('shows timeline event data in the public page and admin list', function () {
    $admin = User::factory()->create([
        'email' => 'admin-timeline@example.com',
        'is_admin' => true,
    ]);

    TimelineEvent::query()->create([
        'title' => 'Latihan PBB Mingguan',
        'date' => '2026-10-10',
        'time' => '08:00',
        'location' => 'Lapangan Sekolah',
        'guide_url' => 'https://example.com/panduan',
        'theme' => 'Disiplin & Kebersamaan',
        'status' => 'upcoming',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('event'))
        ->assertOk()
        ->assertSee('Latihan PBB Mingguan')
        ->assertSee('Lapangan Sekolah');

    $this->actingAs($admin)
        ->get(route('admin.timeline'))
        ->assertOk()
        ->assertSee('Latihan PBB Mingguan')
        ->assertSee('Lapangan Sekolah');
});

it('allows admin to store, update, toggle and delete a timeline event', function () {
    $admin = User::factory()->create([
        'email' => 'admin-timeline-actions@example.com',
        'is_admin' => true,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.timeline.store'), [
            'title' => 'Kemah Persami',
            'date' => '2026-11-05',
            'time' => '07:00',
            'location' => 'Hutan Wisata',
            'guide_url' => 'https://example.com/kemah',
            'theme' => 'Semangat Kemandirian',
            'status' => 'upcoming',
            'is_active' => true,
            'sort_order' => 2,
        ])
        ->assertRedirect(route('admin.timeline'))
        ->assertSessionHas('success');

    $event = TimelineEvent::query()->where('title', 'Kemah Persami')->firstOrFail();
    expect($event->location)->toBe('Hutan Wisata');

    $this->actingAs($admin)
        ->put(route('admin.timeline.update', $event), [
            'title' => 'Kemah Persami Baru',
            'date' => '2026-11-06',
            'time' => '08:30',
            'location' => 'Hutan Wisata Baru',
            'guide_url' => 'https://example.com/kemah-baru',
            'theme' => 'Semangat Kemandirian Baru',
            'status' => 'upcoming',
            'is_active' => true,
            'sort_order' => 5,
        ])
        ->assertRedirect(route('admin.timeline'))
        ->assertSessionHas('success');

    $event->refresh();
    expect($event->title)->toBe('Kemah Persami Baru');
    expect($event->theme)->toBe('Semangat Kemandirian Baru');

    $this->actingAs($admin)
        ->post(route('admin.timeline.toggle', $event))
        ->assertRedirect(route('admin.timeline'))
        ->assertSessionHas('success');

    $event->refresh();
    expect($event->is_active)->toBeFalse();

    $this->actingAs($admin)
        ->delete(route('admin.timeline.delete', $event))
        ->assertRedirect(route('admin.timeline'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('timeline_events', ['id' => $event->id]);
});

it('stores a custom logo for the next event', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'email' => 'admin-timeline-logo@example.com',
        'is_admin' => true,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.timeline.store'), [
            'title' => 'Logo Kegiatan Baru',
            'date' => '2026-12-10',
            'time' => '09:00',
            'location' => 'Pusat Kegiatan',
            'guide_url' => 'https://example.com/logo-kegiatan',
            'theme' => 'Logo custom',
            'status' => 'upcoming',
            'is_active' => true,
            'sort_order' => 1,
            'logo' => UploadedFile::fake()->image('logo-kegiatan.png', 1200, 800),
        ])
        ->assertRedirect(route('admin.timeline'))
        ->assertSessionHas('success');

    $event = TimelineEvent::query()->where('title', 'Logo Kegiatan Baru')->firstOrFail();

    expect($event->logo_path)->not->toBeNull();
    expect(Storage::disk('public')->exists($event->logo_path))->toBeTrue();
});
