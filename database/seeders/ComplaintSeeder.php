<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\Resident;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ComplaintSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Get all resident IDs
        $residentIds = Resident::pluck('id')->toArray();

        // Create 25 sample complaints
        for ($i = 0; $i < 25; $i++) {
            $complaintNumber = 'COMP-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);

            Complaint::create([
                'complaint_number' => $complaintNumber,
                'resident_id' => $faker->randomElement($residentIds),
                'title' => $faker->sentence(3),
                'description' => $faker->paragraphs(2, true),
                'category' => $faker->randomElement(['infrastructure', 'service', 'social', 'economy', 'other']),
                'status' => $faker->randomElement(['received', 'in_progress', 'completed', 'rejected']),
                'response_date' => $faker->optional(0.7)->dateTimeBetween('-6 months', 'now'),
                'response' => $faker->optional(0.7)->paragraph()
            ]);
        }
    }
}
