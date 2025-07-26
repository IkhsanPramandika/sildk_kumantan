<?php

namespace Database\Seeders;

use App\Models\VillageProfile;
use Illuminate\Database\Seeder;

class VillageProfileSeeder extends Seeder
{
    public function run(): void
    {
        VillageProfile::create([
            'organization_structure_image' => 'village-profile/organization-structure.jpg',
            'village_history' => '<p>Desa ini berdiri sejak tahun 1900 dan memiliki sejarah panjang dalam perkembangan masyarakatnya...</p>',
            'village_history_image' => 'village-profile/village-history.jpg',
        ]);
    }
}
