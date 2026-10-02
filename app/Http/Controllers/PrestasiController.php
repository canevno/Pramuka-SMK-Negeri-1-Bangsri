<?php

namespace App\Http\Controllers;

use App\Support\AchievementStore;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->filled('tahun')
            ? (int) $request->tahun
            : null;

        $page = max((int) $request->get('page', 1), 1);
        $items = AchievementStore::published($tahun);
        $perPage = 12;
        $total = count($items);
        $offset = ($page - 1) * $perPage;
        $paginated = array_slice($items, $offset, $perPage);

        return view('pages.prestasi.index', [
            'prestasi' => $paginated,
            'pagination' => [
                'current_page' => $page,
                'last_page' => max(1, (int) ceil($total / $perPage)),
            ],
            'success' => true,
            'message' => null,
            'tahun' => $tahun,
        ]);
    }
}