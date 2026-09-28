<?php

use App\Models\User;
use App\Models\VisitorDevice;

it('admin api manager shows tracked device records and can block a device', function () {
    $admin = User::factory()->create([
        'is_admin' => true,
        'name' => 'Admin Uji',
        'email' => 'admin-uji@example.com',
    ]);

    $device = VisitorDevice::create([
        'fingerprint' => 'device-test-fingerprint',
        'ip_address' => '203.0.113.5',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'browser' => 'Chrome',
        'platform' => 'Windows',
        'device_label' => 'Windows Desktop',
        'visit_count' => 3,
        'last_seen_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get(route('admin.settings'))
        ->assertOk()
        ->assertSee('Pengelola API')
        ->assertSee('Blokir Perangkat');

    $this->actingAs($admin)
        ->post(route('admin.settings.device.block', $device))
        ->assertRedirect(route('admin.settings'))
        ->assertSessionHas('success');

    $device->refresh();

    expect($device->blocked_at)->not->toBeNull();
    expect($device->is_blocked)->toBeTrue();
});

it('blocked device is denied access to the site', function () {
    $device = VisitorDevice::create([
        'fingerprint' => hash('sha256', '203.0.113.99|Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1|id-ID,id;q=0.9'),
        'ip_address' => '203.0.113.99',
        'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
        'browser' => 'Safari',
        'platform' => 'iOS',
        'device_label' => 'Handphone',
        'visit_count' => 2,
        'last_seen_at' => now(),
        'blocked_at' => now(),
    ]);

    $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.99'])
        ->withHeader('User-Agent', $device->user_agent)
        ->withHeader('Accept-Language', 'id-ID,id;q=0.9')
        ->get('/')->assertForbidden();

    $device->refresh();
    expect($device->is_blocked)->toBeTrue();
});
