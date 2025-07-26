<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'karang-taruna');
        $organizations = Organization::where('type', $type)->get();

        return Inertia::render('Admin/Organizations/Index', [
            'organizations' => $organizations,
            'type' => $type
        ]);
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'karang-taruna');
        return Inertia::render('Admin/Organizations/Create', [
            'type' => $type
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'type' => 'required|string|in:karang-taruna,bpd,pkk',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('organizations', 'public');
            $validated['image'] = $path;
        }

        Organization::create($validated);

        return redirect()->route('admin.organizations.index', ['type' => $validated['type']])
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($type)
    {
        $organization = Organization::where('type', $type)->first();
        $typeLabel = Organization::TYPES[$type] ?? $type;

        if (!$organization) {
            $organization = new Organization([
                'type' => $type,
                'title' => $typeLabel,
                'description' => '',
            ]);
        }

        return Inertia::render('Admin/Organizations/Edit', [
            'organization' => $organization,
            'type' => $type,
            'typeLabel' => $typeLabel
        ]);
    }

    public function update(Request $request, $type)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'structure_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $organization = Organization::where('type', $type)->first();

        if (!$organization) {
            $organization = new Organization();
            $organization->type = $type;
        }

        $organization->title = $request->title;
        $organization->description = $request->description;

        if ($request->hasFile('structure_image')) {
            // Delete old image if exists
            if ($organization->structure_image) {
                Storage::delete('public/' . $organization->structure_image);
            }
            $path = $request->file('structure_image')->store('organizations', 'public');
            $organization->structure_image = $path;
        }

        $organization->save();

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Organization $organization)
    {
        if ($organization->image) {
            Storage::delete('public/' . $organization->image);
        }

        $organization->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
