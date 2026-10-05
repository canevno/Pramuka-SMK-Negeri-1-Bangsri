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

        // Prestasi yang dipilih (?id=) ditentukan di view, jadi urutan data tidak diubah di sini.
        return view('pages.prestasi.index', [
            'prestasi' => AchievementStore::published($tahun),
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