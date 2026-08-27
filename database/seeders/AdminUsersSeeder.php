<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'pramukasmkn1bangsri@gmail.com',
                'password' => 'dewanambalan0',
            ],
            [
                'name' => 'Dewan Ambalan',
                'email' => 'dewan.ambalan@example.com',
                'password' => 'dewanambalan0',
            ],
            [
                'name' => 'Bendahara',
                'email' => 'bendahara@example.com',
                'password' => 'bendahara0',
            ],
            [
                'name' => 'Pembina',
                'email' => 'pembina@example.com',
                'password' => 'pembina0',
            ],
        ];

        foreach ($users as $u) {
            $user = User::where('email', $u['email'])->first();
            if (! $user) {
                $user = User::create([
                    'name' => $u['name'],
                    'email' => $u['email'],
                    'password' => Hash::make($u['password']),
                    'email_verified_at' => now(),
                ]);
            } else {
                $user->name = $u['name'];
                $user->password = Hash::make($u['password']);
                $user->email_verified_at = now();
                $user->save();
            }

            // mark as admin
            $user->is_admin = true;
            $user->save();
        }
    }
}
