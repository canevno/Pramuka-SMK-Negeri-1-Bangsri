<?php

namespace App\Http\Middleware;

use App\Models\VisitorDevice;
use Closure;
use Illuminate\Http\Request;

class TrackVisitorDevice
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldSkipTracking($request)) {
            return $next($request);
        }

        $userAgent = (string) $request->header('User-Agent', '');
        $ipAddress = $request->ip() ?: $request->server('REMOTE_ADDR', 'unknown');

        $blockedByIdentity = VisitorDevice::query()
            ->where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->whereNotNull('blocked_at')
            ->first();

        if ($blockedByIdentity) {
            abort(403, 'Perangkat Anda diblokir dari situs ini.');
        }

        $fingerprint = hash('sha256', $ipAddress.'|'.$userAgent.'|'.($request->header('Accept-Language', '')));

        $device = VisitorDevice::query()->firstOrNew([
            'fingerprint' => $fingerprint,
        ]);

        if ($device->exists && $device->is_blocked) {
            abort(403, 'Perangkat Anda diblokir dari situs ini.');
        }

        $device->ip_address = $ipAddress;
        $device->user_agent = $userAgent;
        $device->browser = $this->detectBrowser($userAgent);
        $device->platform = $this->detectPlatform($userAgent);
        $device->device_label = $this->detectDeviceLabel($userAgent, $device->platform);
        $device->visit_count = (int) $device->visit_count + 1;
        $device->last_seen_at = now();
        $device->save();

        if ($device->is_blocked) {
            abort(403, 'Perangkat Anda diblokir dari situs ini.');
        }

        return $next($request);
    }

    protected function shouldSkipTracking(Request $request): bool
    {
        if ($request->is('admin/*') || $request->is('admin') || $request->is('login') || $request->is('logout')) {
            return true;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return true;
        }

        if (str_contains($request->path(), 'storage') || str_contains($request->path(), 'livewire')) {
            return true;
        }

        return false;
    }

    protected function detectBrowser(string $userAgent): ?string
    {
        if (preg_match('/Edg(?:e|A|iOS)?\//i', $userAgent)) {
            return 'Edge';
        }

        if (preg_match('/OPR\//i', $userAgent)) {
            return 'Opera';
        }

        if (preg_match('/Chrome\//i', $userAgent)) {
            return 'Chrome';
        }

        if (preg_match('/Firefox\//i', $userAgent)) {
            return 'Firefox';
        }

        if (preg_match('/Safari\//i', $userAgent)) {
            return 'Safari';
        }

        return $userAgent !== '' ? 'Lainnya' : null;
    }

    protected function detectPlatform(string $userAgent): ?string
    {
        if (preg_match('/Windows/i', $userAgent)) {
            return 'Windows';
        }

        if (preg_match('/Macintosh|Mac OS/i', $userAgent)) {
            return 'macOS';
        }

        if (preg_match('/Android/i', $userAgent)) {
            return 'Android';
        }

        if (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            return 'iOS';
        }

        if (preg_match('/Linux/i', $userAgent)) {
            return 'Linux';
        }

        return $userAgent !== '' ? 'Lainnya' : null;
    }

    protected function detectDeviceLabel(string $userAgent, ?string $platform): string
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent)) {
            return 'Handphone';
        }

        if ($platform !== null) {
            return ucfirst(strtolower($platform)).' Desktop';
        }

        return 'Perangkat Tidak Dikenali';
    }
}
