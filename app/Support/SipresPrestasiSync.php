<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SipresPrestasiSync
{
    public static function sync(?string $url = null): array
    {
        $sourceUrl = $url ?? env('SIPRES_PRESTASI_URL', 'https://sipres.smkn1bangsri.sch.id/api/v1/prestasi?ekstrakurikuler=Pramuka%20SMK%20Negeri%201%20Bangsri');
        $token = env('SIPRES_API_TOKEN');

        $response = Http::acceptJson()
            ->timeout(30)
            ->withHeaders($token ? ['Authorization' => 'Bearer '.$token] : [])
            ->get($sourceUrl);

        if (! $response->successful()) {
            throw new \RuntimeException('Gagal mengambil data dari SIPRES. HTTP '.$response->status().'. '.$response->body());
        }

        $payload = $response->json();
        $items = self::extractItems($payload);

        if (empty($items)) {
            throw new \RuntimeException('Data prestasi dari SIPRES kosong atau format respons tidak sesuai.');
        }

        $normalized = array_values(array_map(fn (array $item) => self::normalizeItem($item), $items));

        AchievementStore::syncImported($normalized);

        return [
            'source' => $sourceUrl,
            'synced' => count($normalized),
            'updated_at' => now()->toDateTimeString(),
        ];
    }

    protected static function extractItems(mixed $payload): array
    {
        if (! is_array($payload)) {
            return [];
        }

        $candidates = [
            $payload['data'] ?? null,
            $payload['items'] ?? null,
            $payload['prestasi'] ?? null,
            $payload['results'] ?? null,
            $payload['data']['items'] ?? null,
        ];

        foreach ($candidates as $candidate) {
            if (is_array($candidate)) {
                if (self::isList($candidate)) {
                    return $candidate;
                }

                if (isset($candidate[0]) && is_array($candidate[0])) {
                    return $candidate;
                }
            }
        }

        return self::isList($payload) ? $payload : [];
    }

    protected static function normalizeItem(array $item): array
    {
        $title = self::firstNonEmpty($item, ['nama_lomba', 'title', 'judul', 'name', 'nama', 'prestasi']) ?? 'Prestasi Baru';
        $category = self::firstNonEmpty($item, ['kategori', 'category', 'tingkat', 'level']) ?? 'Prestasi';
        $yearValue = self::firstNonEmpty($item, ['tahun', 'year', 'tanggal_mulai', 'date', 'tanggal']) ?? now()->year;
        $date = self::firstNonEmpty($item, ['tanggal_mulai', 'date', 'tanggal', 'created_at', 'waktu']) ?? null;
        $location = self::firstNonEmpty($item, ['lokasi', 'location', 'tempat']) ?? '';
        $winner = self::extractWinner($item['peserta'] ?? [], $item);
        $winnerSocialLink = self::firstNonEmpty($item, ['winner_social_link', 'instagram', 'winner_instagram', 'link_instagram', 'social_link']) ?? '';
        $description = self::buildDescription($item);
        $image = self::firstNonEmpty($item, ['foto_url', 'image', 'foto', 'gambar', 'image_url', 'thumbnail', 'poster']) ?? 'images/achievement/prestasi1.jpg';
        $detailUrl = self::firstNonEmpty($item, ['detail_url', 'url', 'link', 'detail', 'source_url']) ?? '';

        $parsedYear = is_numeric($yearValue) ? (int) $yearValue : (int) (date('Y', strtotime((string) $yearValue)) ?: now()->year);
        $finalDate = self::normalizeDate($date, $parsedYear);

        return [
            'title' => trim((string) $title),
            'category' => trim((string) $category),
            'year' => $parsedYear,
            'date' => $finalDate,
            'location' => trim((string) $location),
            'winner' => trim((string) $winner),
            'winner_social_link' => trim((string) $winnerSocialLink),
            'description' => trim((string) $description),
            'image' => trim((string) $image),
            'detail_url' => trim((string) $detailUrl),
            'is_published' => false,
            'published_at' => null,
        ];
    }

    protected static function extractWinner(array $peserta, array $item): string
    {
        $winnerFromItem = self::firstNonEmpty($item, ['winner', 'pemenang', 'nama_pemenang', 'pelaku', 'winner_name']);

        if (! blank($winnerFromItem)) {
            return (string) $winnerFromItem;
        }

        if (empty($peserta) || ! is_array($peserta)) {
            return 'Siswa';
        }

        $names = array_map(function ($person) {
            if (! is_array($person)) {
                return null;
            }

            return trim((string) self::firstNonEmpty($person, ['nama', 'name']));
        }, $peserta);

        $names = array_values(array_filter($names, fn ($name) => $name !== '' && $name !== '0'));

        return $names[0] ?? 'Siswa';
    }

    protected static function buildDescription(array $item): string
    {
        $hasil = self::firstNonEmpty($item, ['hasil', 'result', 'prestasi', 'keterangan']) ?? '';
        $kategoriJuara = self::firstNonEmpty($item, ['kategori_juara', 'juara', 'award_category']) ?? '';
        $penyelenggara = self::firstNonEmpty($item, ['penyelenggara', 'organizer']) ?? '';
        $tingkat = self::firstNonEmpty($item, ['tingkat', 'level']) ?? '';

        $parts = array_filter([
            $hasil,
            $kategoriJuara,
            $tingkat,
            $penyelenggara,
        ], fn ($value) => ! blank($value));

        if (! empty($parts)) {
            return trim(implode(' • ', $parts));
        }

        return 'Prestasi dari SIPRES';
    }

    protected static function firstNonEmpty(array $item, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $item) && ! blank($item[$key])) {
                return $item[$key];
            }

            $segments = explode('.', $key);
            if (count($segments) > 1) {
                $value = self::deepGet($item, $segments);
                if (! blank($value)) {
                    return $value;
                }
            }
        }

        return null;
    }

    protected static function deepGet(array $data, array $segments): mixed
    {
        $current = $data;

        foreach ($segments as $segment) {
            if (! is_array($current) || ! array_key_exists($segment, $current)) {
                return null;
            }

            $current = $current[$segment];
        }

        return $current;
    }

    protected static function normalizeDate(mixed $value, int $fallbackYear): ?string
    {
        if (blank($value)) {
            return null;
        }

        $dateString = (string) $value;

        try {
            $parsed = \Illuminate\Support\Carbon::parse($dateString);

            return $parsed->format('Y-m-d');
        } catch (\Throwable $e) {
            return sprintf('%d-01-01', $fallbackYear);
        }
    }

    protected static function isList(array $value): bool
    {
        foreach ($value as $item) {
            if (is_array($item)) {
                return true;
            }
        }

        return false;
    }
}
