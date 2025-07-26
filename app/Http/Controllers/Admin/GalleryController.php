<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gallery::with('images');

        // Filter berdasarkan judul
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status publikasi
        if ($request->has('is_published')) {
            $query->where('is_published', $request->is_published);
        }

        $galleries = $query->paginate(10)
            ->through(function ($gallery) {
                return [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'description' => $gallery->description,
                    'is_published' => $gallery->is_published,
                    'image_url' => $gallery->image_url,
                    'image_count' => $gallery->images->count(),
                    'created_at' => $gallery->created_at->diffForHumans(),
                ];
            })
            ->withQueryString();

        return Inertia::render('Admin/Galleries/Index', [
            'galleries' => $galleries,
            'filters' => $request->only(['search', 'is_published']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Galleries/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $gallery = Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => $request->is_published,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('galleries', 'public');
                $caption = $request->captions[$index] ?? null;

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $path,
                    'caption' => $caption,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('images');
        return Inertia::render('Admin/Galleries/Show', [
            'gallery' => $gallery
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $gallery->load('images');
        return Inertia::render('Admin/Galleries/Edit', [
            'gallery' => $gallery
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
            'existing_images.*.id' => 'required|exists:gallery_images,id',
            'existing_images.*.caption' => 'nullable|string|max:255',
            'new_images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'new_captions.*' => 'nullable|string|max:255',
        ]);

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => $request->is_published,
        ]);

        // Update existing images
        if ($request->has('existing_images')) {
            foreach ($request->existing_images as $imageData) {
                GalleryImage::where('id', $imageData['id'])
                    ->update(['caption' => $imageData['caption']]);
            }
        }

        // Add new images
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $index => $image) {
                $path = $image->store('galleries', 'public');
                $caption = $request->new_captions[$index] ?? null;

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $path,
                    'caption' => $caption,
                ]);
            }
        }

        // Delete removed images
        $existingImageIds = collect($request->existing_images)->pluck('id')->toArray();
        $gallery->images()->whereNotIn('id', $existingImageIds)->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete all images from storage
        foreach ($gallery->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
