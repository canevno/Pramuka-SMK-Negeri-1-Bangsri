<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::query()->latest()->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markRead(Request $request, Notification $notification)
    {
        $notification->update(['is_read' => true]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi telah dibaca.',
            ]);
        }

        return redirect()->back();
    }

    public function markAllRead()
    {
        Notification::query()->where('is_read', false)->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi telah dibaca.');
    }

    public function visit(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        $targetUrl = $notification->url ?: route('admin.notifications.index');

        if (! str_starts_with($targetUrl, 'http')) {
            return redirect()->to($targetUrl);
        }

        return redirect()->away($targetUrl);
    }
}
