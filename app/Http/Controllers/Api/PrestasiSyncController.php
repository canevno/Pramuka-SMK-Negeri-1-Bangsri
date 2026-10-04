<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class PrestasiSyncController extends Controller
{
    public function sync()
    {
        return response()->json([
            'success' => false,
            'message' => 'Sinkronisasi prestasi melalui SIPRES telah dinonaktifkan.',
        ], 410);
    }
}
