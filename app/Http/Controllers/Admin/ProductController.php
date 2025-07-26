<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')
            ->latest()
            ->paginate(10)
            ->through(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'category' => $product->category,
                    'status' => $product->status,
                    'image_url' => $product->image_url,
                    'owner_name' => $product->owner_name,
                    'owner_phone' => $product->owner_phone,
                    'created_at' => $product->created_at,
                ];
            });

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:food,craft,agriculture,fashion,other',
            'status' => 'required|string|in:draft,published',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'owner_address' => 'nullable|string|max:500',
            'images' => 'required|array|min:1',
            'images.*.image' => 'required|image|max:2048',
            'images.*.caption' => 'nullable|string|max:255',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'status' => $validated['status'],
            'owner_name' => $validated['owner_name'],
            'owner_phone' => $validated['owner_phone'],
            'owner_address' => $validated['owner_address'],
        ]);

        foreach ($validated['images'] as $index => $imageData) {
            $path = $imageData['image']->store('products', 'public');
            $product->images()->create([
                'image_url' => $path,
                'caption' => $imageData['caption'] ?? null,
                'order' => $index,
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dibuat.');
    }

    public function show(Product $product)
    {
        return Inertia::render('Admin/Products/Show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return Inertia::render('Admin/Products/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'category' => $product->category,
                'status' => $product->status,
                'owner_name' => $product->owner_name,
                'owner_phone' => $product->owner_phone,
                'owner_address' => $product->owner_address,
                'images' => $product->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_url' => $image->image_url,
                        'caption' => $image->caption,
                    ];
                }),
            ],
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:food,craft,agriculture,fashion,other',
            'status' => 'required|string|in:draft,published',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'owner_address' => 'nullable|string|max:500',
            'images' => 'nullable|array',
            'images.*.id' => 'nullable|exists:product_images,id',
            'images.*.image' => 'nullable|image|max:2048',
            'images.*.caption' => 'nullable|string|max:255',
            'images.*.order' => 'nullable|integer|min:0',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:product_images,id',
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'status' => $validated['status'],
            'owner_name' => $validated['owner_name'],
            'owner_phone' => $validated['owner_phone'],
            'owner_address' => $validated['owner_address'],
        ]);

        // Delete removed images
        if (!empty($validated['deleted_images'])) {
            $imagesToDelete = $product->images()->whereIn('id', $validated['deleted_images'])->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            }
        }

        // Update or create images
        if (!empty($validated['images'])) {
            foreach ($validated['images'] as $index => $imageData) {
                if (isset($imageData['id'])) {
                    // Update existing image
                    $image = $product->images()->find($imageData['id']);
                    if ($image) {
                        $image->update([
                            'caption' => $imageData['caption'] ?? null,
                            'order' => $imageData['order'] ?? $index,
                        ]);
                    }
                } else {
                    // Create new image
                    $path = $imageData['image']->store('products', 'public');
                    $product->images()->create([
                        'image_url' => $path,
                        'caption' => $imageData['caption'] ?? null,
                        'order' => $imageData['order'] ?? $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Delete product images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
