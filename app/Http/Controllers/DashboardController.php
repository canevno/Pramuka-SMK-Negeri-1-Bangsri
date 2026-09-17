<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\PetugasAbsensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $usersCount = User::count();
        $adminsCount = User::where('is_admin', true)->count();
        $activeThisWeek = User::where('updated_at', '>=', now()->subDays(7))->count();
        $pendingInvites = User::whereNull('email_verified_at')->count();
        $teamMembers = User::orderBy('created_at', 'desc')->take(8)->get();
        $attendanceCount = AttendanceRecord::count();
        $latestAttendanceRecords = AttendanceRecord::latest()->take(5)->get();

        $registeredPetugas = PetugasAbsensi::query()
            ->select(['id', 'nama', 'nta', 'kelas_petugas', 'is_active', 'photo_url'])
            ->get();

        $attendanceStats = AttendanceRecord::query()
            ->select('petugas_name', 'petugas_nta', 'petugas_kelas')
            ->selectRaw('MAX(created_at) as last_seen')
            ->selectRaw('COUNT(*) as total_records')
            ->groupBy('petugas_name', 'petugas_nta', 'petugas_kelas')
            ->get();

        $attendanceStatsByKey = [];

        foreach ($attendanceStats as $record) {
            $keys = [];

            if (! empty($record->petugas_nta)) {
                $keys[] = strtolower(trim((string) $record->petugas_nta));
            }

            if (! empty($record->petugas_name)) {
                $keys[] = strtolower(trim((string) $record->petugas_name));
            }

            foreach (array_unique($keys) as $key) {
                $attendanceStatsByKey[$key] = [
                    'name' => $record->petugas_name,
                    'nta' => $record->petugas_nta,
                    'kelas' => $record->petugas_kelas,
                    'total_records' => (int) $record->total_records,
                    'last_seen' => $record->last_seen ? Carbon::parse($record->last_seen) : null,
                ];
            }
        }

        $petugasTeraktif = $registeredPetugas->map(function ($petugas) use ($attendanceStatsByKey) {
            $keys = [];

            if (! empty($petugas->nta)) {
                $keys[] = strtolower(trim((string) $petugas->nta));
            }

            if (! empty($petugas->nama)) {
                $keys[] = strtolower(trim((string) $petugas->nama));
            }

            $stats = null;
            foreach ($keys as $key) {
                if (isset($attendanceStatsByKey[$key])) {
                    $stats = $attendanceStatsByKey[$key];
                    break;
                }
            }

            $lastSeen = $stats['last_seen'] ?? null;

            return [
                'name' => $petugas->nama,
                'kelas' => $petugas->kelas_petugas ?? '-',
                'status' => $petugas->is_active ? 'Aktif' : 'Non-Aktif',
                'total_records' => (int) ($stats['total_records'] ?? 0),
                'last_seen' => $lastSeen ? $lastSeen->translatedFormat('d M Y') : 'Belum ada absensi',
                'last_seen_timestamp' => $lastSeen ? $lastSeen->timestamp : 0,
                'initial' => strtoupper(substr($petugas->nama, 0, 1)),
                'photo_url' => $petugas->photo_url ? asset($petugas->photo_url) : null,
            ];
        })->values()->all();

        usort($petugasTeraktif, function ($a, $b) {
            if ($a['total_records'] !== $b['total_records']) {
                return $b['total_records'] <=> $a['total_records'];
            }

            return $b['last_seen_timestamp'] <=> $a['last_seen_timestamp'];
        });

        $petugasTeraktif = array_slice($petugasTeraktif, 0, 4);

        $subSanggaTeraktif = AttendanceRecord::query()
            ->whereNotNull('participant_sangga')
            ->where('participant_sangga', '!=', '')
            ->where('status', 'Hadir')
            ->select('participant_sangga as nama_sub_sangga', 'participant_ambalan as ambalan', 'bulan')
            ->selectRaw('COUNT(*) as total_hadir')
            ->groupBy('participant_sangga', 'participant_ambalan', 'bulan')
            ->orderByDesc('total_hadir')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'nama_sub_sangga' => $row->nama_sub_sangga,
                'ambalan' => $row->ambalan ?: 'Umum',
                'total_hadir' => (int) $row->total_hadir,
                'bulan' => $row->bulan ?: 'Belum ada',
            ])
            ->values()
            ->all();

        return view('dashboard', [
            'usersCount' => $usersCount,
            'adminsCount' => $adminsCount,
            'activeThisWeek' => $activeThisWeek,
            'pendingInvites' => $pendingInvites,
            'teamMembers' => $teamMembers,
            'newsCount' => 45,
            'galleryCount' => 214,
            'registrationCount' => 28,
            'attendanceCount' => $attendanceCount,
            'latestAttendanceRecords' => $latestAttendanceRecords,
            'petugasTeraktif' => $petugasTeraktif,
            'subSanggaTeraktif' => $subSanggaTeraktif,
        ]);
    }
}
