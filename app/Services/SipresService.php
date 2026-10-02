<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SipresService
{
    private string $baseUrl = 'https://sipres.smkn1bangsri.sch.id/api/v1';

    public function getPrestasiPramuka(int $page = 1, ?int $tahun = null): array
    {
        $params = [
            'ekstrakurikuler' => 'Pramuka SMK Negeri 1 Bangsri',
            'page' => $page,
        ];

        if ($tahun !== null) {
            $params['tahun'] = $tahun;
        }

        $response = Http::timeout(15)
            ->acceptJson()
            ->get($this->baseUrl . '/prestasi', $params);

        if ($response->failed()) {
            return [
                'success' => false,
                'data' => [],
                'pagination' => [],
                'message' => 'Gagal mengambil data dari SIPRES.',
                'status' => $response->status(),
            ];
        }

        return $response->json();
    }
}