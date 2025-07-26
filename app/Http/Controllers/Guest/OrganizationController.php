<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\VillageProfile;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OrganizationController extends Controller
{
    public function history()
    {
        try {
            $data = Cache::remember('village_history_territory', 60, function () {
                $villageProfile = VillageProfile::first();

                // Data wilayah desa default
                $territoryInfo = [
                    'area' => '15.5',
                    'altitude' => '35',
                    'rt_count' => 12,
                    'rw_count' => 5,
                    'postal_code' => '28412'
                ];

                $boundaries = [
                    'north' => 'Kelurahan Bangkinang',
                    'south' => 'Desa Pulau Lawas',
                    'east' => 'Desa Batu Belah',
                    'west' => 'Kelurahan Langgini'
                ];



                return [
                    'villageProfile' => $villageProfile ? [
                        'history' => $villageProfile->village_history,
                        'history_image' => $villageProfile->village_history_image
                    ] : null,
                    'territoryInfo' => $territoryInfo,
                    'boundaries' => $boundaries,
                ];
            });

            return Inertia::render('Guest/Organization/History', $data);
        } catch (\Exception $e) {

            Log::error('Error fetching village history: ' . $e->getMessage());

            return Inertia::render('Guest/Organization/History', [
                'villageProfile' => null,
                'error' => 'Unable to load data at this time.',
                'territoryInfo' => [
                    'area' => '15.5',
                    'altitude' => '35',
                    'rt_count' => 12,
                    'rw_count' => 5,
                    'postal_code' => '28412'
                ],
                'boundaries' => [
                    'north' => 'Kelurahan Bangkinang',
                    'south' => 'Desa Pulau Lawas',
                    'east' => 'Desa Batu Belah',
                    'west' => 'Kelurahan Langgini'
                ],
            ]);
        }
    }

    public function structure()
    {
        try {
            $data = Cache::remember('organization_structure', 60, function () {
                $villageProfile = VillageProfile::first();

                return [
                    'organization' => $villageProfile ? [
                        'title' => $villageProfile->title,
                        'description' => $villageProfile->description,
                        'structure_image' => $villageProfile->organization_structure_image,
                    ] : null,
                ];
            });

            return Inertia::render('Guest/Organization/Structure', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching organization structure: ' . $e->getMessage());

            return Inertia::render('Guest/Organization/Structure', [
                'organization' => null,
                'error' => 'Unable to load data at this time.',
            ]);
        }
    }

    public function bpd()
    {
        try {
            $data = Cache::remember('bpd_organization', 60, function () {
                $bpd = Organization::where('type', 'bpd')->first();

                return [
                    'organization' => $bpd ? [
                        'title' => $bpd->title,
                        'description' => $bpd->description,
                        'structure_image' => $bpd->structure_image,
                    ] : null,
                ];
            });

            return Inertia::render('Guest/Organization/BPD', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching BPD data: ' . $e->getMessage());

            return Inertia::render('Guest/Organization/BPD', [
                'organization' => null,
                'error' => 'Unable to load data at this time.',
            ]);
        }
    }

    public function karangTaruna()
    {
        try {
            $data = Cache::remember('karang_taruna_organization', 60, function () {
                $karangTaruna = Organization::where('type', 'karang-taruna')->first();

                return [
                    'organization' => $karangTaruna ? [
                        'title' => $karangTaruna->title,
                        'description' => $karangTaruna->description,
                        'structure_image' => $karangTaruna->structure_image,
                    ] : null,
                ];
            });

            return Inertia::render('Guest/Organization/KarangTaruna', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching Karang Taruna data: ' . $e->getMessage());

            return Inertia::render('Guest/Organization/KarangTaruna', [
                'organization' => null,
                'error' => 'Unable to load data at this time.',
            ]);
        }
    }

    public function pkk()
    {
        try {
            $data = Cache::remember('pkk_organization', 60, function () {
                $pkk = Organization::where('type', 'pkk')->first();

                return [
                    'organization' => $pkk ? [
                        'title' => $pkk->title,
                        'description' => $pkk->description,
                        'structure_image' => $pkk->structure_image,
                    ] : null,
                ];
            });

            return Inertia::render('Guest/Organization/PKK', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching PKK data: ' . $e->getMessage());

            return Inertia::render('Guest/Organization/PKK', [
                'organization' => null,
                'error' => 'Unable to load data at this time.',
            ]);
        }
    }
}
