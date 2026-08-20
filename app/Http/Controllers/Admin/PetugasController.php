<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PetugasAbsensi;
use App\Models\AttendanceRecord;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $petugas = AttendanceRecord::query()
            ->select('petugas_name', 'petugas_nta', 'petugas_kelas')
            ->selectRaw('MAX(created_at) as last_seen')
            ->selectRaw('COUNT(*) as total_records')
            ->groupBy('petugas_name', 'petugas_nta', 'petugas_kelas')
            ->orderByDesc('last_seen')
            ->get()
            ->map(function ($record) {
                $lastSeen = Carbon::parse($record->last_seen);
                $activeThreshold = now()->subDays(14);

                return [
                    'name' => $record->petugas_name,
                    'nta' => $record->petugas_nta,
                    'kelas' => $record->petugas_kelas,
                    'last_seen' => $lastSeen,
                    'total_records' => $record->total_records,
                    'status' => $lastSeen->greaterThan($activeThreshold) ? 'Aktif' : 'Tidak Aktif',
                    'last_seen_text' => $lastSeen->translatedFormat('d F Y H:i'),
                ];
            });

        return view('admin.petugas', [
            'petugas' => $petugas,
        ]);
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nta' => 'required|string|unique:petugas_absensis,nta',
            'kelas_petugas' => 'required|string',
        ]);

        $petugas = PetugasAbsensi::create([
            'nama' => trim($request->nama),
            'nta' => trim($request->nta),
            'kelas_petugas' => trim($request->kelas_petugas),
            'is_approved' => true,
            'is_active' => true,
        ]);
        // Trigger notification
        Notification::create([
            'title' => 'Petugas Baru Ditambahkan',
            'message' => "Admin menambahkan petugas baru: {$petugas->nama} ({$petugas->kelas_petugas}).",
            'type' => 'success',
        ]);

        return back()->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function toggleStatus(Request $request, $id)
    {
        $petugas = PetugasAbsensi::findOrFail($id);
        $petugas->is_active = ! $petugas->is_active;
        $petugas->save();

        $statusStr = $petugas->is_active ? 'Diaktifkan' : 'Dinonaktifkan';

        Notification::create([
            'title' => "Petugas {$statusStr}",
            'message' => "Status petugas {$petugas->nama} diubah menjadi " . strtolower($statusStr) . " oleh Admin.",
            'type' => $petugas->is_active ? 'info' : 'warning',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => (bool) $petugas->is_active,
                'message' => "Status petugas {$petugas->nama} berhasil diubah.",
            ]);
        }

        return back()->with('success', "Status petugas {$petugas->nama} berhasil diubah.");
    }

    public function markAllNotificationsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    /**
     * Return latest notifications as JSON for admin polling
     */
    public function fetchNotifications(Request $request)
    {
        $items = Notification::latest()->take(10)->get();
        $count = Notification::where('is_read', false)->count();

        return response()->json([
            'success' => true,
            'unreadCount' => $count,
            'notifications' => $items->map(function ($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->title,
                    'message' => $n->message,
                    'type' => $n->type,
                    'is_read' => (bool) $n->is_read,
                    'created_at' => $n->created_at->toIso8601String(),
                ];
            }),
        ]);
    }

    /**
     * Mark a single notification as read and return its data
     */
    public function markNotificationRead(Request $request, $id)
    {
        $notif = Notification::findOrFail($id);
        $notif->is_read = true;
        $notif->save();

        return response()->json([
            'success' => true,
            'notification' => [
                'id' => $notif->id,
                'title' => $notif->title,
                'message' => $notif->message,
                'type' => $notif->type,
                'is_read' => (bool) $notif->is_read,
                'created_at' => $notif->created_at->toIso8601String(),
            ],
            'unreadCount' => Notification::where('is_read', false)->count(),
        ]);
    }
}
