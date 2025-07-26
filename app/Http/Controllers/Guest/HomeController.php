<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Product;
use App\Models\Resident;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $newsLimit = $request->query('news_limit', config('app.home.news_limit', 3));
        $eventsLimit = $request->query('events_limit', config('app.home.events_limit', 3));
        $galleriesLimit = $request->query('galleries_limit', config('app.home.galleries_limit', 3));
        $productsLimit = $request->query('products_limit', config('app.home.products_limit', 4));

        // Cache duration (in minutes)
        $cacheTtl = config('app.home.cache_ttl', 30);

        // Cache key
        $cacheKey = 'home_data_' . md5(serialize($request->query()));

        try {
            $data = Cache::remember($cacheKey, $cacheTtl, function () use ($newsLimit, $eventsLimit, $galleriesLimit, $productsLimit) {
                // Get village profile
                $villageProfile = VillageProfile::first();

                // Get statistics
                $stats = [
                    'total_residents' => Resident::count(),
                    'total_male' => Resident::where('gender', 'male')->count(),
                    'total_female' => Resident::where('gender', 'female')->count(),
                    'total_news' => News::where('status', 'published')->count(),
                ];

                // Fetch latest news
                $latestNews = News::where('status', 'published')
                    ->orderBy('publish_date', 'desc')
                    ->take($newsLimit)
                    ->get()
                    ->map(function ($news) {
                        return [
                            'id' => $news->id,
                            'title' => $news->title,
                            'slug' => $news->slug, // Add for routing
                            'description' => $news->content ? substr(strip_tags($news->content), 0, 150) . '...' : '',
                            'image_url' => $news->featured_image,
                            'publish_date' => Carbon::parse($news->publish_date)->locale('id')->isoFormat('D MMMM YYYY'),
                        ];
                    });

                // Fetch upcoming events
                $upcomingEvents = Event::published()
                    ->upcoming()
                    ->orderBy('start_date', 'asc')
                    ->take($eventsLimit)
                    ->get()
                    ->map(function ($event) {
                        return [
                            'id' => $event->id,
                            'title' => $event->title,
                            'slug' => $event->slug, // Add for routing
                            'description' => $event->description,
                            'start_date' => Carbon::parse($event->start_date)->locale('id')->isoFormat('D MMMM YYYY'),
                            'location' => $event->location,
                            'image_url' => $event->featured_image,
                            'status' => 'upcoming',
                        ];
                    });

                // Fetch ongoing events
                $ongoingEvents = Event::published()
                    ->ongoing()
                    ->orderBy('start_date', 'asc')
                    ->take($eventsLimit)
                    ->get()
                    ->map(function ($event) {
                        return [
                            'id' => $event->id,
                            'title' => $event->title,
                            'slug' => $event->slug, // Add for routing
                            'description' => $event->description,
                            'start_date' => Carbon::parse($event->start_date)->locale('id')->isoFormat('D MMMM YYYY'),
                            'end_date' => Carbon::parse($event->end_date)->locale('id')->isoFormat('D MMMM YYYY'),
                            'location' => $event->location,
                            'image_url' => $event->featured_image,
                            'status' => 'ongoing',
                        ];
                    });

                // Combine ongoing and upcoming events, prioritizing ongoing events
                $activeEvents = $ongoingEvents->concat($upcomingEvents)->take($eventsLimit);

                // Fetch latest galleries
                $latestGalleries = Gallery::with('images')
                    ->where('is_published', true)
                    ->orderBy('created_at', 'desc')
                    ->take($galleriesLimit)
                    ->get()
                    ->map(function ($gallery) {
                        return [
                            'id' => $gallery->id,
                            'title' => $gallery->title,
                            'image_url' => $gallery->image_url,
                        ];
                    });

                // Fetch featured products
                $featuredProducts = Product::with(['images'])
                    ->where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->take($productsLimit)
                    ->get()
                    ->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'description' => $product->description,
                            'price' => number_format($product->price, 0, ',', '.'),
                            'image_url' => $product->images->first()?->image_url,
                        ];
                    });

                return [
                    'villageProfile' => $villageProfile,
                    'stats' => $stats,
                    'latestNews' => $latestNews,
                    'upcomingEvents' => $activeEvents,
                    'latestGalleries' => $latestGalleries,
                    'featuredProducts' => $featuredProducts,
                ];
            });

            return Inertia::render('Guest/Home', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching home page data: ' . $e->getMessage());

            return Inertia::render('Guest/Home', [
                'villageProfile' => VillageProfile::first() ?? [],
                'stats' => [
                    'total_residents' => 0,
                    'total_male' => 0,
                    'total_female' => 0,
                    'total_news' => 0,
                ],
                'latestNews' => [],
                'upcomingEvents' => [],
                'latestGalleries' => [],
                'featuredProducts' => [],
                'error' => 'Unable to load data at this time. Please try again later.',
            ]);
        }
    }
}
