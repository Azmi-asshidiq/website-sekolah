<?php

// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@eduspace.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'kepsek@eduspace.com'],
            [
                'name' => 'Kepala Sekolah',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'kepsek',
            ]
        );

        User::firstOrCreate(
            ['email' => 'guru@eduspace.com'],
            [
                'name' => 'Guru Piket',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'guru',
            ]
        );
    }
}