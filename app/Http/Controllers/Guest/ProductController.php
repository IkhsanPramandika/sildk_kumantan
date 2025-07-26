<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['images'])
            ->where('status', 'published')
            ->latest()
            ->paginate(12)
            ->through(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'category' => $product->category,
                    'image_url' => $product->image_url,
                    'owner_name' => $product->owner_name,
                    'owner_phone' => $product->owner_phone,
                    'formatted_phone' => $product->formatted_phone,
                ];
            });

        return Inertia::render('Guest/Products/Index', [
            'products' => $products,
        ]);
    }

    public function show(Product $product)
    {
        if ($product->status !== 'published') {
            abort(404);
        }

        $relatedProducts = Product::with(['images'])
            ->where('status', 'published')
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'image_url' => $product->image_url,
                    'owner_name' => $product->owner_name,
                ];
            });

        return Inertia::render('Guest/Products/Show', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'category' => $product->category,
                'owner_name' => $product->owner_name,
                'owner_phone' => $product->owner_phone,
                'owner_address' => $product->owner_address,
                'formatted_phone' => $product->formatted_phone,
                'images' => $product->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_url' => $image->image_url,
                        'caption' => $image->caption,
                    ];
                }),
            ],
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
