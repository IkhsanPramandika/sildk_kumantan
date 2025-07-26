<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VillageHistoryController extends Controller
{
    public function edit()
    {
        $villageProfile = VillageProfile::firstOrCreate(
            [], // Attributes to match (empty means first record)
            ['village_history' => '', 'village_history_image' => null] // Default values if created
        );

        return Inertia::render('Admin/VillageHistory/Edit', [
            'villageProfile' => [
                'id' => $villageProfile->id,
                'village_history' => $villageProfile->village_history,
                'village_history_image' => $villageProfile->village_history_image
                    ? Storage::url($villageProfile->village_history_image)
                    : null
            ]
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'village_history' => 'required|string',
            'village_history_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $villageProfile = VillageProfile::firstOrCreate(
            [], // Attributes to match (empty means first record)
            ['village_history' => '', 'village_history_image' => null]
        );

        if ($request->hasFile('village_history_image')) {
            // Delete old image if exists
            if ($villageProfile->village_history_image) {
                Storage::delete($villageProfile->village_history_image);
            }

            // Store new image
            $path = $request->file('village_history_image')->store('village-profile', 'public');
            $villageProfile->village_history_image = $path;
        }

        $villageProfile->village_history = $request->village_history;
        $villageProfile->save();

        return redirect()->back()->with('success', 'Sejarah desa berhasil diperbarui');
    }
}
