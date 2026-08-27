<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('role')) {
            session(['auth_role' => $request->query('role')]);
        }

        $query = http_build_query([
            'client_id'     => config('services.google.client_id'),
            'redirect_uri'  => config('services.google.redirect'),
            'response_type' => 'code',
            'scope'         => 'openid profile email',
            'prompt'        => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    public function handleGoogleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect('/admin/login')->withErrors(['msg' => 'Autentikasi Google dibatalkan.']);
        }

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id'     => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri'  => config('services.google.redirect'),
            'grant_type'    => 'authorization_code',
            'code'          => $request->code,
        ]);

        if ($response->failed()) {
            return redirect('/admin/login')->withErrors(['msg' => 'Gagal mendapatkan token dari Google.']);
        }

        $tokenData = $response->json();

        $userResponse = Http::withToken($tokenData['access_token'])
            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($userResponse->failed()) {
            return redirect('/admin/login')->withErrors(['msg' => 'Gagal mengambil informasi profil Google.']);
        }

        $googleUser = $userResponse->json();
        $role = session('auth_role', 'dewan_ambalan');

        $user = User::updateOrCreate(
            ['email' => $googleUser['email']],
            [
                'name'      => $googleUser['name'] ?? $googleUser['email'],
                'google_id' => $googleUser['sub'],
                'role'      => $role,
                'password'  => bcrypt(str()->random(16))
            ]
        );

        Auth::login($user);
        session()->forget('auth_role');

        return redirect()->intended('/dashboard');
    }
}