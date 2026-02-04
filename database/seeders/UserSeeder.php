<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'john@punkfootball.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'jane@punkfootball.com'],
            [
                'name' => 'Jane Smith',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'bob@punkfootball.com'],
            [
                'name' => 'Bob Johnson',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}
