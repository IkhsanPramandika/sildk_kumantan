<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DemographicsController extends Controller
{
    public function index()
    {
        // Get total population statistics
        $totalPopulation = Resident::count();
        $malePopulation = Resident::where('gender', 'male')->count();
        $femalePopulation = Resident::where('gender', 'female')->count();
        $totalFamilies = Resident::where('family_relationship_status', 'kepala keluarga')->count();

        // Standar pekerjaan utama
        $jobList = [
            'PELAJAR/MAHASISWA',
            'BELUM/TIDAK BEKERJA',
            'MENGURUS RUMAH TANGGA',
            'KARYAWAN SWASTA',
            'PEGAWAI NEGERI SIPIL',
            'PETANI/PEKEBUN',
            'GURU',
            'KEPOLISIAN RI',
            'WIRASWASTA',
            
        ];
        // Ambil count dari database
        $occupationCounts = Resident::select('occupation', DB::raw('count(*) as count'))
            ->whereNotNull('occupation')
            ->groupBy('occupation')
            ->pluck('count', 'occupation');
        // Susun statistik sesuai urutan
        $jobStatistics = collect($jobList)->map(function ($label) use ($occupationCounts) {
            return [
                'type' => $label,
                'count' => $occupationCounts[$label] ?? 0
            ];
        });

        // Get education statistics
        $educationStatistics = Resident::select('last_education', DB::raw('count(*) as count'))
            ->groupBy('last_education')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'level' => $this->getEducationDisplayName($item->last_education),
                    'count' => $item->count
                ];
            });

        // Get age statistics
        $ageStatistics = Resident::select(
            DB::raw('CASE
                WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) < 18 THEN "0-17 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 30 THEN "18-30 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 31 AND 50 THEN "31-50 Tahun"
                ELSE "51+ Tahun"
            END as age_range'),
            DB::raw('count(*) as count')
        )
            ->groupBy('age_range')
            ->orderBy('age_range')
            ->get()
            ->map(function ($item) {
                return [
                    'range' => $item->age_range,
                    'count' => $item->count
                ];
            });

        // Statistik agama
        $religionStatistics = Resident::select('religion', DB::raw('count(*) as count'))
            ->groupBy('religion')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => $this->getReligionDisplayName($item->religion),
                    'count' => $item->count
                ];
            });

        // If no data from database, use default data
        if ($jobStatistics->isEmpty()) {
            $jobStatistics = collect([
                ['type' => 'Pelajar/Mahasiswa', 'count' => 0],
                ['type' => 'Belum/Tidak Bekerja', 'count' => 0],
                ['type' => 'Mengurus Rumah Tangga', 'count' => 0],
                ['type' => 'Karyawan Swasta', 'count' => 0],
                ['type' => 'Nelayan/Perikanan', 'count' => 0],
                ['type' => 'Petani/Pekebun', 'count' => 0],
                ['type' => 'Wiraswasta', 'count' => 0]
            ]);
        }

        if ($educationStatistics->isEmpty()) {
            $educationStatistics = collect([
                ['level' => 'Tidak/Belum Sekolah', 'count' => 0],
                ['level' => 'SD/Sederajat', 'count' => 0],
                ['level' => 'SMP/Sederajat', 'count' => 0],
                ['level' => 'SMA/Sederajat', 'count' => 0],
                ['level' => 'Diploma', 'count' => 0],
                ['level' => 'Sarjana', 'count' => 0]
            ]);
        }

        if ($ageStatistics->isEmpty()) {
            $ageStatistics = collect([
                ['range' => '0-17 Tahun', 'count' => 0],
                ['range' => '18-30 Tahun', 'count' => 0],
                ['range' => '31-50 Tahun', 'count' => 0],
                ['range' => '51+ Tahun', 'count' => 0]
            ]);
        }

        if ($religionStatistics->isEmpty()) {
            $religionStatistics = collect([
                ['type' => 'Islam', 'count' => 0],
                ['type' => 'Kristen', 'count' => 0],
                ['type' => 'Katolik', 'count' => 0],
                ['type' => 'Hindu', 'count' => 0],
                ['type' => 'Buddha', 'count' => 0],
                ['type' => 'Konghucu', 'count' => 0],
                ['type' => 'Lainnya', 'count' => 0]
            ]);
        }

        return Inertia::render('Guest/Profile/Demographics', [
            'totalPopulation' => $totalPopulation,
            'malePopulation' => $malePopulation,
            'femalePopulation' => $femalePopulation,
            'totalFamilies' => $totalFamilies,
            'jobStatistics' => $jobStatistics,
            'educationStatistics' => $educationStatistics,
            'ageStatistics' => $ageStatistics,
            'religionStatistics' => $religionStatistics,
        ]);
    }

    private function getEducationDisplayName($education)
    {
        $educationNames = [
            'none' => 'Tidak/Belum Sekolah',
            'elementary' => 'SD/Sederajat',
            'junior_high' => 'SMP/Sederajat',
            'senior_high' => 'SMA/Sederajat',
            'd1' => 'Diploma I',
            'd2' => 'Diploma II',
            'd3' => 'Diploma III',
            's1' => 'Sarjana',
            's2' => 'Magister',
            's3' => 'Doktor'
        ];

        return $educationNames[$education] ?? $education;
    }

    private function getReligionDisplayName($religion)
    {
        $religionNames = [
            'islam' => 'Islam',
            'christian' => 'Kristen',
            'catholic' => 'Katolik',
            'hindu' => 'Hindu',
            'buddhist' => 'Buddha',
            'confucian' => 'Konghucu',
            'other' => 'Lainnya'
        ];

        return $religionNames[$religion] ?? $religion;
    }
}
