<?php

use App\Models\Notification;
use App\Models\User;

test('creating a gallery item adds an admin notification', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $this->actingAs($user);

    $this->post(route('admin.gallery.store'), [
        'title' => 'Latihan Baru',
        'category' => 'kegiatan',
        'description' => 'Dokumentasi baru.',
        'alt_text' => 'Latihan baru',
        'published_at' => now()->toDateString(),
        'is_published' => true,
        'is_featured' => false,
    ]);

    $this->assertDatabaseHas('notifications', [
        'title' => 'Album galeri ditambahkan',
    ]);

    $this->assertTrue(Notification::query()->where('title', 'Album galeri ditambahkan')->exists());
});

test('public bantara registration creates unread admin notification and admin can mark it read', function () {
    $response = $this->post(route('pendaftaran-bantara.submit'), [
        'nama' => 'Rizki Pratama',
        'kelas' => 'X PPLG 1',
        'jenis_kelamin' => 'Laki-laki',
        'rt' => '01',
        'rw' => '02',
        'kecamatan' => 'Bangsri',
        'kabupaten' => 'Jepara',
        'tempat_tanggal_lahir' => 'Jepara, 12 Maret 2010',
        'motivasi' => 'Saya ingin belajar disiplin dan kemandirian.',
        'whatsapp' => '081234567890',
        'nomor_orang_tua' => '081234567891',
        'surat_izin' => \Illuminate\Http\UploadedFile::fake()->create('surat-izin.pdf', 200, 'application/pdf'),
    ]);

    $response->assertRedirect(route('pendaftaran-bantara'));

    $notification = Notification::query()->where('title', 'Pendaftaran Bantara baru')->latest()->first();
    $this->assertNotNull($notification);
    $this->assertFalse((bool) $notification->is_read);

    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $this->post(route('admin.notifications.read', $notification))
        ->assertOk();

    $this->assertDatabaseHas('notifications', [
        'id' => $notification->id,
        'is_read' => true,
    ]);
});

test('admin notification click redirects to target page and marks it as read', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $notification = Notification::query()->create([
        'title' => 'Pendaftaran baru',
        'message' => 'Ada pendaftaran baru yang menunggu ditinjau.',
        'type' => 'info',
        'is_read' => false,
        'url' => route('admin.pendaftaran'),
        'data' => [
            'registration_type' => 'bantara',
            'registration_id' => 42,
        ],
    ]);

    $this->get(route('admin.notifications.visit', $notification))
        ->assertRedirect(route('admin.pendaftaran'));

    $this->assertDatabaseHas('notifications', [
        'id' => $notification->id,
        'is_read' => true,
    ]);
});
