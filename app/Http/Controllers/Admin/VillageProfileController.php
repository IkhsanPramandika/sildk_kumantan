<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VillageProfileController extends Controller
{
    public function edit()
    {
        $villageProfile = VillageProfile::firstOrCreate(
            [],
            ['village_history' => '', 'village_history_image' => null]
        );

        return Inertia::render('Admin/VillageProfile/Edit', [
            'villageProfile' => $villageProfile
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'organization_structure_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $villageProfile = VillageProfile::first();

        if ($request->hasFile('organization_structure_image')) {
            // Delete old image if exists
            if ($villageProfile->organization_structure_image) {
                Storage::delete($villageProfile->organization_structure_image);
            }

            // Store new image
            $path = $request->file('organization_structure_image')->store('village-profile', 'public');
            $villageProfile->organization_structure_image = $path;
        }

        $villageProfile->save();

        return redirect()->back()->with('success', 'Profil desa berhasil diperbarui');
    }
}
