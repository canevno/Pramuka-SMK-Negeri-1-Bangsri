<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\SipresPrestasiSync;

class PrestasiSyncController extends Controller
{
    public function sync()
    {
        try {
            $result = SipresPrestasiSync::sync();

            return response()->json([
                'success' => true,
                'message' => 'Sinkronisasi prestasi SIPRES berhasil.',
                'data' => $result,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
