<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::published();

        // Filter by event status
        if ($request->has('status')) {
            switch ($request->input('status')) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'ongoing':
                    $query->ongoing();
                    break;
                case 'active':
                    $query->active();
                    break;
                case 'completed':
                    $query->where('end_date', '<', Carbon::now());
                    break;
            }
        } else {
            // Default: show active events (ongoing + upcoming)
            $query->active();
        }

        // Filter by category
        if ($request->has('category') && $request->input('category')) {
            $query->where('category', $request->input('category'));
        }

        // Search functionality
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('start_date', 'asc')
            ->paginate(9)
            ->withQueryString()
            ->through(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'category' => $event->category,
                    'image_url' => $event->featured_image,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'location' => $event->location,
                    'slug' => $event->slug,
                    'status' => $event->status, // This will use the accessor we defined
                ];
            });

        return Inertia::render('Guest/Events/Index', [
            'events' => $events,
            'filters' => $request->only(['search', 'status', 'category']),
        ]);
    }

    public function show(Event $event)
    {
        $relatedEvents = Event::published()
            ->where('id', '!=', $event->id)
            ->where('category', $event->category)
            ->active()
            ->orderBy('start_date')
            ->take(2)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'slug' => $event->slug,
                    'title' => $event->title,
                    'description' => $event->description,
                    'category' => $event->category,
                    'image_url' => $event->featured_image,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'location' => $event->location,
                    'status' => $event->status,
                ];
            });

        return Inertia::render('Guest/Events/Show', [
            'event' => [
                'id' => $event->id,
                'slug' => $event->slug,
                'title' => $event->title,
                'description' => $event->description,
                'category' => $event->category,
                'image_url' => $event->featured_image,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'location' => $event->location,
                'status' => $event->status,
            ],
            'relatedEvents' => $relatedEvents,
        ]);
    }

    /**
     * Get ongoing and upcoming events
     */
    public function getActiveEvents(Request $request)
    {
        $limit = $request->input('limit', 10);

        // Get ongoing events
        $ongoingEvents = Event::published()
            ->ongoing()
            ->orderBy('start_date', 'asc')
            ->take($limit)
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
            ->take($limit)
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

        return response()->json([
            'ongoing_events' => $ongoingEvents,
            'upcoming_events' => $upcomingEvents,
            'total_ongoing' => $ongoingEvents->count(),
            'total_upcoming' => $upcomingEvents->count(),
        ]);
    }
}
