<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Create 20 sample news articles
        for ($i = 0; $i < 20; $i++) {
            $news = News::create([
                'title' => $faker->sentence(4),
                'content' => $faker->randomHtml(),
                'category' => $faker->randomElement(['umum', 'pemerintahan', 'kegiatan', 'pengumuman']),
                'publish_date' => $faker->dateTimeBetween('-3 months', 'now'),
                'status' => $faker->randomElement(['draft', 'published']),
            ]);
        }
    }
}
