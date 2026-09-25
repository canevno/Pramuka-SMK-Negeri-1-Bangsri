<?php

use App\Models\User;

it('admin can open the sejarah module and save history content', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $response = $this->get(route('admin.sejarah'));
    $response->assertOk();
    $response->assertSee('Kelola Profil Sejarah');

    $storeResponse = $this->post(route('admin.sejarah.store'), [
        'history_kepanduan_dunia_title' => 'Kepanduan Dunia',
        'history_kepanduan_dunia_content' => '<p>Konten baru kepanduan dunia.</p>',
        'history_kepanduan_indonesia_title' => 'Kepanduan Indonesia',
        'history_kepanduan_indonesia_content' => '<p>Konten baru kepanduan Indonesia.</p>',
        'history_gerakan_pramuka_title' => 'Gerakan Pramuka',
        'history_gerakan_pramuka_content' => '<p>Konten baru gerakan pramuka.</p>',
        'history_ad_art_munas_2023_title' => 'AD - ART Munas 2023',
        'history_ad_art_munas_2023_content' => '<p>Konten baru AD-ART.</p>',
    ]);

    $storeResponse->assertRedirect(route('admin.sejarah'));
    $this->assertDatabaseHas('settings', ['key' => 'history_kepanduan_dunia_title', 'value' => 'Kepanduan Dunia']);
    $this->assertDatabaseHas('settings', ['key' => 'history_ad_art_munas_2023_content', 'value' => '<p>Konten baru AD-ART.</p>']);
});
