@extends('layouts.app')

@section('title', __('Hjem'))

@section('content')

    {{-- HERO --}}
    <section class="relative bg-[#0f2718] text-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014]"></div>
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hexPattern" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                        <circle cx="40" cy="40" r="20" fill="none" stroke="white" stroke-width="1"/>
                        <circle cx="0" cy="0" r="20" fill="none" stroke="white" stroke-width="1"/>
                        <circle cx="80" cy="0" r="20" fill="none" stroke="white" stroke-width="1"/>
                        <circle cx="0" cy="80" r="20" fill="none" stroke="white" stroke-width="1"/>
                        <circle cx="80" cy="80" r="20" fill="none" stroke="white" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hexPattern)"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36 text-center">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo.jpg') }}" alt="Fælled United" class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover ring-4 ring-white/30 shadow-2xl">
            </div>
            <p class="text-white/60 font-semibold uppercase tracking-widest text-sm mb-4">{{ __('Velkommen til') }}</p>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                Fælled United
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-2xl mx-auto mb-10 font-light">
                {{ __('Mere end en klub — en familie') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('registration.create') }}"
                   class="px-8 py-4 bg-white text-[#1a472a] font-bold rounded-lg text-lg hover:bg-gray-100 transition-colors shadow-lg">
                    {{ __('Tilmeld dig nu') }}
                </a>
                <a href="{{ route('about') }}"
                   class="px-8 py-4 border-2 border-white/40 text-white font-semibold rounded-lg text-lg hover:bg-white hover:text-[#1a472a] transition-colors">
                    {{ __('Læs mere om os') }}
                </a>
            </div>
        </div>
    </section>

    {{-- OM KLUBBEN (quick intro) --}}
    <section class="bg-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-[#1a472a] mb-4">{{ __('Om Fælled United') }}</h2>
            <div class="w-16 h-1 bg-[#1a472a] mx-auto mb-6 rounded-full"></div>
            <p class="text-gray-600 text-lg leading-relaxed">
                {{ __('home.about.body') }}
            </p>
        </div>
    </section>

    {{-- DEPARTMENTS --}}
    <section class="bg-[#0f0f0f] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">{{ __('Vores afdelinger') }}</h2>
                <div class="w-16 h-1 bg-[#4a7a58] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach($departments as $dept)
                <a href="{{ route('departments.show', $dept->slug) }}"
                   class="group bg-[#171f1a] border border-[#1e2e22] rounded-2xl overflow-hidden hover:border-white/20 transition-all">
                    <div class="relative h-44 overflow-hidden"
                         style="background-image: url('{{ asset('images/departments/' . $dept->slug . '.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a1a0f]/80 via-[#0a1a0f]/30 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-white/80 transition-colors">
                            {{ app()->getLocale() === 'en' ? $dept->name_en : $dept->name_da }}
                        </h3>
                        <p class="text-gray-400 text-sm mb-4">
                            {{ app()->getLocale() === 'en'
                                ? ($dept->description_en ?: 'Click to learn more about our ' . strtolower($dept->name_en ?? $dept->name_da) . ' department.')
                                : ($dept->description_da ?: 'Klik for at læse mere om vores ' . strtolower($dept->name_da) . '-afdeling.') }}
                        </p>
                        <span class="inline-flex items-center text-white/70 font-semibold text-sm group-hover:text-white transition-colors">
                            {{ __('Læs mere') }}
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('registration.create') }}"
                   class="inline-block px-8 py-3 bg-white text-[#1a472a] font-bold rounded-lg hover:bg-gray-100 transition-colors shadow">
                    {{ __('Tilmeld dit barn') }}
                </a>
            </div>
        </div>
    </section>

    {{-- LATEST NEWS --}}
    @if($latestNews->count() > 0)
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-[#1a472a] mb-2">{{ __('Seneste nyheder') }}</h2>
                    <div class="w-16 h-1 bg-[#1a472a] rounded-full"></div>
                </div>
                <a href="{{ route('news.index') }}" class="text-[#1a472a] font-semibold hover:text-[#4a7a58] transition-colors text-sm">
                    {{ __('Alle nyheder') }}
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestNews as $post)
                <article class="bg-gray-50 rounded-xl overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="h-40 bg-gradient-to-br from-[#1a472a] to-[#0f2718] flex items-end p-4">
                        @if($post->category)
                        <span class="inline-block px-2 py-1 bg-[#fbbf24] text-[#0d2014] text-xs font-bold rounded">
                            {{ $post->category->name_da }}
                        </span>
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-gray-400 text-xs mb-2">
                            {{ ($post->published_at ?? $post->created_at)->isoFormat('D. MMMM YYYY') }}
                        </p>
                        <h3 class="font-bold text-gray-900 mb-2 leading-snug group-hover:text-[#1a472a] transition-colors">
                            <a href="{{ route('news.show', $post->slug) }}">{{ $post->title_da }}</a>
                        </h3>
                        @if($post->excerpt_da)
                        <p class="text-gray-500 text-sm line-clamp-3">{{ $post->excerpt_da }}</p>
                        @endif
                        <a href="{{ route('news.show', $post->slug) }}" class="mt-4 inline-block text-[#1a472a] font-semibold text-sm hover:text-[#4a7a58] transition-colors">
                            {{ __('Læs mere') }} &rarr;
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA BANNER --}}
    <section class="bg-[#0f0f0f] py-14">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-white mb-4">{{ __('Klar til at komme i gang?') }}</h2>
            <p class="text-gray-400 text-lg mb-8 font-medium">
                {{ __('home.cta.body') }}
            </p>
            <a href="{{ route('registration.create') }}"
               class="inline-block px-10 py-4 bg-white text-[#1a472a] font-bold rounded-lg text-lg hover:bg-gray-100 transition-colors shadow-lg">
                {{ __('Tilmeld dig nu') }}
            </a>
        </div>
    </section>

@endsection
