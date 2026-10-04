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

        $items = AchievementStore::published($tahun);

        return view('pages.prestasi.index', [
            'prestasi' => $items,
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1,
            ],
            'success' => true,
            'message' => null,
            'tahun' => $tahun,
        ]);
    }
}