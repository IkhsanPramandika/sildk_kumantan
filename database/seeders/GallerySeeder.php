<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Faker\Factory as Faker;
use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Create 20 sample galleries
        for ($i = 0; $i < 20; $i++) {
            Gallery::create([
                'title' => $faker->sentence(3),
                'description' => $faker->paragraphs(2, true),
                'is_published' => $faker->boolean(80),
            ]);

            $gallery = Gallery::latest()->first();
            // Create 1-3 images for each gallery
            $imageCount = $faker->numberBetween(1, 3);
            for ($j = 0; $j < $imageCount; $j++) {
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => 'galleries/gallery-' . $faker->numberBetween(1, 5) . '.jpg',
                    'caption' => $faker->sentence(),
                ]);
            }
        }
    }
}
