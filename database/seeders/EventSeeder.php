<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // Create 15 sample events
        for ($i = 0; $i < 15; $i++) {
            $category = $faker->randomElement(['kegiatan', 'rapat', 'acara', 'lainnya']);
            $event = Event::create([
                'title' => $faker->sentence(3),
                'description' => $faker->randomHtml(),
                'category' => $category,
                'start_date' => $faker->dateTimeBetween('now', '+2 months'),
                'location' => $faker->address(),
                'end_date' => $faker->dateTimeBetween('+2 months', '+4 months'),
                'status' => $faker->randomElement(['draft', 'published', 'archived']),
            ]);
        }
    }
}
