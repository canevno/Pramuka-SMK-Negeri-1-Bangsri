<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Support\Facades\Schema;

class AmbalanProfile extends Model
{
    protected $table = 'ambalan_profiles';

    protected $fillable = [
        'type',
        'name',
        'slug',
        'subtitle',
        'tagline',
        'motto',
        'description',
        'vision',
        'mission',
        'photo_url',
        'logo_url',
        'image_path',
        'leader_name',
        'member_count',
        'meeting_schedule',
        'meeting_place',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'member_count' => 'integer',
        'sort_order' => 'integer',
    ];

    public static function activeProfilesForPage(): \Illuminate\Database\Eloquent\Collection
    {
        $defaultProfiles = [
            [
                'name' => 'Ambalan Putra',
                'slug' => 'ambalan-putra',
                'subtitle' => 'KH. Achmad Fauzan',
                'tagline' => 'Penegak Putra',
                'motto' => '',
                'description' => 'Ambalan putra menjadi wadah pembinaan karakter, kedisiplinan, dan kepemimpinan bagi para penegak putra.',
                'vision' => 'Menjadi pramuka putra yang disiplin, mandiri, dan siap memimpin dengan integritas.',
                'mission' => 'Membentuk generasi muda yang berakhlak mulia, tangguh, dan peduli lingkungan.',
                'photo_url' => null,
                'logo_url' => null,
                'image_path' => null,
                'leader_name' => 'KH. Achmad Fauzan',
                'member_count' => null,
                'meeting_schedule' => null,
                'meeting_place' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ambalan Putri',
                'slug' => 'ambalan-putri',
                'subtitle' => 'Dewi Sartika',
                'tagline' => 'Penegak Putri',
                'motto' => '',
                'description' => 'Ambalan putri menjadi wadah pembinaan karakter, semangat kebersamaan, dan kemandirian bagi para penegak putri.',
                'vision' => 'Menjadi pramuka putri yang berani, cerdas, dan berjiwa kepemimpinan.',
                'mission' => 'Mendorong tumbuhnya sikap kemandirian, kreativitas, dan kepedulian terhadap sesama.',
                'photo_url' => null,
                'logo_url' => null,
                'image_path' => null,
                'leader_name' => 'Dewi Sartika',
                'member_count' => null,
                'meeting_schedule' => null,
                'meeting_place' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        if (! Schema::hasTable('ambalan_profiles')) {
            return collect($defaultProfiles)->map(fn ($profile) => (object) $profile)->values();
        }

        $columns = Schema::getColumnListing('ambalan_profiles');

        foreach ($defaultProfiles as $defaultProfile) {
            $identifier = in_array('type', $columns, true)
                ? ['type' => $defaultProfile['name'] === 'Ambalan Putra' ? 'PA' : 'PI']
                : ['slug' => $defaultProfile['slug']];

            $payload = [];
            foreach ($defaultProfile as $key => $value) {
                if (in_array($key, $columns, true)) {
                    $payload[$key] = $value;
                }
            }

            if (in_array('type', $columns, true)) {
                $payload['type'] = $defaultProfile['name'] === 'Ambalan Putra' ? 'PA' : 'PI';
            }

            $existing = static::query()->where($identifier)->first();
            if (! $existing && ! empty($payload)) {
                static::query()->create($payload);
            }
        }

        $query = static::query()->where('is_active', true);

        if (Schema::hasColumn('ambalan_profiles', 'sort_order')) {
            $query->orderBy('sort_order');
        }

        if (Schema::hasColumn('ambalan_profiles', 'name')) {
            $query->orderBy('name');
        }

        $profiles = $query->get();

        if ($profiles->count() < 2) {
            $profiles = collect($defaultProfiles)->map(fn ($profile) => (object) $profile)->values();
        }

        return $profiles;
    }
}
