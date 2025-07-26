<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Sample product categories with their specific data
        $categories = [
            'food' => [
                'names' => [
                    'Keripik Pisang',
                    'Dodol Garut',
                    'Kue Basah',
                    'Makanan Tradisional',
                    'Kue Kering',
                    'Keripik Singkong',
                    'Sambal Goreng',
                    'Manisan Buah',
                ],
                'descriptions' => [
                    'Produk makanan tradisional yang dibuat dengan bahan-bahan pilihan dan resep turun temurun.',
                    'Makanan khas daerah yang diproduksi dengan standar kebersihan tinggi.',
                    'Produk makanan homemade yang dibuat dengan cinta dan perhatian khusus.',
                ]
            ],
            'craft' => [
                'names' => [
                    'Tas Rajut',
                    'Kerajinan Bambu',
                    'Batik Tulis',
                    'Ukiran Kayu',
                    'Anyaman Rotan',
                    'Kerajinan Logam',
                    'Tenun Ikat',
                    'Kerajinan Kulit',
                ],
                'descriptions' => [
                    'Kerajinan tangan yang dibuat dengan teliti oleh pengrajin lokal.',
                    'Produk kerajinan tradisional yang mempertahankan nilai budaya.',
                    'Kerajinan unik yang menggabungkan tradisi dan modernitas.',
                ]
            ],
            'agriculture' => [
                'names' => [
                    'Bibit Tanaman',
                    'Sayuran Organik',
                    'Buah-buahan Segar',
                    'Bibit Cabai',
                    'Bibit Tomat',
                    'Sayuran Hidroponik',
                    'Bibit Buah',
                    'Tanaman Hias',
                ],
                'descriptions' => [
                    'Produk pertanian organik yang ditanam dengan metode ramah lingkungan.',
                    'Hasil pertanian segar yang dipanen langsung dari kebun.',
                    'Bibit tanaman berkualitas yang dijamin pertumbuhannya.',
                ]
            ],
            'fashion' => [
                'names' => [
                    'Batik Modern',
                    'Dress Batik',
                    'Kemeja Batik',
                    'Sarung Tenun',
                    'Kain Tenun',
                    'Pakaian Tradisional',
                    'Aksesoris Batik',
                    'Selendang Batik',
                ],
                'descriptions' => [
                    'Produk fashion yang menggabungkan tradisi dan gaya modern.',
                    'Pakaian tradisional dengan sentuhan kontemporer.',
                    'Fashion item yang dibuat dengan bahan berkualitas dan desain eksklusif.',
                ]
            ],
        ];

        // Create 20 sample products
        for ($i = 0; $i < 20; $i++) {
            // Select random category
            $category = $faker->randomElement(array_keys($categories));
            $categoryData = $categories[$category];

            // Create product
            $product = Product::create([
                'name' => $faker->randomElement($categoryData['names']),
                'description' => $faker->randomElement($categoryData['descriptions']),
                'price' => $faker->numberBetween(10000, 500000),
                'category' => $category,
                'status' => $faker->randomElement(['draft', 'published']),
                'owner_name' => $faker->name,
                'owner_phone' => '62' . $faker->numerify('##########'),
                'owner_address' => $faker->address,
            ]);

            // Create 1-3 images for each product
            $imageCount = $faker->numberBetween(1, 3);
            for ($j = 0; $j < $imageCount; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => 'products/placeholder.jpg', // You'll need to add actual images to storage
                    'caption' => $faker->optional()->sentence,
                    'order' => $j,
                ]);
            }
        }
    }
}
