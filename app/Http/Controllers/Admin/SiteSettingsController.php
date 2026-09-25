<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    public function index()
    {
        if (! Schema::hasTable('settings')) {
            $settings = [];

            return view('admin.settings.index', compact('settings'));
        }

        $settings = Setting::query()->pluck('value', 'key')->all();

        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        if (! Schema::hasTable('settings')) {
            Schema::create('settings', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->longText('value')->nullable();
                $table->timestamps();
            });
        }

        $request->validate([
            'site_title' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'sambutan_title' => 'nullable|string|max:255',
            'sambutan_subtitle' => 'nullable|string|max:255',
            'sambutan_description' => 'nullable|string',
            'sambutan_instagram' => 'nullable|url|max:255',
            'sambutan_facebook' => 'nullable|url|max:255',
            'sambutan_image' => 'nullable|image',
            'organization_title' => 'nullable|string|max:255',
            'organization_description' => 'nullable|string',
            'organization_card_1_image' => 'nullable|image',
            'organization_card_2_image' => 'nullable|image',
            'organization_card_3_image' => 'nullable|image',
            'organization_card_4_image' => 'nullable|image',
            'history_kepanduan_dunia_title' => 'nullable|string|max:255',
            'history_kepanduan_dunia_content' => 'nullable|string',
            'history_kepanduan_indonesia_title' => 'nullable|string|max:255',
            'history_kepanduan_indonesia_content' => 'nullable|string',
            'history_gerakan_pramuka_title' => 'nullable|string|max:255',
            'history_gerakan_pramuka_content' => 'nullable|string',
            'history_ad_art_munas_2023_title' => 'nullable|string|max:255',
            'history_ad_art_munas_2023_content' => 'nullable|string',
        ]);

        $keys = [
            'site_title',
            'site_description',
            'sambutan_title',
            'sambutan_subtitle',
            'sambutan_description',
            'sambutan_image',
            'sambutan_instagram',
            'sambutan_facebook',
            'organization_title',
            'organization_description',
            'organization_card_1_image',
            'organization_card_2_image',
            'organization_card_3_image',
            'organization_card_4_image',
            'history_kepanduan_dunia_title',
            'history_kepanduan_dunia_content',
            'history_kepanduan_indonesia_title',
            'history_kepanduan_indonesia_content',
            'history_gerakan_pramuka_title',
            'history_gerakan_pramuka_content',
            'history_ad_art_munas_2023_title',
            'history_ad_art_munas_2023_content',
        ];

        foreach ($keys as $key) {
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('settings', 'public');
                Setting::setValue($key, $path);
                continue;
            }

            $removeKey = 'remove_' . $key;
            if ($request->boolean($removeKey)) {
                Setting::query()->where('key', $key)->delete();
                continue;
            }

            if ($request->exists($key)) {
                $value = $request->input($key);
                if ($value === null || $value === '') {
                    Setting::query()->where('key', $key)->delete();
                    continue;
                }

                Setting::setValue($key, $value);
            }
        }

        return redirect()->route('admin.settings')->with('success', 'Pengaturan website berhasil disimpan.');
    }
}
