<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            if ($this->shouldTrack($request, $response)) {
                $hash = hash('sha256', $request->ip() . '|' . $request->userAgent() . '|' . config('app.key'));

                $visit = SiteVisit::firstOrCreate(
                    ['visit_date' => now()->toDateString(), 'visitor_hash' => $hash],
                    ['hits' => 1, 'last_path' => mb_substr($request->path(), 0, 255)]
                );

                if (! $visit->wasRecentlyCreated) {
                    $visit->increment('hits', 1, ['last_path' => mb_substr($request->path(), 0, 255)]);
                }
            }
        } catch (\Throwable $e) {
            // Jangan sampai tracking merusak halaman
            report($e);
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET') || $request->ajax() || $request->expectsJson()) {
            return false;
        }

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        // Jangan hitung area admin / login / API
        if ($request->is('admin*', 'login*', 'logout', 'dashboard*', 'api/*', 'livewire/*')) {
            return false;
        }

        // Jangan hitung user yang sedang login (admin)
        if ($request->user()) {
            return false;
        }

        // Abaikan bot
        $agent = strtolower((string) $request->userAgent());
        if ($agent === '' || preg_match('/bot|crawl|spider|slurp|facebookexternalhit|curl|wget|headless/', $agent)) {
            return false;
        }

        return true;
    }
}