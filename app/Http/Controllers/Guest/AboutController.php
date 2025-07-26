<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function index()
    {
        // Cache duration (in minutes)
        $cacheTtl = config('app.about.cache_ttl', 60);

        try {
            // Attempt to retrieve cached data
            $data = Cache::remember('about_page_data', $cacheTtl, function () {
                // Get village profile
                $villageProfile = VillageProfile::first();
                
                // Get statistics
                $stats = [
                    'total_residents' => Resident::count(),
                    'total_male' => Resident::where('gender', 'Laki-laki')->count(),
                    'total_female' => Resident::where('gender', 'Perempuan')->count(),
                    'total_area' => 10.5, // Placeholder, replace with actual data source
                ];
                
                return [
                    'villageProfile' => $villageProfile,
                    'stats' => $stats,
                ];
            });

            return Inertia::render('Guest/About', $data);
        } catch (\Exception $e) {
            // Log the error and return a fallback response
            \Log::error('Error fetching about page data: ' . $e->getMessage());
            return Inertia::render('Guest/About', [
                'villageProfile' => VillageProfile::first() ?? [],
                'stats' => [
                    'total_residents' => 0,
                    'total_male' => 0,
                    'total_female' => 0,
                    'total_area' => 0,
                ],
                'error' => 'Unable to load data at this time. Please try again later.',
            ]);
        }
    }
}
