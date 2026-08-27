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

        // Map frontend status values to DB enum values
        $map = [
            'pending' => 'pending',
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
        ];

        $registration = BantaraRegistration::findOrFail($id);
        $newStatus = $map[$request->status] ?? 'pending';

        $registration->update([
            'status_verifikasi' => $newStatus,
        ]);

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    /**
     * Menghapus data pendaftar beserta file surat izinnya
     */
    public function destroy($id)
    {
        $registration = BantaraRegistration::findOrFail($id);

        // Hapus file surat izin dari public disk jika ada
        if ($registration->surat_izin_path && Storage::disk('public')->exists($registration->surat_izin_path)) {
            Storage::disk('public')->delete($registration->surat_izin_path);
        }

        $registration->delete();

        return redirect()->back()->with('success', 'Data pendaftaran berhasil dihapus!');
    }

    /**
     * Tampilkan atau download file surat izin untuk admin.
     */
    public function showSurat($id)
    {
        $registration = BantaraRegistration::findOrFail($id);
        if (! $registration->surat_izin_path) {
            \Log::warning('showSurat: missing path for registration', ['id' => $id]);
            abort(404);
        }
        $disk = Storage::disk('public');
        $exists = $disk->exists($registration->surat_izin_path);
        \Log::info('showSurat: serving surat (wrapper)', ['id' => $id, 'path' => $registration->surat_izin_path, 'exists' => $exists]);

        if (! $exists) {
            \Log::warning('showSurat: file not found on disk', ['id' => $id, 'path' => $registration->surat_izin_path]);
            abort(404);
        }

        $fileUrl = $disk->url($registration->surat_izin_path);

        // Return an HTML wrapper so the page title can include the registrant's name
        return view('admin.pendaftaran.surat', [
            'registration' => $registration,
            'fileUrl' => $fileUrl,
        ]);
    }

    /**
     * Download surat izin with a friendly filename so it can be opened in Word/Office.
     */
    public function downloadSurat($id)
    {
        $registration = BantaraRegistration::findOrFail($id);
        if (! $registration->surat_izin_path) abort(404);

        $disk = Storage::disk('public');
        if (! $disk->exists($registration->surat_izin_path)) abort(404);

        $fullPath = $disk->path($registration->surat_izin_path);
        $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^A-Za-z0-9 _.-]/', '', $registration->nama);
        $filename = 'Surat Pendaftaran ' . trim($safeName) . ($ext ? ('.' . $ext) : '');

        return response()->download($fullPath, $filename);
    }
}