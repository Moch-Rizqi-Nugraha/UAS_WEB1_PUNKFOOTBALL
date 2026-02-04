<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sepatu Bola Nike Phantom',
                'description' => 'Sepatu bola profesional dengan teknologi terkini untuk performa maksimal',
                'price' => 2500000,
                'stock' => 15,
            ],
            [
                'name' => 'Bola Sepak Adidas Official',
                'description' => 'Bola resmi premium untuk pertandingan dan latihan',
                'price' => 450000,
                'stock' => 25,
            ],
            [
                'name' => 'Jersey Nasional Home',
                'description' => 'Jersey resmi dengan desain modern dan bahan berkualitas',
                'price' => 350000,
                'stock' => 30,
            ],
            [
                'name' => 'Sarung Tangan Kiper Puma',
                'description' => 'Sarung tangan kiper dengan grip maksimal dan kenyamanan optimal',
                'price' => 280000,
                'stock' => 12,
            ],
            [
                'name' => 'Shin Guard Professional',
                'description' => 'Pelindung kaki berkualitas tinggi untuk keamanan maksimal',
                'price' => 150000,
                'stock' => 20,
            ],
            [
                'name' => 'Bola Training Mikasa',
                'description' => 'Bola latihan berkualitas bagus untuk training harian',
                'price' => 200000,
                'stock' => 18,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
