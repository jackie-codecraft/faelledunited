@extends('layouts.app')

@section('title', __('Hjem'))

@section('content')

    {{-- HERO --}}
    <section class="relative bg-[#0f2718] text-white overflow-hidden min-h-[540px] flex items-center">
        {{-- Background pattern --}}
        <div class="absolute inset-0 opacity-[0.035]">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="dotPattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                        <circle cx="30" cy="30" r="1.5" fill="white"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#dotPattern)"/>
            </svg>
        </div>

        {{-- Ghost "FU" watermark --}}
        <div class="absolute right-0 top-1/2 -translate-y-1/2 select-none pointer-events-none
                    font-display text-[clamp(160px,22vw,320px)] leading-none tracking-tight
                    text-white/[0.04]">
            FU
        </div>

        {{-- Pitch circle geometry --}}
        <div class="absolute right-[6%] top-1/2 -translate-y-1/2
                    w-[clamp(180px,24vw,340px)] h-[clamp(180px,24vw,340px)]
                    rounded-full border border-white/[0.07] pointer-events-none">
            <div class="absolute inset-6 rounded-full border border-white/[0.04]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                        w-3 h-3 rounded-full bg-white/10"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 w-full">
            <p class="flex items-center gap-3 text-[#fbbf24] text-xs font-bold uppercase tracking-[0.18em] mb-5">
                <span class="block w-8 h-0.5 bg-[#fbbf24] rounded-full"></span>
                {{ __('Velkommen til') }}
            </p>
            <h1 class="font-display text-[clamp(64px,10vw,120px)] leading-[0.92] tracking-wide text-white mb-6 max-w-2xl">
                {{ __('Fælled') }}<br>
                <span class="text-[#4a9b5e]">{{ __('United') }}</span>
            </h1>
            <p class="text-white/60 text-lg md:text-xl font-light max-w-md leading-relaxed mb-8">
                {{ __('Mere end en klub — en familie. Fodbold og håndbold for børn og unge i Ørestad og omegn.') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('registration.create') }}"
                   class="inline-block px-7 py-3.5 bg-white text-[#1a472a] font-bold rounded-lg text-sm hover:bg-gray-100 transition-colors shadow-lg">
                    {{ __('Tilmeld dit barn') }}
                </a>
                <a href="{{ route('about') }}"
                   class="inline-block px-7 py-3.5 border-2 border-white/25 text-white/85 font-semibold rounded-lg text-sm hover:bg-white hover:text-[#1a472a] transition-colors">
                    {{ __('Læs om os') }}
                </a>
            </div>
        </div>
    </section>

    {{-- PILLARS STRIP --}}
    <div class="bg-[#111a13] border-y border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7">
            <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-white/[0.06]">
                <div class="flex items-start gap-4 py-5 sm:py-0 sm:px-8 first:pl-0 last:pr-0">
                    <span class="text-2xl mt-0.5 shrink-0">⚽</span>
                    <div>
                        <p class="font-semibold text-white text-sm mb-1">{{ __('For alle niveauer') }}</p>
                        <p class="text-white/45 text-xs leading-relaxed">{{ __('Vi spiller for glæden. Ingen erfaring nødvendig — alle er velkomne.') }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 py-5 sm:py-0 sm:px-8 first:pl-0 last:pr-0">
                    <span class="text-2xl mt-0.5 shrink-0">📍</span>
                    <div>
                        <p class="font-semibold text-white text-sm mb-1">{{ __('Lokalt i Ørestad') }}</p>
                        <p class="text-white/45 text-xs leading-relaxed">{{ __('Træning og kampe tæt på hjemmet — tæt ved Amager Fælled.') }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 py-5 sm:py-0 sm:px-8 first:pl-0 last:pr-0">
                    <span class="text-2xl mt-0.5 shrink-0">💚</span>
                    <div>
                        <p class="font-semibold text-white text-sm mb-1">{{ __('Stærkt fællesskab') }}</p>
                        <p class="text-white/45 text-xs leading-relaxed">{{ __('Mere end en klub. Et sted, hvor børn og familier mødes.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DEPARTMENTS --}}
    <section class="bg-[#0d1a10] py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <p class="text-[#4a9b5e] text-xs font-bold uppercase tracking-[0.18em] mb-2">{{ __('Vores sport') }}</p>
                <h2 class="font-display text-[clamp(2.5rem,4vw,3.5rem)] tracking-wide text-white leading-none">
                    {{ __('Afdelinger') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($departments as $dept)
                <a href="{{ route('departments.show', $dept->slug) }}"
                   class="group relative rounded-2xl overflow-hidden min-h-[300px] flex flex-col justify-end">
                    {{-- Photo background --}}
                    @php
                        $deptHero = $dept->hero_image
                            ? \Illuminate\Support\Facades\Storage::disk('public')->url($dept->hero_image)
                            : asset('images/departments/' . $dept->slug . '.jpg');
                    @endphp
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-[1.03]"
                         style="background-image: url('{{ $deptHero }}')"></div>
                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a1a0f]/90 via-[#0a1a0f]/30 to-transparent"></div>
                    {{-- Content --}}
                    <div class="relative z-10 p-6 md:p-8">
                        <span class="inline-block text-[10px] font-bold uppercase tracking-[0.15em] text-white/60
                                     border border-white/15 bg-white/[0.07] backdrop-blur-sm px-3 py-1 rounded-full mb-3">
                            {{ $dept->slug === 'fodbold' ? '⚽' : '🤾' }}
                            {{ $dept->name }}
                        </span>
                        <h3 class="font-display text-[2.75rem] tracking-wide leading-none text-white mb-2">
                            {{ $dept->name }}
                        </h3>
                        <p class="text-white/55 text-sm leading-relaxed mb-5 max-w-xs">
                            {{ app()->getLocale() === 'en'
                                ? ($dept->description ?: 'Click to learn more about our ' . strtolower($dept->name ?? $dept->name) . ' department.')
                                : ($dept->description ?: 'Klik for at læse mere om vores ' . strtolower($dept->name) . '-afdeling.') }}
                        </p>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-[0.08em] text-white/50 group-hover:text-white transition-colors">
                            {{ __('Se hold og tilmelding') }}
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('registration.create') }}"
                   class="inline-block px-7 py-3 bg-white text-[#1a472a] font-bold rounded-lg text-sm hover:bg-gray-100 transition-colors shadow">
                    {{ __('Tilmeld dit barn') }}
                </a>
            </div>
        </div>
    </section>

    {{-- LATEST NEWS --}}
    @if($latestNews->count() > 0)
    <section class="bg-white py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="text-[#1a472a] text-xs font-bold uppercase tracking-[0.18em] mb-2">{{ __('Seneste fra klubben') }}</p>
                    <h2 class="font-display text-[clamp(2.5rem,4vw,3.5rem)] tracking-wide text-[#0f2718] leading-none">
                        {{ __('Nyheder') }}
                    </h2>
                </div>
                <a href="{{ route('news.index') }}"
                   class="text-[10px] font-bold uppercase tracking-[0.12em] text-[#1a472a] border-b-2 border-[#1a472a] pb-0.5 hover:text-[#4a7a58] hover:border-[#4a7a58] transition-colors">
                    {{ __('Alle nyheder') }}
                </a>
            </div>

            {{-- Bento grid: 1 wide featured + 2 stacked --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Featured (first post) --}}
                @if($latestNews->count() > 0)
                @php $featured = $latestNews->first(); @endphp
                <a href="{{ route('news.show', $featured->slug) }}"
                   class="group md:col-span-2 bg-gray-50 rounded-2xl overflow-hidden flex flex-col hover:shadow-xl transition-all duration-300">
                    <div class="h-52 md:h-64 bg-gradient-to-br from-[#1a472a] to-[#0f2718] flex items-end p-5 shrink-0">
                        @if($featured->category)
                        <span class="inline-block px-2.5 py-1 bg-[#fbbf24] text-[#0d2014] text-[10px] font-extrabold uppercase tracking-wider rounded">
                            {{ $featured->category->name }}
                        </span>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <p class="text-gray-400 text-xs mb-2 font-medium tracking-wide">
                            {{ ($featured->published_at ?? $featured->created_at)->isoFormat('D. MMMM YYYY') }}
                        </p>
                        <h3 class="font-bold text-gray-900 text-xl leading-snug mb-3 group-hover:text-[#1a472a] transition-colors">
                            {{ $featured->title }}
                        </h3>
                        @if($featured->excerpt)
                        <p class="text-gray-500 text-sm line-clamp-3 mb-4">{{ $featured->excerpt }}</p>
                        @endif
                        <span class="mt-auto text-[#1a472a] font-bold text-xs uppercase tracking-[0.08em] group-hover:text-[#4a7a58] transition-colors">
                            {{ __('Læs mere') }} →
                        </span>
                    </div>
                </a>
                @endif

                {{-- Secondary posts (stacked) --}}
                <div class="flex flex-col gap-4">
                    @foreach($latestNews->skip(1)->take(2) as $post)
                    <a href="{{ route('news.show', $post->slug) }}"
                       class="group bg-gray-50 rounded-2xl overflow-hidden flex flex-col flex-1 hover:shadow-lg transition-all duration-300">
                        <div class="h-28 bg-gradient-to-br from-[#1a472a] to-[#0a1a0f] flex items-end p-4 shrink-0">
                            @if($post->category)
                            <span class="inline-block px-2 py-0.5 bg-[#fbbf24] text-[#0d2014] text-[10px] font-extrabold uppercase tracking-wider rounded">
                                {{ $post->category->name }}
                            </span>
                            @endif
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <p class="text-gray-400 text-xs mb-1.5 font-medium">
                                {{ ($post->published_at ?? $post->created_at)->isoFormat('D. MMMM YYYY') }}
                            </p>
                            <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2 group-hover:text-[#1a472a] transition-colors flex-1">
                                {{ $post->title }}
                            </h3>
                            <span class="text-[#1a472a] font-bold text-[10px] uppercase tracking-[0.08em] group-hover:text-[#4a7a58] transition-colors">
                                {{ __('Læs mere') }} →
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
    @endif

    {{-- MAILING LIST --}}
    <section class="bg-[#111a13] py-14 border-y border-white/5">
        <div class="max-w-2xl mx-auto px-4 text-center">
            <p class="text-[#4a9b5e] text-xs font-bold uppercase tracking-[0.18em] mb-3">{{ __('Hold dig opdateret') }}</p>
            <h2 class="font-display text-[clamp(2rem,4vw,3rem)] tracking-wide text-white leading-none mb-3">
                {{ __('Tilmeld dig vores mailliste') }}
            </h2>
            <p class="text-white/45 text-sm leading-relaxed mb-7">
                {{ __('mailing.homepage.body') }}
            </p>

            @if(session('mailing_success'))
            <div class="inline-flex items-center gap-2 bg-[#1a472a]/60 border border-[#4a9b5e]/40 text-[#7dd3a8] text-sm font-semibold px-5 py-3 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('mailing.success') }}
            </div>
            @else
            <form action="{{ route('mailing-list.store') }}" method="POST"
                  class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                @csrf
                <input
                    type="email"
                    name="email"
                    required
                    placeholder="{{ __('Din e-mailadresse') }}"
                    class="flex-1 px-4 py-3 rounded-lg bg-white/[0.07] border border-white/10 text-white placeholder-white/30 text-sm focus:outline-none focus:ring-2 focus:ring-[#4a9b5e] focus:border-transparent"
                >
                <button type="submit"
                        class="px-6 py-3 bg-white text-[#1a472a] font-bold rounded-lg text-sm hover:bg-gray-100 transition-colors shrink-0">
                    {{ __('Tilmeld') }}
                </button>
            </form>
            @if($errors->has('email'))
            <p class="text-red-400 text-xs mt-2">{{ $errors->first('email') }}</p>
            @endif
            <p class="text-white/25 text-xs mt-4">{{ __('mailing.no_spam') }}</p>
            @endif
        </div>
    </section>

    {{-- CTA BANNER --}}
    <section class="bg-[#0f2718] py-16 md:py-20">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="font-display text-[clamp(2.5rem,5vw,4rem)] tracking-wide text-white mb-4 leading-none">
                {{ __('Klar til at komme med?') }}
            </h2>
            <p class="text-white/50 text-lg mb-8 font-light leading-relaxed">
                {{ __('home.cta.body') }}
            </p>
            <a href="{{ route('registration.create') }}"
               class="inline-block px-10 py-4 bg-white text-[#1a472a] font-bold rounded-lg text-sm hover:bg-gray-100 transition-colors shadow-lg">
                {{ __('Tilmeld dig nu') }}
            </a>
        </div>
    </section>

@endsection
