<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Participant;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'status' => 'pending',
        ]);

        Participant::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'status' => 'pending',
        ]);

        Participant::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'status' => 'approved',
        ]);
    }
}
