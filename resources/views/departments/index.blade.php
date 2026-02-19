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

    </div>

@endsection
