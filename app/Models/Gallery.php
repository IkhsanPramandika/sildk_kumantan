<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_published',
        'slug',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Penting: Tambahkan 'image_url' ke array $appends agar otomatis disertakan
    // saat model di-serialize ke JSON (untuk Inertia).
    protected $appends = ['image_url'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });

        static::updating(function ($gallery) {
            if ($gallery->isDirty('title')) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
    }

    /**
     * Get the images for the gallery.
     */
    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class);
    }

    /**
     * Get the URL for the main (first) image of the gallery.
     * This is an accessor that will be available as $gallery->image_url.
     */
    public function getImageUrlAttribute(): ?string
    {
        // Mendapatkan gambar pertama dari relasi 'images'
        // Relasi 'images' harus di-load (contoh: Gallery::with('images')->get())
        // agar images->first() dapat bekerja tanpa N+1 query.
        $firstImage = $this->images->first();

        // Jika ada gambar pertama, kembalikan URL-nya menggunakan accessor 'url'
        // dari model GalleryImage.
        if ($firstImage) {
            return $firstImage->url; // Memanggil getUrlAttribute() dari GalleryImage
        }

        // Jika tidak ada gambar, kembalikan null (atau path ke placeholder default)
        return null;
        // Contoh placeholder: return asset('path/to/default/placeholder.jpg');
    }
}