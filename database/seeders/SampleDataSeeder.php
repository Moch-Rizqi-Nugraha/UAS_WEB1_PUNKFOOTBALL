<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Coach model doesn't exist - skipped
        
        // Create sample events
        \App\Models\Event::create([
            'name' => 'Turnamen Sepak Bola Kota',
            'description' => 'Turnamen sepak bola antar klub kota dengan hadiah menarik.',
            'event_date' => now()->addDays(30),
            'location' => 'Stadion Utama Kota',
            'category' => 'turnamen',
            'price' => 50000,
            'max_participants' => 16,
            'status' => 'active',
        ]);

        \App\Models\Event::create([
            'name' => 'Pelatihan Teknik Dasar',
            'description' => 'Pelatihan intensif untuk meningkatkan teknik dasar sepak bola.',
            'event_date' => now()->addDays(15),
            'location' => 'Lapangan Training Center',
            'category' => 'pelatihan',
            'price' => 25000,
            'max_participants' => 20,
            'status' => 'active',
        ]);

        // Create sample transactions
        \App\Models\Transaction::create([
            'user_id' => 1, // Assuming user with ID 1 exists
            'transaction_type' => 'event_registration',
            'item_name' => 'Turnamen Sepak Bola Kota',
            'amount' => 50000,
            'status' => 'completed',
            'transaction_data' => json_encode(['event_id' => 1]),
            'transaction_date' => now()->subDays(5),
        ]);
    }
}
