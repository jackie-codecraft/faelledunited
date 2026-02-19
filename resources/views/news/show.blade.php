@extends('layouts.app')

@section('title', $post->title_da)

@section('content')

    {{-- Breadcrumb + article header --}}
    <div class="bg-[#1a472a] text-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-[#c9a84c] transition-colors">Hjem</a>
                <span class="mx-2">/</span>
                <a href="{{ route('news.index') }}" class="hover:text-[#c9a84c] transition-colors">Nyheder</a>
                <span class="mx-2">/</span>
                <span class="text-gray-200">{{ Str::limit($post->title_da, 50) }}</span>
            </nav>

            @if($post->category)
            <span class="inline-block mb-3 px-3 py-1 bg-[#c9a84c] text-[#1a472a] text-xs font-bold rounded-full uppercase tracking-wide">
                {{ $post->category->name_da }}
            </span>
            @endif

            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mb-3">{{ $post->title_da }}</h1>

            <p class="text-gray-300 text-sm">
                {{ ($post->published_at ?? $post->created_at)->isoFormat('dddd D. MMMM YYYY') }}
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Featured image --}}
        @if($post->featured_image)
        <div class="mb-8 rounded-xl overflow-hidden shadow-md">
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title_da }}" class="w-full">
        </div>
        @endif

        {{-- Article body (Markdown rendered to HTML) --}}
        <div class="prose prose-lg max-w-none
                    prose-headings:text-[#1a472a]
                    prose-a:text-[#1a472a] prose-a:no-underline hover:prose-a:text-[#c9a84c]
                    prose-strong:text-gray-800
                    prose-blockquote:border-l-[#c9a84c] prose-blockquote:text-gray-600">
            {!! $bodyHtml !!}
        </div>

        {{-- Back to news --}}
        <div class="mt-12 pt-8 border-t border-gray-200">
            <a href="{{ route('news.index') }}"
               class="inline-flex items-center text-[#1a472a] font-semibold hover:text-[#c9a84c] transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Tilbage til nyheder
            </a>
        </div>

    </div>

@endsection
