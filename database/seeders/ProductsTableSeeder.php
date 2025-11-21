<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Shawarma',
                'description' => 'Roti pita dengan daging dan sayuran segar',
                'price' => 30000,
                'discounted_price' => 25000,
                'image_path' => 'images/feature/shawarma.jpg',
                'preparation_time' => 15
            ],
            [
                'name' => 'Chicken Katsu',
                'description' => 'Ayam katsu dengan nasi dan saus spesial',
                'price' => 28000,
                'image_path' => 'images/feature/ricebox.jpg',
                'preparation_time' => 10
            ],
            [
                'name' => 'Chickenplatter',
                'description' => 'Chicken Barista Platter',
                'price' => 38000,
                'image_path' => 'images/feature/chickenplatter.jpg',
                'preparation_time' => 15
            ],
            [
                'name' => 'Chicken Strip',
                'description' => 'Kulit Ayam Krispi',
                'price' => 18000,
                'image_path' => 'images/feature/chickenstrip.jpg',
                'preparation_time' => 10
            ],
            [
                'name' => 'French Fries',
                'description' => 'French Fries',
                'price' => 18000,
                'image_path' => 'images/feature/frencfries.jpg',
                'preparation_time' => 10
            ],
            [
                'name' => 'Satay',
                'description' => 'Ya sate ayam',
                'price' => 28000,
                'image_path' => 'images/feature/satay.jpg',
                'preparation_time' => 10
            ],
            
        ];
    
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
