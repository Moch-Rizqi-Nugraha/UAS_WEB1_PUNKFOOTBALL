<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return; // Skip if no users exist
        }

        $transactions = [
            [
                'user_id' => $users->first()->id,
                'transaction_type' => 'event_registration',
                'item_name' => 'Punk Football Championship 2026',
                'amount' => 50000,
                'status' => 'completed',
                'transaction_data' => json_encode(['event_id' => 1]),
                'transaction_date' => now()->subDays(10),
            ],
            [
                'user_id' => $users->first()->id,
                'transaction_type' => 'marketplace_purchase',
                'item_name' => 'Football Boots Nike Mercurial',
                'amount' => 750000,
                'status' => 'completed',
                'transaction_data' => json_encode(['product_id' => 1]),
                'transaction_date' => now()->subDays(8),
            ],
            [
                'user_id' => $users->skip(1)->first()?->id ?? $users->first()->id,
                'transaction_type' => 'coaching_session',
                'item_name' => 'Private Training with Ahmad Rahman',
                'amount' => 150000,
                'status' => 'completed',
                'transaction_data' => json_encode(['coach_id' => 1, 'duration' => 60]),
                'transaction_date' => now()->subDays(5),
            ],
            [
                'user_id' => $users->skip(2)->first()?->id ?? $users->first()->id,
                'transaction_type' => 'event_registration',
                'item_name' => 'Youth Football Training Camp',
                'amount' => 25000,
                'status' => 'completed',
                'transaction_data' => json_encode(['event_id' => 2]),
                'transaction_date' => now()->subDays(3),
            ],
            [
                'user_id' => $users->skip(3)->first()?->id ?? $users->first()->id,
                'transaction_type' => 'marketplace_purchase',
                'item_name' => 'Training Cone Set',
                'amount' => 150000,
                'status' => 'completed',
                'transaction_data' => json_encode(['product_id' => 2]),
                'transaction_date' => now()->subDays(1),
            ],
            [
                'user_id' => $users->first()->id,
                'transaction_type' => 'event_registration',
                'item_name' => 'Football Skills Workshop',
                'amount' => 75000,
                'status' => 'pending',
                'transaction_data' => json_encode(['event_id' => 3]),
                'transaction_date' => now(),
            ],
            [
                'user_id' => $users->skip(1)->first()?->id ?? $users->first()->id,
                'transaction_type' => 'coaching_session',
                'item_name' => 'Group Training with Siti Nurhaliza',
                'amount' => 100000,
                'status' => 'completed',
                'transaction_data' => json_encode(['coach_id' => 2, 'duration' => 90]),
                'transaction_date' => now()->subDays(12),
            ],
            [
                'user_id' => $users->skip(2)->first()?->id ?? $users->first()->id,
                'transaction_type' => 'marketplace_purchase',
                'item_name' => 'Football Jersey Set',
                'amount' => 200000,
                'status' => 'completed',
                'transaction_data' => json_encode(['product_id' => 3]),
                'transaction_date' => now()->subDays(7),
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }
    }
}
