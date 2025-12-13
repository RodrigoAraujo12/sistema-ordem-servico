<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Técnico 1',
            'email' => 'tecnico1@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
        ]);

        User::create([
            'name' => 'Técnico 2',
            'email' => 'tecnico2@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
        ]);
    }
}
