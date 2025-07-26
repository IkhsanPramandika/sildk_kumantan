<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'featured_image',
        'start_date',
        'end_date',
        'location',
        'status',
        'slug',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });

        static::updating(function ($event) {
            if ($event->isDirty('title')) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    /**
     * Scope for upcoming events (start_date is in the future)
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', Carbon::now());
    }

    /**
     * Scope for ongoing events (currently happening)
     */
    public function scopeOngoing($query)
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }

    /**
     * Scope for ongoing or upcoming events
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('end_date', '>=', $now);
    }

    /**
     * Scope for published events
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Get the event status (upcoming, ongoing, completed)
     */
    public function getStatusAttribute()
    {
        $now = Carbon::now();
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);

        if ($now < $startDate) {
            return 'upcoming';
        } elseif ($now >= $startDate && $now <= $endDate) {
            return 'ongoing';
        } else {
            return 'completed';
        }
    }
}
