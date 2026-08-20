<?php

namespace App\Http\Controllers;

use App\Models\PetugasAbsensi;
use App\Models\Notification;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'kelas' => 'required|string',
            'nta'   => 'required|string',
        ]);

        $petugas = PetugasAbsensi::where('nta', trim($request->nta))
            ->whereRaw('LOWER(nama) = ?', [strtolower(trim($request->name))])
            ->first();

        if (! $petugas) {
            return back()->with('absensi_verify_error', 'NTA atau Nama petugas tidak terdaftar.');
        }

        if (! $petugas->is_approved) {
            return back()->with('absensi_verify_error', 'Akun petugas Anda belum disetujui oleh Admin.');
        }

        if (! $petugas->is_active) {
            return back()->with('absensi_verify_error', 'Status petugas Anda saat ini Tidak Aktif.');
        }

        // Set session in the shape expected by AttendanceController and the Blade view
        session([
            'absensi_verified' => [
                'name' => $petugas->nama,
                'kelas' => $request->kelas,
                'nta' => $petugas->nta,
            ],
            'absensi_petugas_id' => $petugas->id,
        ]);

        $petugas->update(['terakhir_melakukan' => now()]);

        // Trigger notification for admin dashboard
        Notification::create([
            'title' => 'Verifikasi Absensi Baru',
            'message' => "Petugas {$petugas->nama} baru saja melakukan verifikasi absensi kelas {$request->kelas}.",
            'type' => 'info',
        ]);

        return redirect()->route('absensi.lanjut');
    }

    public function showAbsensiForm(Request $request)
    {
        return app(\App\Http\Controllers\AttendanceController::class)->index($request);
    }
}
