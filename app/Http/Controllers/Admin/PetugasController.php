<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PetugasAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();

        // 1. Rentang Waktu Akurat
        $startOfWeek = $now->copy()->startOfWeek()->format('Y-m-d');
        $endOfWeek   = $now->copy()->endOfWeek()->format('Y-m-d');
        $currentYear = $now->year;
        $currentMonth = $now->month;

        // Label Tampilan Card
        $currentWeekLabel = "Minggu Ke-" . $now->weekOfMonth . " (" . $now->copy()->startOfWeek()->format('d M') . " - " . $now->copy()->endOfWeek()->format('d M Y') . ")";
        $currentMonthKey  = $now->translatedFormat('F Y');
        $currentYearLabel = $currentYear;

        // 2. TOTAL ABSENSI: Menghitung total seluruh siswa/anak yang diabsensi
        $totalAbsensiAnak = DB::table('attendances')->count();

        // 3. MINGGU INI: Menghitung jumlah sesi rekam kelas (Putra & Putri) minggu ini
        $rekamMingguIni = DB::table('attendances')
            ->whereBetween(DB::raw('DATE(record_date)'), [$startOfWeek, $endOfWeek])
            ->select(DB::raw('COUNT(DISTINCT CONCAT(IFNULL(participant_kelas, ""), "_", DATE(record_date))) as total'))
            ->value('total') ?? 0;

        // 4. BULAN INI: Menghitung jumlah sesi rekam kelas (Putra & Putri) bulan ini
        $rekamBulanIni = DB::table('attendances')
            ->whereYear('record_date', $currentYear)
            ->whereMonth('record_date', $currentMonth)
            ->select(DB::raw('COUNT(DISTINCT CONCAT(IFNULL(participant_kelas, ""), "_", DATE(record_date))) as total'))
            ->value('total') ?? 0;

        // 5. TAHUN INI: Menghitung jumlah sesi rekam kelas (Putra & Putri) tahun ini
        $rekamTahunIni = DB::table('attendances')
            ->whereYear('record_date', $currentYear)
            ->select(DB::raw('COUNT(DISTINCT CONCAT(IFNULL(participant_kelas, ""), "_", DATE(record_date))) as total'))
            ->value('total') ?? 0;

        // 6. Data Petugas & Total Rekam Per Petugas
        $petugas = PetugasAbsensi::latest()->get()->map(function ($p) {
            $countFromAttendances = DB::table('attendances')
                ->where('petugas_nta', trim($p->nta))
                ->select(DB::raw('COUNT(DISTINCT CONCAT(IFNULL(participant_kelas, ""), "_", DATE(record_date))) as total'))
                ->value('total');

            $p->jumlah_rekam = $countFromAttendances > 0 ? $countFromAttendances : ($p->attributes['jumlah_rekam'] ?? 0);

            return $p;
        });

        return view('admin.petugas', compact(
            'petugas',
            'totalAbsensiAnak',
            'rekamMingguIni',
            'rekamBulanIni',
            'rekamTahunIni',
            'currentWeekLabel',
            'currentMonthKey',
            'currentYearLabel'
        ));
    }

    public function storePetugas(Request $request)
    {
        // Tambahkan validasi jenis_kelamin
        $request->validate([
            'nama'          => 'required|string',
            'nta'           => 'required|string|unique:petugas_absensis,nta',
            'kelas_petugas' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        // Simpan jenis_kelamin ke database
        $petugas = PetugasAbsensi::create([
            'nama'          => trim($request->nama),
            'nta'           => trim($request->nta),
            'kelas_petugas' => trim($request->kelas_petugas),
            'jenis_kelamin' => $request->jenis_kelamin,
            'is_approved'   => true,
            'is_active'     => true,
            'jumlah_rekam'  => 0,
        ]);

        Notification::create([
            'title'   => 'Petugas Baru Ditambahkan',
            'message' => "Admin menambahkan petugas baru: {$petugas->nama} ({$petugas->kelas_petugas}).",
            'type'    => 'success',
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
            'title'   => "Petugas {$statusStr}",
            'message' => "Status keaktifan petugas {$petugas->nama} diubah menjadi " . strtolower($statusStr) . " oleh Admin.",
            'type'    => $petugas->is_active ? 'info' : 'warning',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'   => true,
                'is_active' => (bool) $petugas->is_active,
                'message'   => "Status petugas {$petugas->nama} berhasil diubah.",
            ]);
        }

        return back()->with('success', "Status petugas {$petugas->nama} berhasil diubah.");
    }

    public function markAllNotificationsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    public function fetchNotifications(Request $request)
    {
        $items = Notification::latest()->take(10)->get();
        $count = Notification::where('is_read', false)->count();

        return response()->json([
            'success'     => true,
            'unreadCount' => $count,
            'notifications' => $items->map(function ($n) {
                return [
                    'id'         => $n->id,
                    'title'      => $n->title,
                    'message'    => $n->message,
                    'type'       => $n->type,
                    'is_read'    => (bool) $n->is_read,
                    'created_at' => $n->created_at->toIso8601String(),
                ];
            }),
        ]);
    }

    public function markNotificationRead(Request $request, $id)
    {
        $notif = Notification::findOrFail($id);
        $notif->is_read = true;
        $notif->save();

        return response()->json([
            'success'      => true,
            'notification' => [
                'id'         => $notif->id,
                'title'      => $notif->title,
                'message'    => $notif->message,
                'type'       => $notif->type,
                'is_read'    => (bool) $notif->is_read,
                'created_at' => $notif->created_at->toIso8601String(),
            ],
            'unreadCount' => Notification::where('is_read', false)->count(),
        ]);
    }
}