<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\VillagePotential;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        // Static pages
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0'],
            ['url' => route('profile.demographics'), 'priority' => '0.8'],
            ['url' => route('profile.history'), 'priority' => '0.8'],
            ['url' => route('potentials.natural-resources'), 'priority' => '0.8'],
            ['url' => route('potentials.infrastructure'), 'priority' => '0.8'],
            ['url' => route('potentials.umkm'), 'priority' => '0.8'],
            ['url' => route('profile.structure'), 'priority' => '0.8'],
            ['url' => route('organizations.bpd'), 'priority' => '0.7'],
            ['url' => route('organizations.karang-taruna'), 'priority' => '0.7'],
            ['url' => route('organizations.pkk'), 'priority' => '0.7'],
            ['url' => route('news.index'), 'priority' => '0.9'],
            ['url' => route('events.index'), 'priority' => '0.9'],
            ['url' => route('galleries.index'), 'priority' => '0.8'],
            ['url' => route('complaints.create'), 'priority' => '0.6'],
            ['url' => route('contact'), 'priority' => '0.6'],
        ];

        $urls = array_merge($urls, $staticPages);

        // Dynamic content
        try {
            // News
            $news = News::where('status', 'published')->get();
            foreach ($news as $item) {
                $urls[] = [
                    'url' => route('news.show', $item->slug ?? $item->id),
                    'lastmod' => $item->updated_at->toISOString(),
                    'priority' => '0.7'
                ];
            }

            // Events
            $events = Event::where('status', 'published')->get();
            foreach ($events as $item) {
                $urls[] = [
                    'url' => route('events.show', $item->slug ?? $item->id),
                    'lastmod' => $item->updated_at->toISOString(),
                    'priority' => '0.7'
                ];
            }

            // Galleries
            $galleries = Gallery::where('is_published', true)->get();
            foreach ($galleries as $item) {
                $urls[] = [
                    'url' => route('galleries.show', $item->slug ?? $item->id),
                    'lastmod' => $item->updated_at->toISOString(),
                    'priority' => '0.6'
                ];
            }

            // Products
            $products = Product::where('status', 'published')->get();
            foreach ($products as $item) {
                $urls[] = [
                    'url' => route('products.show', $item->slug ?? $item->id),
                    'lastmod' => $item->updated_at->toISOString(),
                    'priority' => '0.6'
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Error generating sitemap: ' . $e->getMessage());
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Sitemap: " . route('sitemap') . "\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain'
        ]);
    }
}
