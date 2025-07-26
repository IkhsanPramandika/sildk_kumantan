<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'structure_image',
        'type',
    ];

    public const TYPES = [
        'karang-taruna' => 'Karang Taruna',
        'bpd' => 'BPD',
        'pkk' => 'PKK',
        'government' => 'Pemerintahan Desa',
    ];

    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
