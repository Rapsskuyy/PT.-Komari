<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'username'  => 'admin',
                'full_name' => 'Administrator',
                'email'     => 'admin@ptkomari.com',
                'password'  => bcrypt('admin123'),
                'role'      => 'admin',
            ]);
            $this->command->info('Admin user created.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
