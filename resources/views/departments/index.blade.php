@extends('layouts.app')

@section('title', 'Afdelinger')

@section('content')

    <div class="bg-[#1a472a] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">Afdelinger</h1>
            <p class="mt-2 text-gray-300">Fodbold og håndbold for alle aldre i København</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">
            @foreach($departments as $dept)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow group">
                {{-- Header --}}
                <div class="h-48 bg-gradient-to-br from-[#1a472a] to-[#235c38] flex flex-col items-center justify-center">
                    <span class="text-7xl mb-2">
                        @if($dept->slug === 'fodbold') ⚽
                        @elseif($dept->slug === 'haandbold') 🤾
                        @else 🏆
                        @endif
                    </span>
                    <h2 class="text-white font-extrabold text-3xl">{{ $dept->name_da }}</h2>
                </div>

                <div class="p-8">
                    <p class="text-gray-600 text-base leading-relaxed mb-6">
                        {{ $dept->description_da ?: 'Vi tilbyder ' . strtolower($dept->name_da) . ' for børn i alle aldre. Kom og vær en del af holdet!' }}
                    </p>

                    {{-- Age groups count --}}
                    @if($dept->ageGroups->count() > 0)
                    <p class="text-sm text-gray-500 mb-6">
                        <span class="font-semibold text-[#1a472a]">{{ $dept->ageGroups->count() }}</span> årgange tilgængelige
                    </p>
                    @endif

                    <a href="{{ route('departments.show', $dept->slug) }}"
                       class="inline-flex items-center px-6 py-3 bg-[#1a472a] text-white font-semibold rounded-lg hover:bg-[#235c38] transition-colors">
                        Læs mere
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="text-center mt-16">
            <h2 class="text-2xl font-bold text-[#1a472a] mb-4">Klar til at tilmelde dit barn?</h2>
            <p class="text-gray-500 mb-6">Det tager kun få minutter at tilmelde sig.</p>
            <a href="{{ route('registration.create') }}"
               class="inline-block px-8 py-4 bg-[#c9a84c] text-[#1a472a] font-bold rounded-lg text-lg hover:bg-[#dfc06a] transition-colors shadow">
                Tilmeld dig nu
            </a>
        </div>

        {{-- Start Your Own Department --}}
        <div class="mt-20 max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-[#1a472a] mb-6 text-center">Start din egen afdeling</h2>

            <div class="bg-green-50 border-2 border-[#c9a84c] rounded-2xl p-8 shadow-md">
                <div class="flex items-start gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-[#1a472a] flex items-center justify-center text-2xl shadow">
                        🏅
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-[#1a472a] mb-3">
                            Vil du starte en ny afdeling?
                        </h3>
                        <p class="text-gray-700 leading-relaxed mb-3">
                            Fælled United er en åben og voksende klub, og vi er altid interesserede i at udvide med nye sportsgrene. Har du en idé til en ny afdeling og tror du på, at der er nok interesserede familier, vil vi meget gerne høre fra dig.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-3">
                            Uanset om det drejer sig om basketball, tennis, cykling eller noget helt fjerde — vi tror på, at sport samler folk. En ny afdeling starter altid med én person med en god idé og lysten til at gøre en forskel for børn i København.
                        </p>
                        <p class="text-gray-600 text-sm italic mb-6">
                            Tag fat i bestyrelsen, og lad os tage en uforpligtende snak om mulighederne. Vi hjælper gerne med at komme i gang.
                        </p>
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center px-6 py-3 bg-[#1a472a] text-white font-bold rounded-lg hover:bg-[#235c38] transition-colors shadow">
                            ✉️ &nbsp;Kontakt bestyrelsen
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
