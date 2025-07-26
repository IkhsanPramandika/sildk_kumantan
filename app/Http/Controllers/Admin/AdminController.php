<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Product;
use App\Models\Business;
use App\Models\Resident;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'residents' => Resident::count(),
            'products' => Product::count(),
            'activeEvents' => Event::published()->active()->count(),
            'recentNews' => News::count(),
            'newComplaints' => Complaint::where('status', 'pending')->count(),
        ];

        // Get ongoing events
        $ongoingEvents = Event::published()
            ->ongoing()
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'slug' => $event->slug,
                    'description' => $event->description,
                    'category' => $event->category,
                    'image_url' => $event->featured_image,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'location' => $event->location,
                    'status' => 'ongoing',
                ];
            });

        // Get upcoming events
        $upcomingEvents = Event::published()
            ->upcoming()
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'slug' => $event->slug,
                    'description' => $event->description,
                    'category' => $event->category,
                    'image_url' => $event->featured_image,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'location' => $event->location,
                    'status' => 'upcoming',
                ];
            });

        // Combine ongoing and upcoming events, prioritizing ongoing events
        $recentEvents = $ongoingEvents->concat($upcomingEvents)->take(5);

        $recentNews = News::where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        $recentComplaints = Complaint::with('resident')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentEvents' => $recentEvents,
            'ongoingEvents' => $ongoingEvents,
            'upcomingEvents' => $upcomingEvents,
            'recentNews' => $recentNews,
            'recentComplaints' => $recentComplaints,
        ]);
    }
}
