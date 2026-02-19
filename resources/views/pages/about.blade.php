@extends('layouts.app')

@section('title', 'Om klubben')

@section('content')

    <div class="bg-[#1a472a] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">Om Fælled United</h1>
            <p class="mt-2 text-gray-300">Lær os at kende — hvem vi er og hvad vi tror på</p>
        </div>
    </div>

    {{-- Club story --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-[#1a472a] mb-4">Vores historie</h2>
                    <div class="w-16 h-1 bg-[#c9a84c] rounded-full mb-6"></div>
                    {{-- Placeholder — Sam to replace with real club history --}}
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Fælled United blev grundlagt af en gruppe engagerede forældre med en simpel vision:
                        at skabe et trygt og inkluderende miljø, hvor børn kan dyrke sport og udvikle sig
                        som mennesker — ikke bare som atleter.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Vi er en frivilligdrevet klub, og alt hvad vi gør, gøres med kærlighed til fællesskabet.
                        Vores trænere, bestyrelsesmedlemmer og hjælpere giver af deres fritid, fordi de tror på,
                        at sport giver børn noget for livet.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        I dag tilbyder vi fodbold og håndbold for børn fra de yngste årgange op til ungdomshold,
                        og vi vokser hvert år. Uanset om dit barn drømmer om at spille på landsholdet eller bare
                        vil have det sjovt med vennerne, er der plads til alle hos Fælled United.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-[#1a472a] to-[#235c38] rounded-2xl h-64 md:h-80 flex items-center justify-center">
                    {{-- Placeholder for club photo --}}
                    <span class="text-white text-opacity-50 text-sm text-center px-4">
                        Klubfoto kommer snart
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#1a472a] mb-4">Vores værdier</h2>
                <div class="w-16 h-1 bg-[#c9a84c] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-[#1a472a] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🤝</span>
                    </div>
                    <h3 class="font-bold text-xl text-[#1a472a] mb-2">Fællesskab</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Vi er stærkere sammen. Hos os er alle velkommen, uanset baggrund og niveau.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-[#1a472a] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <h3 class="font-bold text-xl text-[#1a472a] mb-2">Udvikling</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Vi hjælper hvert barn med at vokse — sportsligt og som menneske.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-[#1a472a] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">😄</span>
                    </div>
                    <h3 class="font-bold text-xl text-[#1a472a] mb-2">Glæde</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Det skal være sjovt at spille sport. Glæde ved spillet er vores fundament.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Board members --}}
    @if($boardMembers->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#1a472a] mb-4">Bestyrelsen</h2>
                <div class="w-16 h-1 bg-[#c9a84c] mx-auto rounded-full mb-4"></div>
                <p class="text-gray-500 max-w-xl mx-auto text-sm">
                    Fælled United drives af frivillige forældre og engagerede borgere, der alle brænder for børnesport i København.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($boardMembers as $member)
                <div class="text-center group">
                    {{-- Photo placeholder or real photo --}}
                    @if($member->photo)
                    <img
                        src="{{ Storage::url($member->photo) }}"
                        alt="{{ $member->name }}"
                        class="w-28 h-28 rounded-full object-cover mx-auto mb-4 border-4 border-gray-100 group-hover:border-[#c9a84c] transition-colors"
                    >
                    @else
                    <div class="w-28 h-28 rounded-full bg-gradient-to-br from-[#1a472a] to-[#235c38] mx-auto mb-4 flex items-center justify-center border-4 border-gray-100 group-hover:border-[#c9a84c] transition-colors">
                        <span class="text-white text-3xl font-bold">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </span>
                    </div>
                    @endif

                    <h3 class="font-bold text-gray-900">{{ $member->name }}</h3>
                    <p class="text-[#c9a84c] text-sm font-medium mt-1">{{ $member->role_da }}</p>
                    @if($member->email)
                    <a href="mailto:{{ $member->email }}" class="text-xs text-gray-400 hover:text-[#1a472a] transition-colors mt-1 block">
                        {{ $member->email }}
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="bg-[#c9a84c] py-14">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-[#1a472a] mb-4">Bliv en del af familien</h2>
            <p class="text-[#1a472a] text-lg mb-8 opacity-80">Tilmeld dit barn, eller tag fat i os — vi er altid klar til en snak.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('registration.create') }}"
                   class="px-8 py-3 bg-[#1a472a] text-white font-bold rounded-lg hover:bg-[#132f1e] transition-colors">
                    Tilmeld dig
                </a>
                <a href="{{ route('contact') }}"
                   class="px-8 py-3 border-2 border-[#1a472a] text-[#1a472a] font-bold rounded-lg hover:bg-[#1a472a] hover:text-white transition-colors">
                    Kontakt os
                </a>
            </div>
        </div>
    </section>

@endsection
