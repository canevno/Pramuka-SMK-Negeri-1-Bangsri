<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaksanaRegistration;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranLaksanaAdminController extends Controller
{
    public function index()
    {
        $registrations = LaksanaRegistration::latest()->paginate(10);

        return view('admin.pendaftaran-laksana.index', compact('registrations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $map = [
            'pending' => 'pending',
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
        ];

        $registration = LaksanaRegistration::findOrFail($id);
        $registration->update([
            'status_verifikasi' => $map[$request->status] ?? 'pending',
        ]);

        Notification::query()->create([
            'title' => 'Status pendaftaran Laksana diperbarui',
            'message' => 'Pendaftaran ' . $registration->nama . ' berstatus ' . ucfirst($request->status) . '.',
            'type' => $request->status === 'approved' ? 'success' : ($request->status === 'rejected' ? 'warning' : 'info'),
            'is_read' => false,
            'url' => route('admin.pendaftaran-laksana'),
            'data' => [
                'registration_type' => 'laksana',
                'registration_id' => $registration->id,
                'status' => $request->status,
            ],
        ]);

        return redirect()->back()->with('success', 'Status pendaftaran Laksana berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $registration = LaksanaRegistration::findOrFail($id);

        if ($registration->surat_izin_path && Storage::disk('public')->exists($registration->surat_izin_path)) {
            Storage::disk('public')->delete($registration->surat_izin_path);
        }

        $registration->delete();

        return redirect()->back()->with('success', 'Data pendaftaran Laksana berhasil dihapus!');
    }

    public function showSurat($id)
    {
        $registration = LaksanaRegistration::findOrFail($id);

        if (! $registration->surat_izin_path) {
            abort(404);
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($registration->surat_izin_path)) {
            abort(404);
        }

        return view('admin.pendaftaran-laksana.surat', [
            'registration' => $registration,
            'fileUrl' => $disk->url($registration->surat_izin_path),
        ]);
    }

    public function downloadSurat($id)
    {
        $registration = LaksanaRegistration::findOrFail($id);

        if (! $registration->surat_izin_path) {
            abort(404);
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($registration->surat_izin_path)) {
            abort(404);
        }

        $fullPath = $disk->path($registration->surat_izin_path);
        $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^A-Za-z0-9 _.-]/', '', $registration->nama);
        $filename = 'Surat Pendaftaran Laksana ' . trim($safeName) . ($ext ? ('.' . $ext) : '');

        return response()->download($fullPath, $filename);
    }
}
