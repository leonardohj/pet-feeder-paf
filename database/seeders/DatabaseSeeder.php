<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@petfeeder.pt',
            'password' => 'admin',
            'avatar' => 'https://i.pravatar.cc/150?img=1',
            'role' => 'admin'
        ]);
    }
}