<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        $users = User::where('role', '!=', 'admin')->get();

        if ($events->isEmpty() || $users->isEmpty()) {
            return;
        }

        $statuses = ['registered', 'confirmed', 'cancelled'];

        foreach ($events as $event) {
            // Add 1-3 participants per event (limited by available users)
            $numParticipants = rand(1, min(3, $users->count()));

            $selectedUsers = $users->random($numParticipants);

            foreach ($selectedUsers as $user) {
                EventParticipant::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'status' => $statuses[array_rand($statuses)],
                    'registered_at' => now()->subDays(rand(0, 7)),
                ]);
            }

            // Update current participants count
            $confirmedCount = $event->confirmedParticipants()->count();
            $event->update(['current_participants' => $confirmedCount]);
        }
    }
}
