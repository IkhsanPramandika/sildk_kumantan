<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\URL; // Ini tidak diperlukan untuk asset()

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image_path',
        'caption',
    ];

    protected $appends = ['url'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getUrlAttribute(): ?string
    {
        if ($this->image_path) {
            // Pastikan ini adalah asset()
            return asset('storage/' . $this->image_path);
        }
        return null;
    }
}