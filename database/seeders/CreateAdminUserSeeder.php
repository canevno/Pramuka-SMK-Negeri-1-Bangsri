<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'pramukasmkn1bangsri@gmail.com');
        $password = env('ADMIN_PASSWORD', 'Admin123!');

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update([
                'is_admin' => true,
                'email_verified_at' => $user->email_verified_at ?? now(),
                'password' => Hash::make($password),
            ]);
            return;
        }

        User::create([
            'name' => 'Administrator',
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);
    }
}
