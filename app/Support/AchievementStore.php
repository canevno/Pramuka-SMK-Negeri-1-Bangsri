<?php

namespace App\Support;

use App\Models\Achievement;
use Illuminate\Support\Facades\Schema;

class AchievementStore
{
    public static function defaultData(): array
    {
        return [
            [
                'title' => 'Juara 1 Garuda Berprestasi Putra Penegak',
                'category' => 'Tingkat Kwarcab Jepara',
                'year' => 2026,
                'date' => '2026-06-15',
                'location' => 'Jepara',
                'winner' => 'Muhammad Gilang Ramadhan',
                'winner_social_link' => '',
                'description' => 'Prestasi membanggakan dalam kegiatan Garuda Berprestasi putra penegak.',
                'image' => 'images/achievement/prestasi1.jpg',
            ],
            [
                'title' => 'Juara 3 Infografis Pelihara Fair',
                'category' => 'Tingkat Nasional',
                'year' => 2025,
                'date' => '2025-09-12',
                'location' => 'Jakarta',
                'winner' => 'Nafa Anjani',
                'winner_social_link' => '',
                'description' => 'Karya infografis terbaik yang menonjolkan semangat kepedulian lingkungan.',
                'image' => 'images/achievement/prestasi1.jpg',
            ],
        ];
    }

    public static function all(): array
    {
        if (! Schema::hasTable('achievements')) {
            return [];
        }

        $query = Achievement::query();

        if (Schema::hasColumn('achievements', 'is_published')) {
            $query->orderByDesc('is_published');
        }

        return $query
            ->orderByDesc('year')
            ->orderByDesc('id')
            ->get()
            ->map(fn ($achievement) => self::normalize($achievement->toArray()))
            ->toArray();
    }

    public static function published(?int $year = null): array
    {
        if (! Schema::hasTable('achievements')) {
            return [];
        }

        $query = Achievement::query();

        if (Schema::hasColumn('achievements', 'is_published')) {
            $query->where('is_published', true);
        }

        $query->orderByDesc('year')
            ->orderByDesc('id');

        if ($year !== null) {
            $query->where('year', $year);
        }

        return $query->get()
            ->map(fn ($achievement) => self::normalize($achievement->toArray()))
            ->toArray();
    }

    public static function byLevel(string $level): array
    {
        $normalizedLevel = strtolower(trim($level));

        return array_values(array_filter(
            self::published(),
            fn (array $achievement) => self::matchesLevel((string) ($achievement['category'] ?? ''), $normalizedLevel)
        ));
    }

    public static function save(array $items): void
    {
        if (! Schema::hasTable('achievements')) {
            return;
        }

        Achievement::query()->delete();

        foreach ($items as $item) {
            Achievement::query()->create(self::normalize($item));
        }
    }

    public static function syncImported(array $items): void
    {
        if (! Schema::hasTable('achievements')) {
            return;
        }

        foreach ($items as $item) {
            $normalized = self::normalize($item);
            $candidate = Achievement::query();

            if (! empty($normalized['detail_url'])) {
                $candidate = $candidate->where('detail_url', $normalized['detail_url']);
            }

            if (empty($normalized['detail_url'])) {
                $candidate = $candidate->where('title', $normalized['title'])
                    ->where('year', $normalized['year']);
            }

            $existing = $candidate->first();

            if ($existing) {
                $payload = $normalized;
                $payload['is_published'] = (bool) ($existing->is_published ?? false);

                if (empty($payload['published_at']) && $payload['is_published']) {
                    $payload['published_at'] = now()->toDateTimeString();
                }

                $existing->fill($payload);
                $existing->save();

                continue;
            }

            Achievement::query()->create([
                ...$normalized,
                'is_published' => false,
                'published_at' => null,
            ]);
        }
    }

    public static function add(array $input): array
    {
        if (! Schema::hasTable('achievements')) {
            return self::normalize($input);
        }

        $achievement = Achievement::query()->create(self::normalize([
            'title' => $input['title'] ?? 'Prestasi Baru',
            'category' => $input['category'] ?? 'Umum',
            'year' => $input['year'] ?? now()->year,
            'date' => $input['date'] ?? null,
            'location' => $input['location'] ?? null,
            'winner' => $input['winner'] ?? 'Anggota',
            'winner_social_link' => $input['winner_social_link'] ?? ($input['winner_link'] ?? ''),
            'description' => $input['description'] ?? '',
            'image' => $input['image'] ?? 'images/achievement/prestasi1.jpg',
            'detail_url' => $input['detail_url'] ?? ($input['url'] ?? ($input['link'] ?? '')),
            'is_published' => $input['is_published'] ?? false,
            'published_at' => $input['published_at'] ?? null,
        ]));

        return self::normalize($achievement->toArray());
    }

