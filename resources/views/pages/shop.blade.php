@extends('layouts.app')

@section('title', app()->getLocale() === 'en' ? 'Shop — Coming Soon' : 'Butik — Kommer snart')
@section('description', app()->getLocale() === 'en'
    ? 'Fælled United × Sport24 — Our official club shop is on its way. Club kits, training gear, and merchandise with the Fælled United logo.'
    : 'Fælled United × Sport24 — Vores officielle klub-shop er på vej. Klubtøj, træningstøj og merchandise med Fælled United logo.')

@section('content')

{{-- =========================================================
     HERO SECTION
     ========================================================= --}}
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, #0f2718 0%, #1a472a 60%, #235c38 100%);">

    {{-- Background pattern --}}
    <div class="absolute inset-0 opacity-5 pointer-events-none" aria-hidden="true">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hexagons" x="0" y="0" width="60" height="52" patternUnits="userSpaceOnUse">
                    <polygon points="30,2 58,17 58,35 30,50 2,35 2,17" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hexagons)"/>
        </svg>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center text-white">

        {{-- Coming Soon badge --}}
        <div class="inline-flex items-center gap-2 bg-amber-400 text-amber-900 font-bold text-xs uppercase tracking-widest px-4 py-1.5 rounded-full mb-6 shadow-lg">
            <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse inline-block"></span>
            @if(app()->getLocale() === 'en')
                COMING SOON
            @else
                KOMMER SNART
            @endif
        </div>

        {{-- Page title --}}
        <h1 class="font-[family-name:var(--font-display)] text-7xl sm:text-8xl lg:text-9xl tracking-wider text-white leading-none mb-4">
            @if(app()->getLocale() === 'en')
                SHOP
            @else
                BUTIK
            @endif
        </h1>

        {{-- Subtitle --}}
        <p class="text-xl sm:text-2xl text-white/70 font-light tracking-widest uppercase">
            Fælled United × Sport24
        </p>

    </div>
</section>

{{-- =========================================================
     PARTNERSHIP ANNOUNCEMENT
     ========================================================= --}}
<section class="bg-white py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        <h2 class="font-[family-name:var(--font-display)] text-4xl sm:text-5xl text-[#1a472a] mb-6 tracking-wide">
            @if(app()->getLocale() === 'en')
                Our official club shop is on its way
            @else
                Vores officielle klub-shop er på vej
            @endif
        </h2>

        <p class="text-gray-700 text-lg leading-relaxed mb-8">
            @if(app()->getLocale() === 'en')
                Fælled United is partnering with Sport24 to create a dedicated club shop. Parents, coaches, and players
                will soon be able to order club kits, training gear, and merchandise — all with the Fælled United logo —
                directly through our own team store.
            @else
                Fælled United indgår et samarbejde med Sport24 om at oprette en dedikeret klub-shop. Forældre, trænere
                og spillere vil snart kunne bestille klubtøj, træningstøj og merchandise — alt sammen med Fælled United
                logo — direkte via vores eget holdshop.
            @endif
        </p>

        <div class="inline-block bg-[#f0f7f2] border border-[#c2dfc9] rounded-xl px-6 py-4 text-sm text-[#1a472a] leading-relaxed">
            <strong>Sport24:</strong>
            @if(app()->getLocale() === 'en')
                Sport24 specialises in club clothing and helps sports clubs across Denmark design and order
                professional garments with logo and print.
            @else
                Sport24 er specialister i klubtøj og hjælper sportsklubber i hele Danmark med at designe og bestille
                professionelt tøj med logo og tryk.
            @endif
        </div>

    </div>
</section>

{{-- =========================================================
     FEATURE CARDS — "WHAT TO EXPECT"
     ========================================================= --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="font-[family-name:var(--font-display)] text-4xl sm:text-5xl text-center text-[#1a472a] mb-12 tracking-wide">
            @if(app()->getLocale() === 'en')
                What to expect
            @else
                Hvad kan du forvente?
            @endif
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Card 1: Club kits --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center hover:shadow-md transition-shadow">
                <div class="text-5xl mb-4">🎽</div>
                <h3 class="font-[family-name:var(--font-display)] text-2xl text-[#1a472a] mb-3 tracking-wide">
                    @if(app()->getLocale() === 'en')
                        Club kits with logo
                    @else
                        Klubtøj med logo
                    @endif
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    @if(app()->getLocale() === 'en')
                        Order jerseys, shorts, and training gear featuring the Fælled United logo.
                    @else
                        Bestil trøjer, shorts og træningsudstyr med Fælled United logo.
                    @endif
                </p>
            </div>

            {{-- Card 2: Easy ordering --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center hover:shadow-md transition-shadow">
                <div class="text-5xl mb-4">🛒</div>
                <h3 class="font-[family-name:var(--font-display)] text-2xl text-[#1a472a] mb-3 tracking-wide">
                    @if(app()->getLocale() === 'en')
                        Easy ordering
                    @else
                        Nem bestilling
                    @endif
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    @if(app()->getLocale() === 'en')
                        Parents, coaches, and players order directly online — quick and hassle-free.
                    @else
                        Forældre, trænere og spillere bestiller direkte online — nemt og hurtigt.
                    @endif
                </p>
            </div>

            {{-- Card 3: Club prices --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center hover:shadow-md transition-shadow">
                <div class="text-5xl mb-4">💰</div>
                <h3 class="font-[family-name:var(--font-display)] text-2xl text-[#1a472a] mb-3 tracking-wide">
                    @if(app()->getLocale() === 'en')
                        Club prices
                    @else
                        Klubpriser
                    @endif
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    @if(app()->getLocale() === 'en')
                        Exclusive prices negotiated for Fælled United members.
                    @else
                        Eksklusive priser forhandlet for Fælled United-medlemmer.
                    @endif
                </p>
            </div>

        </div>
    </div>
</section>

{{-- =========================================================
     SPORT24 CTA SECTION
     ========================================================= --}}
<section class="bg-gray-100 py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        {{-- Sport24 brand --}}
        <div class="mb-8">
            <span class="font-[family-name:var(--font-display)] text-6xl sm:text-7xl font-black tracking-widest" style="color: #e31d24;">
                SPORT 24
            </span>
        </div>

        <p class="text-gray-700 text-base leading-relaxed mb-8 max-w-xl mx-auto">
            @if(app()->getLocale() === 'en')
                Sport24 is one of Denmark's largest sports retailers, with a dedicated team programme
                for clubs who want to create their own branded kit collections.
            @else
                Sport24 er en af Danmarks største sportsforretninger med et dedikeret holdprogram
                for klubber, der ønsker at skabe deres eget mærkede tøjsortiment.
            @endif
        </p>

        {{-- CTA button --}}
        <a
            href="https://www.sport24.dk/team-b2b/"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-white text-base shadow-lg hover:opacity-90 active:scale-95 transition-all"
            style="background-color: #e31d24;"
        >
            @if(app()->getLocale() === 'en')
                Learn about Sport24's team programme
            @else
                Læs om Sport24's holdprogram
            @endif
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
        </a>

        {{-- Contact note --}}
        <p class="mt-8 text-sm text-gray-500">
            @if(app()->getLocale() === 'en')
                Want to know more already?
                <a href="{{ route('contact') }}" class="text-[#1a472a] font-medium hover:underline">Contact us via the contact form.</a>
            @else
                Vil du vide mere allerede nu?
                <a href="{{ route('contact') }}" class="text-[#1a472a] font-medium hover:underline">Kontakt os via kontaktformularen.</a>
            @endif
        </p>

    </div>
</section>

@endsection
