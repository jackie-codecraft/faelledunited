<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use League\CommonMark\CommonMarkConverter;

class NewsController extends Controller
{
    public function index()
    {
        $posts = NewsPost::with('category')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('news.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = NewsPost::with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $bodyHtml = $converter->convert($post->body)->getContent();

        return view('news.show', compact('post', 'bodyHtml'));
    }
}
