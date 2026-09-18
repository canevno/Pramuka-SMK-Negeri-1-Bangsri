<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Security;

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', [Profile::class, 'render'])->name('profile.edit');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('settings/appearance', [Appearance::class, 'render'])->name('appearance.edit');

    Route::get('settings/security', [Security::class, 'render'])
        ->middleware([
            'password.confirm',
        ])
        ->name('security.edit');
});
