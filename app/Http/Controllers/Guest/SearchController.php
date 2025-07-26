<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\VillagePotential;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all');

        if (empty($query)) {
            return Inertia::render('Guest/Search', [
                'query' => $query,
                'type' => $type,
                'results' => [],
                'totalResults' => 0,
            ]);
        }

        try {
            $results = [];
            $totalResults = 0;

            if ($type === 'all' || $type === 'news') {
                $news = News::where('status', 'published')
                    ->where(function ($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                            ->orWhere('content', 'like', "%{$query}%");
                    })
                    ->take(10)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'type' => 'news',
                            'id' => $item->id,
                            'title' => $item->title,
                            'description' => substr(strip_tags($item->content), 0, 150) . '...',
                            'url' => route('news.show', $item->slug ?? $item->id),
                            'date' => $item->publish_date,
                            'image_url' => $item->images->first()?->image_url,
                        ];
                    });

                $results = array_merge($results, $news->toArray());
                $totalResults += $news->count();
            }

            if ($type === 'all' || $type === 'events') {
                $events = Event::where('status', 'published')
                    ->where(function ($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->take(10)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'type' => 'event',
                            'id' => $item->id,
                            'title' => $item->title,
                            'description' => $item->description,
                            'url' => route('events.show', $item->slug ?? $item->id),
                            'date' => $item->start_date,
                            'image_url' => $item->images->first()?->image_url,
                        ];
                    });

                $results = array_merge($results, $events->toArray());
                $totalResults += $events->count();
            }

            if ($type === 'all' || $type === 'galleries') {
                $galleries = Gallery::where('is_published', true)
                    ->where(function ($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->take(10)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'type' => 'gallery',
                            'id' => $item->id,
                            'title' => $item->title,
                            'description' => $item->description,
                            'url' => route('galleries.show', $item->slug ?? $item->id),
                            'date' => $item->created_at,
                            'image_url' => $item->images->first()?->image_url,
                        ];
                    });

                $results = array_merge($results, $galleries->toArray());
                $totalResults += $galleries->count();
            }

            if ($type === 'all' || $type === 'products') {
                $products = Product::where('status', 'published')
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->take(10)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'type' => 'product',
                            'id' => $item->id,
                            'title' => $item->name,
                            'description' => $item->description,
                            'url' => route('products.show', $item->slug ?? $item->id),
                            'date' => $item->created_at,
                            'image_url' => $item->images->first()?->image_url,
                            'price' => $item->price,
                        ];
                    });

                $results = array_merge($results, $products->toArray());
                $totalResults += $products->count();
            }

            return Inertia::render('Guest/Search', [
                'query' => $query,
                'type' => $type,
                'results' => $results,
                'totalResults' => $totalResults,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in search: ' . $e->getMessage());

            return Inertia::render('Guest/Search', [
                'query' => $query,
                'type' => $type,
                'results' => [],
                'totalResults' => 0,
                'error' => 'Terjadi kesalahan saat melakukan pencarian.',
            ]);
        }
    }
}
