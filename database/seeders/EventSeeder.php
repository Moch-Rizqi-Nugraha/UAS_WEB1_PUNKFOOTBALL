<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Punk Football Championship 2026',
                'description' => 'Annual punk football championship featuring the best teams in the region.',
                'event_date' => now()->addDays(30),
                'location' => 'Stadium Utama Jakarta',
                'category' => 'turnamen',
                'status' => 'active',
                'price' => 50000,
                'max_participants' => 32,
                'current_participants' => 0,
            ],
            [
                'name' => 'Youth Football Training Camp',
                'description' => 'Intensive training camp for young football enthusiasts aged 12-18.',
                'event_date' => now()->addDays(15),
                'location' => 'Lapangan ABC Surabaya',
                'category' => 'pelatihan',
                'status' => 'active',
                'price' => 25000,
                'max_participants' => 20,
                'current_participants' => 0,
            ],
            [
                'name' => 'Football Skills Workshop',
                'description' => 'Learn advanced football skills from professional coaches.',
                'event_date' => now()->addDays(7),
                'location' => 'Gedung Olahraga Bandung',
                'category' => 'pelatihan',
                'status' => 'active',
                'price' => 75000,
                'max_participants' => 30,
                'current_participants' => 0,
            ],
            [
                'name' => 'Community Football Match',
                'description' => 'Friendly community football match open to all skill levels.',
                'event_date' => now()->addDays(3),
                'location' => 'Lapangan Desa Medan',
                'category' => 'friendly_match',
                'status' => 'active',
                'price' => 0,
                'max_participants' => 22,
                'current_participants' => 0,
            ],
            [
                'name' => 'Football Tactics Seminar',
                'description' => 'Learn modern football tactics and strategies.',
                'event_date' => now()->subDays(5),
                'location' => 'Hotel Grand Bali',
                'category' => 'pelatihan',
                'status' => 'completed',
                'price' => 100000,
                'max_participants' => 100,
                'current_participants' => 0,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
