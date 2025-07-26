<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('is_published', true)
            ->latest()
            ->with('images') // Pastikan ini ada
            ->paginate(12)
            ->through(function ($gallery) {
                return [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'description' => $gallery->description,
                    'is_published' => $gallery->is_published,
                    'image_url' => $gallery->image_url, // Ini sudah benar
                    'image_count' => $gallery->images->count(),
                    'created_at' => $gallery->created_at->diffForHumans(),
                    'images' => $gallery->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'url' => $image->url, // PENTING: Pastikan ini adalah $image->url
                            'caption' => $image->caption,
                        ];
                    }),
                ];
            });

        return Inertia::render('Guest/Galleries/Index', [
            'galleries' => $galleries
        ]);
    }
}