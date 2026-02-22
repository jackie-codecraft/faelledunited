@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <div class="bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014] text-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('Hjem') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('news.index') }}" class="hover:text-white transition-colors">{{ __('Nyheder') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-200">{{ Str::limit($post->title, 50) }}</span>
            </nav>

            @if($post->category)
            {{-- Tertiary accent: category badge on dark hero — clear classifier --}}
            <span class="inline-block mb-3 px-3 py-1 bg-[#fbbf24] text-[#0d2014] text-xs font-bold rounded-full uppercase tracking-wide">
                {{ $post->category->name }}
            </span>
            @endif

            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mb-3">{{ $post->title }}</h1>

            <p class="text-gray-300 text-sm">
                {{ ($post->published_at ?? $post->created_at)->isoFormat('dddd D. MMMM YYYY') }}
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if($post->featured_image)
        <div class="mb-8 rounded-xl overflow-hidden shadow-md">
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full">
        </div>
        @endif

        <div class="prose prose-lg max-w-none
                    prose-headings:text-[#1a472a]
                    prose-a:text-[#1a472a] prose-a:no-underline hover:prose-a:text-[#4a7a58]
                    prose-strong:text-gray-800
                    prose-blockquote:border-l-[#1a472a] prose-blockquote:text-gray-600">
            {!! $bodyHtml !!}
        </div>

        <div class="mt-12 pt-8 border-t border-gray-200">
            <a href="{{ route('news.index') }}"
               class="inline-flex items-center text-[#1a472a] font-semibold hover:text-[#4a7a58] transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('Tilbage til nyheder') }}
            </a>
        </div>

    </div>

@endsection
