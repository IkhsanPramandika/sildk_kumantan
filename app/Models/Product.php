<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'status',
        'owner_name',
        'owner_phone',
        'owner_address',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->images->first()?->image_url;
    }

    public function getFormattedPhoneAttribute(): string
    {
        if (!$this->owner_phone) return '';

        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $this->owner_phone);

        // Convert to international format
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}
