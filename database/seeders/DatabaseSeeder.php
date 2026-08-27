<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Membuat atau memperbarui akun admin secara permanen
        User::updateOrCreate(
            ['email' => 'pramukasmkn1bangsri@gmail.com'],
            [
                'name'     => 'Super Admin Pramuka',
                'password' => Hash::make('dewanambalan0'),
                'is_admin' => true, // Sesuaikan jika menggunakan 'role' => 'admin'
            ]
        );
    }
}
