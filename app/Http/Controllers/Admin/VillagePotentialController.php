<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillagePotential;
use App\Models\VillagePotentialImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VillagePotentialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->input('category');
        $potentials = VillagePotential::where('category', $category)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/VillagePotentials/Index', [
            'potentials' => $potentials,
            'category' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $category = $request->input('category');
        return Inertia::render('Admin/VillagePotentials/Create', [
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $category = $request->input('category');
        $validated['category'] = $category;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('village-potentials', 'public');
        }

        VillagePotential::create($validated);

        return redirect()->route('admin.village-potentials.index', ['category' => $category])
            ->with('success', 'Potensi desa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(VillagePotential $villagePotential)
    {
        return Inertia::render('Admin/VillagePotentials/Show', [
            'potential' => $villagePotential
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VillagePotential $villagePotential)
    {
        return Inertia::render('Admin/VillagePotentials/Edit', [
            'potential' => $villagePotential
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VillagePotential $villagePotential)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($villagePotential->image) {
                Storage::disk('public')->delete($villagePotential->image);
            }
            $validated['image'] = $request->file('image')->store('village-potentials', 'public');
        } else {
            $validated['image'] = $villagePotential->image;
        }

        $villagePotential->update($validated);

        return redirect()->route('admin.village-potentials.index', ['category' => $villagePotential->category])
            ->with('success', 'Potensi desa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VillagePotential $villagePotential)
    {
        if ($villagePotential->image) {
            Storage::disk('public')->delete($villagePotential->image);
        }

        $villagePotential->delete();

        return redirect()->route('admin.village-potentials.index', ['category' => $villagePotential->category])
            ->with('success', 'Potensi desa berhasil dihapus');
    }
}
