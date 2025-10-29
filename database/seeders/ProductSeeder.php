<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate(); // clear existing data if needed

        Product::insert([
            [
                'name' => 'MacBook Pro 16"',
                'price' => 2999.00,
                'stock_quantity' => 10,
                'description' => 'Apple MacBook Pro M3 Max — 16-inch Retina Display',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gaming Laptop',
                'price' => 1599.00,
                'stock_quantity' => 20,
                'description' => 'High performance laptop for gamers with RTX graphics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wireless Mouse',
                'price' => 39.99,
                'stock_quantity' => 50,
                'description' => 'Ergonomic wireless mouse with long battery life',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mechanical Keyboard',
                'price' => 89.00,
                'stock_quantity' => 25,
                'description' => 'RGB backlit mechanical keyboard for fast typists',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Noise Cancelling Headphones',
                'price' => 199.00,
                'stock_quantity' => 15,
                'description' => 'Premium ANC headphones for immersive audio experience',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
