<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\BantaraRegistration;
use App\Models\GalleryItem;
use App\Models\LaksanaRegistration;
use App\Models\PetugasAbsensi;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

        $bantaraRegistrations = BantaraRegistration::query()
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($row) {
                return [
                    'name' => $row->nama,
                    'kelas' => $row->kelas,
                    'date' => $row->created_at?->translatedFormat('d M Y') ?? '-',
                    'status' => ucfirst(str_replace('_', ' ', $row->status_verifikasi ?? 'pending')),
                    'type' => 'Bantara',
                ];
            })
            ->all();

        $laksanaRegistrations = LaksanaRegistration::query()
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($row) {
                return [
                    'name' => $row->nama,
                    'kelas' => $row->kelas,
                    'date' => $row->created_at?->translatedFormat('d M Y') ?? '-',
                    'status' => ucfirst(str_replace('_', ' ', $row->status_verifikasi ?? 'pending')),
                    'type' => 'Laksana',
                ];
            })
            ->all();

        $latestRegistrations = array_merge($bantaraRegistrations, $laksanaRegistrations);
        usort($latestRegistrations, function ($a, $b) {
            return strtotime($b['date']) <=> strtotime($a['date']);
        });
        $latestRegistrations = array_slice($latestRegistrations, 0, 6);

        $visitorStats = collect(range(6, 0))->map(function ($offset) {
            $date = now()->subDays($offset)->startOfDay();
            $start = $date->copy()->startOfDay()->timestamp;
            $end = $date->copy()->endOfDay()->timestamp;

            $count = 0;

            if (Schema::hasTable('sessions')) {
                $count = (int) DB::table('sessions')
                    ->where('last_activity', '>=', $start)
                    ->where('last_activity', '<=', $end)
                    ->count();
            }

            return [
                'label' => $date->translatedFormat('D'),
                'day' => $date->translatedFormat('d'),
                'count' => $count,
            ];
        })->values()->all();

        $visitorTotalThisWeek = array_sum(array_column($visitorStats, 'count'));
        $registrationCount = BantaraRegistration::count() + LaksanaRegistration::count();
        $latestNews = Post::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(3)
            ->get()
            ->map(function ($post) {
                return [
                    'title' => $post->title,
                    'date' => $post->published_at?->translatedFormat('d M Y') ?? 'Tanggal belum diatur',
                    'type' => $post->type ?: 'Berita',
                    'image' => $post->image_path ? asset($post->image_path) : null,
                    'excerpt' => $post->excerpt ?: str($post->content ?? '')->stripTags()->limit(90)->toString(),
                ];
            })
            ->all();

        return view('dashboard', [
            'usersCount' => $usersCount,
            'adminsCount' => $adminsCount,
            'activeThisWeek' => $activeThisWeek,
            'pendingInvites' => $pendingInvites,
            'teamMembers' => $teamMembers,
            'newsCount' => Post::count(),
            'galleryCount' => GalleryItem::count(),
            'registrationCount' => $registrationCount,
            'attendanceCount' => $attendanceCount,
            'latestAttendanceRecords' => $latestAttendanceRecords,
            'petugasTeraktif' => $petugasTeraktif,
            'subSanggaTeraktif' => $subSanggaTeraktif,
            'latestRegistrations' => $latestRegistrations,
            'latestNews' => $latestNews,
            'visitorStats' => $visitorStats,
            'visitorTotalThisWeek' => $visitorTotalThisWeek,
        ]);
    }
}
