<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\BantaraRegistration;
use App\Models\PetugasAbsensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function parseNominalIuran($value): int
    {
        if (is_numeric($value) && (int) $value > 1) {
            return (int) $value;
        }

        $clean = strtolower(trim((string) $value));

        if (in_array($clean, ['ya', 'y', '1', 'true'])) {
            return 2000;
        }

        if (preg_match('/\d+/', $clean, $matches)) {
            return (int) $matches[0];
        }

        return 0;
    }

    public function index(Request $request)
    {
        $now = Carbon::now();

        $usersCount = User::count();
        $adminsCount = User::where('is_admin', true)->count();
        $activeThisWeek = User::where('updated_at', '>=', $now->copy()->subDays(7))->count();
        $pendingInvites = User::whereNull('email_verified_at')->count();
        $teamMembers = User::orderBy('created_at', 'desc')->take(6)->get();

        $attendanceCount = AttendanceRecord::count();
        $attendanceThisWeek = AttendanceRecord::whereBetween('record_date', [
            $now->copy()->startOfWeek()->toDateString(),
            $now->copy()->endOfWeek()->toDateString(),
        ])->count();
        $attendanceThisMonth = AttendanceRecord::whereMonth('record_date', $now->month)
            ->whereYear('record_date', $now->year)
            ->count();
        $attendanceThisYear = AttendanceRecord::whereYear('record_date', $now->year)->count();

        $attendanceStatus = [
            'Hadir' => AttendanceRecord::where('status', 'Hadir')->count(),
            'Izin' => AttendanceRecord::where('status', 'Izin')->count(),
            'Sakit' => AttendanceRecord::where('status', 'Sakit')->count(),
            'Alpha' => AttendanceRecord::whereIn('status', ['Alpha', 'Alpa', 'A'])->count(),
        ];

        $attendanceTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $attendanceTrend[] = [
                'label' => $date->translatedFormat('D'),
                'date' => $date->toDateString(),
                'value' => AttendanceRecord::whereDate('record_date', $date->toDateString())->count(),
            ];
        }

        $petugasTotal = PetugasAbsensi::count();
        $petugasAktif = PetugasAbsensi::where('is_active', true)->count();
        $petugasNonaktif = $petugasTotal - $petugasAktif;
        $petugasList = PetugasAbsensi::latest()->take(5)->get();

        $registrationCount = BantaraRegistration::count();
        $registrationVerified = BantaraRegistration::whereNotNull('status_verifikasi')->count();
        $registrationPending = BantaraRegistration::whereNull('status_verifikasi')->count();
        $latestRegistrations = BantaraRegistration::latest()->take(5)->get();

        $latestAttendanceRecords = AttendanceRecord::latest()->take(5)->get();

        $iuranTrend = [];
        $iuranTotal = 0;
        $iuranThisMonth = 0;
        $iuranThisYear = 0;
        $iuranAverageDay = 0;

        $allAttendance = AttendanceRecord::all();

        foreach ($allAttendance as $record) {
            $iuranValue = $this->parseNominalIuran($record->iuran ?? 0);
            $iuranTotal += $iuranValue;

            if ($record->record_date && Carbon::parse($record->record_date)->month === $now->month && Carbon::parse($record->record_date)->year === $now->year) {
                $iuranThisMonth += $iuranValue;
            }

            if ($record->record_date && Carbon::parse($record->record_date)->year === $now->year) {
                $iuranThisYear += $iuranValue;
            }
        }

        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dayTotal = AttendanceRecord::whereDate('record_date', $date->toDateString())
                ->get()
                ->sum(fn ($record) => $this->parseNominalIuran($record->iuran ?? 0));

            $iuranTrend[] = [
                'label' => $date->translatedFormat('D'),
                'value' => $dayTotal,
            ];
        }

        $iuranAverageDay = count($iuranTrend) > 0 ? (int) round(array_sum(array_column($iuranTrend, 'value')) / count($iuranTrend)) : 0;
        $maxTrendValue = collect($iuranTrend)->max('value') ?: 1;

        return view('dashboard', [
            'usersCount' => $usersCount,
            'adminsCount' => $adminsCount,
            'activeThisWeek' => $activeThisWeek,
            'pendingInvites' => $pendingInvites,
            'teamMembers' => $teamMembers,
            'attendanceCount' => $attendanceCount,
            'attendanceThisWeek' => $attendanceThisWeek,
            'attendanceThisMonth' => $attendanceThisMonth,
            'attendanceThisYear' => $attendanceThisYear,
            'attendanceStatus' => $attendanceStatus,
            'attendanceTrend' => $attendanceTrend,
            'maxTrendValue' => $maxTrendValue,
            'petugasTotal' => $petugasTotal,
            'petugasAktif' => $petugasAktif,
            'petugasNonaktif' => $petugasNonaktif,
            'petugasList' => $petugasList,
            'registrationCount' => $registrationCount,
            'registrationVerified' => $registrationVerified,
            'registrationPending' => $registrationPending,
            'latestRegistrations' => $latestRegistrations,
            'latestAttendanceRecords' => $latestAttendanceRecords,
            'iuranTotal' => $iuranTotal,
            'iuranThisMonth' => $iuranThisMonth,
            'iuranThisYear' => $iuranThisYear,
            'iuranAverageDay' => $iuranAverageDay,
            'iuranTrend' => $iuranTrend,
            'iuranMaxValue' => $maxTrendValue,
            'lastUpdated' => $now,
        ]);
    }
}
