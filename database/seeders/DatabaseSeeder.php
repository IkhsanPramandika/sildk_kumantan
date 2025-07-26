<?php

namespace Database\Seeders;

use App\Models\VillagePotential;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ResidentSeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            GallerySeeder::class,
            ComplaintSeeder::class,
            VillagePotentialSeeder::class,
            VillageProfileSeeder::class,
            OrganizationSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
