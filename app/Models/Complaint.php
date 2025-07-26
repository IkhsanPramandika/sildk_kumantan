<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_number',
        'resident_id',
        'category',
        'title',
        'description',
        'status',
        'response_date',
        'response'
    ];

    protected $casts = [
        'response_date' => 'datetime'
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}
