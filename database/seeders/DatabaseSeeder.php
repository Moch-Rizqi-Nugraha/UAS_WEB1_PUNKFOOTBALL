<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(ParticipantSeeder::class);
        $this->call(SampleDataSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
