<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        // Create sample products with inventory
        $products = [
            [
                'sku' => 'PROD001',
                'name' => 'Premium Wireless Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation and premium sound quality.',
                'price' => 299.99,
                'inventory' => [
                    'quantity' => 50,
                    'security_stock' => 10,
                    'location' => 'Warehouse A',
                ],
            ],
            [
                'sku' => 'PROD002',
                'name' => 'Smart Watch Series 5',
                'description' => 'Advanced smartwatch with health monitoring, GPS, and long battery life.',
                'price' => 399.99,
                'inventory' => [
                    'quantity' => 30,
                    'security_stock' => 5,
                    'location' => 'Warehouse A',
                ],
            ],
            [
                'sku' => 'PROD003',
                'name' => 'Ultra HD 4K Monitor',
                'description' => '32-inch 4K monitor with HDR support and adjustable stand.',
                'price' => 499.99,
                'inventory' => [
                    'quantity' => 20,
                    'security_stock' => 3,
                    'location' => 'Warehouse B',
                ],
            ],
            [
                'sku' => 'PROD004',
                'name' => 'Mechanical Gaming Keyboard',
                'description' => 'RGB mechanical keyboard with customizable keys and wrist rest.',
                'price' => 149.99,
                'inventory' => [
                    'quantity' => 75,
                    'security_stock' => 15,
                    'location' => 'Warehouse B',
                ],
            ],
            [
                'sku' => 'PROD005',
                'name' => 'Wireless Gaming Mouse',
                'description' => 'High-precision wireless gaming mouse with adjustable DPI and RGB lighting.',
                'price' => 79.99,
                'inventory' => [
                    'quantity' => 100,
                    'security_stock' => 20,
                    'location' => 'Warehouse A',
                ],
            ],
        ];

        foreach ($products as $productData) {
            $inventory = $productData['inventory'];
            unset($productData['inventory']);

            $product = Product::create($productData);
            $product->inventory()->create($inventory);
        }

        // Create sample sales
        $saleDates = [
            now()->subDays(30),
            now()->subDays(25),
            now()->subDays(20),
            now()->subDays(15),
            now()->subDays(10),
            now()->subDays(5),
            now()->subDays(2),
            now()->subDay(),
        ];

        foreach ($saleDates as $date) {
            // Create 2-5 sales per day
            $salesCount = rand(2, 5);
            
            for ($i = 0; $i < $salesCount; $i++) {
                $saleId = 'SALE-' . Str::random(8);
                $products = Product::inRandomOrder()->take(rand(1, 3))->get();

                foreach ($products as $product) {
                    SaleItem::create([
                        'sale_id' => $saleId,
                        'product_id' => $product->id,
                        'quantity' => rand(1, 3),
                        'sale_date' => $date,
                    ]);
                }
            }
        }
    }
}
