<?php

namespace Database\Seeders;

use App\Models\Resident;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ResidentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Create 50 sample residents
        for ($i = 0; $i < 50; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $birthDate = $faker->dateTimeBetween('-70 years', '-17 years');

            $occupationList = [
                'Pelajar/Mahasiswa',
                'Belum/Tidak Bekerja',
                'Mengurus Rumah Tangga',
                'Karyawan Swasta',
                'Nelayan/Perikanan',
                'Petani/Pekebun'
            ];

            Resident::create([
                'nik' => $faker->unique()->numerify('################'),
                'family_card_number' => $faker->numerify('################'),
                'full_name' => $faker->name($gender),
                'address' => $faker->address(),
                'rt' => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'rw' => str_pad($faker->numberBetween(1, 5), 3, '0', STR_PAD_LEFT),
                'hamlet' => 'Dusun ' . $faker->randomElement(['A', 'B', 'C', 'D']),
                'birth_place' => $faker->city(),
                'birth_date' => $birthDate,
                'gender' => $gender,
                'religion' => $faker->randomElement(['islam', 'christian', 'catholic', 'hindu', 'buddhist', 'confucian', 'other']),
                'marital_status' => $faker->randomElement(['single', 'married', 'divorced', 'widowed']),
                'occupation' => $faker->randomElement($occupationList),
                'last_education' => $faker->randomElement(['none', 'elementary', 'junior_high', 'senior_high', 'd1', 'd2', 'd3', 's1', 's2', 's3']),
                'blood_type' => $faker->randomElement(['A', 'B', 'AB', 'O', 'Unknown']),
                'citizenship' => 'wni',
                'life_status' => 'alive',
                'mother_name' => $faker->optional(0.9)->name('female'),
                'father_name' => $faker->optional(0.9)->name('male'),
                'family_relationship_status' => $faker->optional(0.9)->randomElement(['head', 'wife', 'child', 'other']),
                'disability_type' => $faker->optional(0.1)->randomElement(['tuna_netra', 'tuna_rungu', 'tuna_daksa', 'tuna_grahita', 'tuna_laras']),
            ]);
        }
    }
}
