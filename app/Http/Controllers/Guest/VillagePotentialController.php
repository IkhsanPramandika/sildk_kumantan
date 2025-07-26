<?php

namespace App\Http\Controllers\Guest;

use Inertia\Inertia;
use App\Models\VillagePotential;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class VillagePotentialController extends Controller
{
    public function naturalResources()
    {
        try {
            $data = Cache::remember('natural_resources', 60, function () {
                $potentials = VillagePotential::where('category', 'sda')
                    ->latest()
                    ->get();

                return [
                    'potentials' => $potentials,
                ];
            });

            return Inertia::render('Guest/Potentials/NaturalResources', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching natural resources: ' . $e->getMessage());

            return Inertia::render('Guest/Potentials/NaturalResources', [
                'potentials' => [],
                'error' => 'Unable to load data at this time.',
            ]);
        }
    }

    public function infrastructure()
    {
        try {
            $data = Cache::remember('infrastruktur', 60, function () {
                $potentials = VillagePotential::where('category', 'infrastruktur')
                    ->latest()
                    ->get();

                return [
                    'potentials' => $potentials,
                ];
            });

            return Inertia::render('Guest/Potentials/Infrastructure', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching infrastructure: ' . $e->getMessage());

            return Inertia::render('Guest/Potentials/Infrastructure', [
                'potentials' => [],
                'error' => 'Unable to load data at this time.',
            ]);
        }
    }

    public function show(VillagePotential $potential)
    {
        try {
            $data = [
                'potential' => [
                    'id' => $potential->id,
                    'category' => $potential->category === 'sda' ? 'sumber-daya-alam' : 'infrastruktur',
                    'title' => $potential->title,
                    'description' => $potential->description,
                    'image_url' => $potential->image_url,
                    'slug' => $potential->slug,
                    'created_at' => $potential->created_at,
                    'updated_at' => $potential->updated_at,
                ],
                'relatedPotentials' => VillagePotential::where('category', $potential->category)
                    ->where('id', '!=', $potential->id)
                    ->take(3)
                    ->get()
                    ->map(function ($related) {
                        return [
                            'id' => $related->id,
                            'title' => $related->title,
                            'category' => $related->category === 'sda' ? 'sumber-daya-alam' : 'infrastruktur',
                            'description' => $related->description,
                            'image_url' => $related->image_url,
                            'slug' => $related->slug,
                        ];
                    }),
            ];

            return Inertia::render('Guest/Potentials/Show', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching potential detail: ' . $e->getMessage());
            abort(404);
        }
    }
}
