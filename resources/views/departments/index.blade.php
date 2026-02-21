@extends('layouts.app')

@section('title', __('Afdelinger'))

@section('content')

    <div class="bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">{{ __('Afdelinger') }}</h1>
            <p class="mt-2 text-gray-300">{{ __('Fodbold og håndbold for alle aldre i København') }}</p>
        </div>
    </div>

    <div class="bg-[#0f0f0f] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">
                @foreach($departments as $dept)
                <div class="bg-[#171f1a] border border-[#1e2e22] rounded-2xl overflow-hidden hover:border-white/20 transition-all group">
                    {{-- Header --}}
                    <div class="relative h-56 overflow-hidden"
                         style="background-image: url('{{ asset('images/departments/' . $dept->slug . '.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a1a0f]/90 via-[#0a1a0f]/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <span class="text-xs font-bold tracking-widest uppercase text-white/50 block mb-1">
                                {{ __('Afdeling') }}
                            </span>
                            <h2 class="text-white font-extrabold text-2xl leading-tight">
                                {{ app()->getLocale() === 'en' ? $dept->name_en : $dept->name_da }}
                            </h2>
                        </div>
                    </div>

                    <div class="p-8">
                        <p class="text-gray-400 text-base leading-relaxed mb-6">
                            {{ app()->getLocale() === 'en'
                                ? ($dept->description_en ?: 'We offer ' . strtolower($dept->name_en ?? $dept->name_da) . ' for children of all ages. Come and be part of the team!')
                                : ($dept->description_da ?: 'Vi tilbyder ' . strtolower($dept->name_da) . ' for børn i alle aldre. Kom og vær en del af holdet!') }}
                        </p>

                        @if($dept->ageGroups->count() > 0)
                        <p class="text-sm text-gray-500 mb-6">
                            <span class="font-semibold text-[#4a7a58]">{{ $dept->ageGroups->count() }}</span> {{ __('årgange tilgængelige') }}
                        </p>
                        @endif

                        <a href="{{ route('departments.show', $dept->slug) }}"
                           class="inline-flex items-center px-6 py-3 bg-white text-[#1a472a] font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                            {{ __('Læs mere') }}
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
                <h2 class="text-2xl font-bold text-white mb-4">{{ __('Klar til at tilmelde dit barn?') }}</h2>
                <p class="text-gray-400 mb-6">{{ __('Det tager kun få minutter at tilmelde sig.') }}</p>
                <a href="{{ route('registration.create') }}"
                   class="inline-block px-8 py-4 bg-white text-[#1a472a] font-bold rounded-lg text-lg hover:bg-gray-100 transition-colors shadow">
                    {{ __('Tilmeld dig nu') }}
                </a>
            </div>

            {{-- Start Your Own Department --}}
            <div class="mt-20 max-w-3xl mx-auto">
                <h2 class="text-2xl font-bold text-white mb-6 text-center">{{ __('Start din egen afdeling') }}</h2>

                <div class="bg-[#171f1a] border border-[#1e2e22] rounded-2xl p-8 shadow-md">
                    <div class="flex items-start gap-5">
                        <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-[#1a472a] flex items-center justify-center text-2xl shadow">
                            🏅
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-3">
                                {{ __('Vil du starte en ny afdeling?') }}
                            </h3>
                            <p class="text-gray-400 leading-relaxed mb-3">
                                {{ __('start_dept_para_1') }}
                            </p>
                            <p class="text-gray-400 leading-relaxed mb-3">
                                {{ __('start_dept_para_2') }}
                            </p>
                            <p class="text-gray-500 text-sm italic mb-6">
                                {{ __('start_dept_para_3') }}
                            </p>
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center px-6 py-3 bg-white text-[#1a472a] font-bold rounded-lg hover:bg-gray-100 transition-colors shadow">
                                ✉️ &nbsp;{{ __('Kontakt bestyrelsen') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