    public static function update(int $id, array $input): ?array
    {
        if (! Schema::hasTable('achievements')) {
            return null;
        }

        $achievement = Achievement::query()->find($id);

        if (! $achievement) {
            return null;
        }

        $achievement->fill(self::normalize([
            'id' => $achievement->id,
            'title' => $input['title'] ?? $achievement->title,
            'category' => $input['category'] ?? $achievement->category,
            'year' => $input['year'] ?? $achievement->year,
            'date' => $input['date'] ?? $achievement->date,
            'location' => $input['location'] ?? $achievement->location,
            'winner' => $input['winner'] ?? $achievement->winner,
            'winner_social_link' => $input['winner_social_link'] ?? ($input['winner_link'] ?? $achievement->winner_social_link),
            'description' => $input['description'] ?? $achievement->description,
            'image' => $input['image'] ?? $achievement->image,
            'detail_url' => $input['detail_url'] ?? ($input['url'] ?? ($input['link'] ?? $achievement->detail_url)),
            'is_published' => $input['is_published'] ?? $achievement->is_published,
            'published_at' => $input['published_at'] ?? $achievement->published_at,
        ]));

        $achievement->save();

        return self::normalize($achievement->fresh()->toArray());
    }

    public static function duplicate(int $id): ?array
    {
        if (! Schema::hasTable('achievements')) {
            return null;
        }

        $achievement = Achievement::query()->find($id);

        if (! $achievement) {
            return null;
        }

        $duplicate = $achievement->toArray();
        unset($duplicate['id'], $duplicate['created_at'], $duplicate['updated_at']);

        $duplicate['title'] = trim($achievement->title . ' (Duplikat)');
        $duplicate['winner'] = trim((string) $achievement->winner);

        return self::add($duplicate);
    }

    public static function delete(int $id): bool
    {
        if (! Schema::hasTable('achievements')) {
            return false;
        }

        return Achievement::query()->whereKey($id)->delete() > 0;
    }

    protected static function normalize(array $item): array
    {
        $winnerSocialLink = $item['winner_social_link'] ?? ($item['winner_link'] ?? '');
        $detailUrl = $item['detail_url'] ?? ($item['url'] ?? ($item['link'] ?? ''));
        $publishedAt = $item['published_at'] ?? null;

        return [
            'id' => (int) ($item['id'] ?? 0),
            'title' => trim((string) ($item['title'] ?? 'Prestasi Baru')),
            'category' => trim((string) ($item['category'] ?? 'Umum')),
            'year' => (int) ($item['year'] ?? now()->year),
            'date' => trim((string) ($item['date'] ?? '')),
            'location' => trim((string) ($item['location'] ?? '')),
            'winner' => trim((string) ($item['winner'] ?? 'Anggota')),
            'winner_social_link' => trim((string) $winnerSocialLink),
            'description' => trim((string) ($item['description'] ?? '')),
            'image' => trim((string) ($item['image'] ?? 'images/achievement/prestasi1.jpg')),
            'detail_url' => trim((string) $detailUrl),
            'is_published' => (bool) ($item['is_published'] ?? false),
            'published_at' => $publishedAt ? trim((string) $publishedAt) : null,
        ];
    }

    protected static function matchesLevel(string $category, string $level): bool
    {
        $categoryText = strtolower(trim($category));
        $categoryText = preg_replace('/[^a-z0-9]+/', ' ', $categoryText) ?? $categoryText;
        $categoryText = preg_replace('/\s+/', ' ', $categoryText) ?? $categoryText;

        return match ($level) {
            'ranting' => str_contains($categoryText, 'tingkat ranting')
                || str_contains($categoryText, 'ranting')
                || str_contains($categoryText, 'ranting sekolah'),
            'cabang' => str_contains($categoryText, 'tingkat cabang')
                || str_contains($categoryText, 'cabang')
                || str_contains($categoryText, 'tingkat cabang sekolah'),
            'jateng' => str_contains($categoryText, 'tingkat jateng')
                || str_contains($categoryText, 'jateng')
                || str_contains($categoryText, 'jawa tengah')
                || str_contains($categoryText, 'daerah'),
            'nasional' => str_contains($categoryText, 'tingkat nasional')
                || str_contains($categoryText, 'nasional'),
            default => false,
        };
    }
}
