@extends('layouts.app')

@section('title', __('Nyheder'))

@section('content')

    <div class="bg-[#1a472a] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">{{ __('Nyheder') }}</h1>
            <p class="mt-2 text-gray-300">{{ __('Seneste nyt fra Fælled United') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow group flex flex-col">
                @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title_da }}" class="h-48 w-full object-cover">
                @else
                    <div class="h-48 bg-gradient-to-br from-[#1a472a] to-[#235c38] flex items-end p-4">
                        @if($post->category)
                        <span class="inline-block px-2 py-1 bg-[#c9a84c] text-[#1a472a] text-xs font-bold rounded">
                            {{ $post->category->name_da }}
                        </span>
                        @endif
                    </div>
                @endif

                <div class="p-6 flex flex-col flex-1">
                    @if($post->category && $post->featured_image)
                    <span class="inline-block mb-3 px-2 py-1 bg-[#1a472a] text-white text-xs font-bold rounded self-start">
                        {{ $post->category->name_da }}
                    </span>
                    @endif

                    <p class="text-gray-400 text-xs mb-2">
                        {{ ($post->published_at ?? $post->created_at)->isoFormat('D. MMMM YYYY') }}
                    </p>

                    <h2 class="font-bold text-xl text-gray-900 mb-3 leading-snug group-hover:text-[#1a472a] transition-colors">
                        <a href="{{ route('news.show', $post->slug) }}">{{ $post->title_da }}</a>
                    </h2>

                    @if($post->excerpt_da)
                    <p class="text-gray-500 text-sm flex-1 mb-4">{{ Str::limit($post->excerpt_da, 140) }}</p>
                    @endif

                    <a href="{{ route('news.show', $post->slug) }}"
                       class="mt-auto inline-flex items-center text-[#1a472a] font-semibold text-sm hover:text-[#c9a84c] transition-colors">
                        {{ __('Læs mere') }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        @if($posts->hasPages())
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-20 text-gray-400">
            <p class="text-xl">{{ __('Ingen nyheder endnu. Kom snart igen!') }}</p>
        </div>
        @endif

    </div>

@endsection
