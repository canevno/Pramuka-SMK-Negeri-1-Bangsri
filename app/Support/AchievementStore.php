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
                'winner' => 'Muhammad Gilang Ramadhan',
                'winner_social_link' => '',
                'description' => 'Prestasi membanggakan dalam kegiatan Garuda Berprestasi putra penegak.',
                'image' => 'images/achievement/prestasi1.jpg',
            ],
            [
                'title' => 'Juara 3 Infografis Pelihara Fair',
                'category' => 'Tingkat Nasional',
                'year' => 2025,
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

        return Achievement::query()
            ->orderByDesc('year')
            ->orderByDesc('id')
            ->get()
            ->map(fn ($achievement) => self::normalize($achievement->toArray()))
            ->toArray();
    }

    public static function byLevel(string $level): array
    {
        $normalizedLevel = strtolower(trim($level));

        return array_values(array_filter(
            self::all(),
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

    public static function add(array $input): array
    {
        if (! Schema::hasTable('achievements')) {
            return self::normalize($input);
        }

        $achievement = Achievement::query()->create(self::normalize([
            'title' => $input['title'] ?? 'Prestasi Baru',
            'category' => $input['category'] ?? 'Umum',
            'year' => $input['year'] ?? now()->year,
            'winner' => $input['winner'] ?? 'Anggota',
            'winner_social_link' => $input['winner_social_link'] ?? ($input['winner_link'] ?? ''),
            'description' => $input['description'] ?? '',
            'image' => $input['image'] ?? 'images/achievement/prestasi1.jpg',
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
            'winner' => $input['winner'] ?? $achievement->winner,
            'winner_social_link' => $input['winner_social_link'] ?? ($input['winner_link'] ?? $achievement->winner_social_link),
            'description' => $input['description'] ?? $achievement->description,
            'image' => $input['image'] ?? $achievement->image,
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

        return [
            'id' => (int) ($item['id'] ?? 0),
            'title' => trim((string) ($item['title'] ?? 'Prestasi Baru')),
            'category' => trim((string) ($item['category'] ?? 'Umum')),
            'year' => (int) ($item['year'] ?? now()->year),
            'winner' => trim((string) ($item['winner'] ?? 'Anggota')),
            'winner_social_link' => trim((string) $winnerSocialLink),
            'description' => trim((string) ($item['description'] ?? '')),
            'image' => trim((string) ($item['image'] ?? 'images/achievement/prestasi1.jpg')),
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
