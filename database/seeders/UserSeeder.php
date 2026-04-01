<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin (Untuk mengelola semua event & tiket)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@quicktick.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Organizer (Untuk pembuat acara)
        User::create([
            'name' => 'Event Organizer',
            'email' => 'organizer@quicktick.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
        ]);

        // 3. Akun User Biasa (Untuk pembeli tiket yang melihat dashboard katalog)
        User::create([
            'name' => 'Regular User',
            'email' => 'user@quicktick.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}