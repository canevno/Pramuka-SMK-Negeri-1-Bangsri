<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BantaraRegistration; // Sesuaikan nama model Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranAdminController extends Controller
{
    /**
     * Menampilkan daftar pendaftar Bantara
     */
    public function index()
    {
        $registrations = BantaraRegistration::latest()->paginate(10);

        return view('admin.pendaftaran.index', compact('registrations'));
    }

    /**
     * Memperbarui status pendaftaran (Pending / Approved / Rejected)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $registration = BantaraRegistration::findOrFail($id);
        $registration->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    /**
     * Menghapus data pendaftar beserta file surat izinnya
     */
    public function destroy($id)
    {
        $registration = BantaraRegistration::findOrFail($id);

        // Hapus file surat izin dari storage jika ada
        if ($registration->surat_izin_path && Storage::exists($registration->surat_izin_path)) {
            Storage::delete($registration->surat_izin_path);
        }

        $registration->delete();

        return redirect()->back()->with('success', 'Data pendaftaran berhasil dihapus!');
    }
}