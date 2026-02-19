<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\NewsPost;

class HomeController extends Controller
{
    public function index()
    {
        $departments = Department::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $latestNews = NewsPost::with('category')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('home.index', compact('departments', 'latestNews'));
    }
}
