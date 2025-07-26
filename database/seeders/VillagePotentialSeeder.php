<?php

namespace Database\Seeders;

use App\Models\VillagePotential;
use Illuminate\Database\Seeder;

class VillagePotentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $potentials = [
            [
                'title' => 'Jembatan Desa Utama',
                'category' => 'infrastruktur',
                'description' => 'Jembatan utama yang menghubungkan dua wilayah desa dengan kondisi baik dan strategis untuk akses transportasi.',
                'image' => 'village-potentials/jembatan.jpg',
            ],
            [
                'title' => 'Sumber Air Pegunungan',
                'category' => 'sda',
                'description' => 'Sumber mata air alami yang jernih dan melimpah, berpotensi untuk dikembangkan sebagai sumber air bersih desa.',
                'image' => 'village-potentials/sumber-air.jpg',
            ],
            [
                'title' => 'Balai Desa',
                'category' => 'infrastruktur',
                'description' => 'Gedung balai desa yang dapat digunakan untuk berbagai kegiatan masyarakat dan pemerintahan desa.',
                'image' => 'village-potentials/balai-desa.jpg',
            ],
            [
                'title' => 'Hutan Bambu',
                'category' => 'sda',
                'description' => 'Area hutan bambu yang luas dengan potensi untuk industri kerajinan dan bahan bangunan ramah lingkungan.',
                'image' => 'village-potentials/hutan-bambu.jpg',
            ],
        ];

        foreach ($potentials as $potential) {
            VillagePotential::create($potential);
        }
    }
}
