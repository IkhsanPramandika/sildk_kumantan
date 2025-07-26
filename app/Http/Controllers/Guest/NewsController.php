<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\News;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('status', 'published')
            ->latest('publish_date')
            ->paginate(9)
            ->through(function ($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->title,
                    'content' => $news->content,
                    'category' => $news->category,
                    'image_url' => $news->featured_image,
                    'publish_date' => $news->publish_date,
                    'slug' => $news->slug,
                ];
            });

        return Inertia::render('Guest/News/Index', [
            'news' => $news,
        ]);
    }

    public function show(News $news)
    {
        if ($news->status !== 'published') {
            abort(404);
        }

        $relatedNews = News::where('status', 'published')
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->latest('publish_date')
            ->take(2)
            ->get()
            ->map(function ($news) {
                return [
                    'id' => $news->id,
                    'slug' => $news->slug,
                    'title' => $news->title,
                    'content' => $news->content,
                    'category' => $news->category,
                    'image_url' => $news->featured_image,
                    'publish_date' => $news->publish_date,
                ];
            });


        return Inertia::render('Guest/News/Show', [
            'news' => [
                'id' => $news->id,
                'slug' => $news->slug,
                'title' => $news->title,
                'content' => $news->content,
                'category' => $news->category,
                'image_url' => $news->featured_image,
                'publish_date' => $news->publish_date,
            ],
            'relatedNews' => $relatedNews,
        ]);
    }
}
