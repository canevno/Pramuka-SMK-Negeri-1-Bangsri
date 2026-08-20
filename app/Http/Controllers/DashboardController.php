<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\BantaraRegistration;
use App\Models\User;
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

        $registrationCount = BantaraRegistration::count();
        $latestRegistrations = BantaraRegistration::latest()->take(5)->get();

            return view('dashboard', [
            'usersCount' => $usersCount,
            'adminsCount' => $adminsCount,
            'activeThisWeek' => $activeThisWeek,
            'pendingInvites' => $pendingInvites,
            'teamMembers' => $teamMembers,
            'newsCount' => 45,
            'galleryCount' => 214,
            'registrationCount' => $registrationCount,
            'latestRegistrations' => $latestRegistrations,
            'attendanceCount' => $attendanceCount,
            'latestAttendanceRecords' => $latestAttendanceRecords,
        ]);
    }
}