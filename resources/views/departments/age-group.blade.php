@extends('layouts.app')

@section('title', $ageGroup->label . ' — ' . $department->name)

@section('content')

    {{-- Hero --}}
    <div class="bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('Hjem') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('departments.index') }}" class="hover:text-white transition-colors">{{ __('Afdelinger') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('departments.show', $department->slug) }}" class="hover:text-white transition-colors">{{ $department->name }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-200">{{ $ageGroup->label }}</span>
            </nav>

            <div class="flex flex-wrap items-start gap-4 justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-4xl">
                            @if($department->slug === 'fodbold') ⚽
                            @elseif($department->slug === 'haandbold') 🤾
                            @else 🏆
                            @endif
                        </span>
                        <h1 class="text-4xl font-extrabold">{{ $ageGroup->label }}</h1>
                    </div>
                    <p class="text-gray-300 text-lg">{{ $department->name }}</p>
                </div>

                {{-- Season badge — tertiary accent: visible special label --}}
                <span class="px-4 py-2 bg-[#fbbf24] text-[#0d2014] rounded-full font-bold text-sm self-start mt-1">
                    {{ __('Sæson') }} {{ date('Y') }}/{{ date('y', strtotime('+1 year')) }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Main content --}}
            <div class="lg:col-span-2 space-y-10">

                {{-- Gender badge --}}
                <div>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if($ageGroup->gender === 'boys') bg-blue-100 text-blue-700
                        @elseif($ageGroup->gender === 'girls') bg-pink-100 text-pink-700
                        @else bg-purple-100 text-purple-700
                        @endif">
                        @if($ageGroup->gender === 'boys') {{ __('Drenge') }}
                        @elseif($ageGroup->gender === 'girls') {{ __('Piger') }}
                        @else {{ __('Mixed') }}
                        @endif
                        @if($ageGroup->birth_year) · {{ $ageGroup->birth_year }} @endif
                    </span>
                </div>

                {{-- Coach info --}}
                @if($ageGroup->coach_info && !empty($ageGroup->coach_info['name']))
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-xl font-bold text-[#1a472a] mb-4 flex items-center gap-2">
                        <span>👤</span>
                        {{ __('Træner') }}
                    </h2>
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#1a472a] to-[#235c38] flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            {{ strtoupper(substr($ageGroup->coach_info['name'], 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-lg">{{ $ageGroup->coach_info['name'] }}</p>
                            @if(!empty($ageGroup->coach_info['email']))
                            <a href="mailto:{{ $ageGroup->coach_info['email'] }}" class="text-[#1a472a] text-sm hover:text-[#4a7a58] transition-colors">
                                {{ $ageGroup->coach_info['email'] }}
                            </a>
                            @endif
                            @if(!empty($ageGroup->coach_info['phone']))
                            <p class="text-gray-500 text-sm mt-0.5">📞 {{ $ageGroup->coach_info['phone'] }}</p>
                            @endif
                            @if(!empty($ageGroup->coach_info['note']))
                            <p class="text-gray-500 text-sm mt-2 italic">{{ $ageGroup->coach_info['note'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- Training schedule --}}
                @if($ageGroup->training_schedule && !empty($ageGroup->training_schedule))
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-xl font-bold text-[#1a472a] mb-5 flex items-center gap-2">
                        <span>📅</span>
                        {{ __('Træningstider') }}
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @if(!empty($ageGroup->training_schedule['days']))
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">{{ __('Dage') }}</p>
                            <p class="font-semibold text-gray-800">{{ $ageGroup->training_schedule['days'] }}</p>
                        </div>
                        @endif
                        @if(!empty($ageGroup->training_schedule['time']))
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">{{ __('Tid') }}</p>
                            <p class="font-semibold text-gray-800">{{ $ageGroup->training_schedule['time'] }}</p>
                        </div>
                        @endif
                        @if(!empty($ageGroup->training_schedule['location']))
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">{{ __('Sted') }}</p>
                            <p class="font-semibold text-gray-800">{{ $ageGroup->training_schedule['location'] }}</p>
                        </div>
                        @endif
                    </div>
                    @if(!empty($ageGroup->training_schedule['notes']))
                    <p class="mt-4 text-gray-500 text-sm italic">{{ $ageGroup->training_schedule['notes'] }}</p>
                    @endif
                </div>
                @endif

                {{-- Description --}}
                @if($ageGroup->description)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-xl font-bold text-[#1a472a] mb-4 flex items-center gap-2">
                        <span>ℹ️</span>
                        {{ __('Om holdet') }}
                    </h2>
                    <div class="w-10 h-1 bg-[#1a472a] rounded-full mb-4"></div>
                    <p class="text-gray-600 leading-relaxed">{{ $ageGroup->description }}</p>
                </div>
                @endif

            </div>

            {{-- Sidebar: CTA --}}
            <div class="lg:col-span-1">
                <div class="bg-[#1a472a] text-white rounded-2xl p-8 sticky top-24">
                    <h3 class="text-xl font-bold mb-2">{{ __('Tilmeld dit barn') }}</h3>
                    <div class="w-10 h-1 bg-white/30 rounded-full mb-4"></div>
                    <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                        {{ __('Udfyld tilmeldingsformularen, og vi vender tilbage til dig hurtigst muligt. Det er gratis at tilmelde, og du forpligter dig ikke.') }}
                    </p>
                    <a href="{{ route('registration.create') }}?department={{ $department->slug }}&agegroup={{ $ageGroup->id }}"
                       class="block w-full text-center px-6 py-3 bg-white text-[#1a472a] font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        {{ __('Tilmeld dig nu') }}
                    </a>
                    <div class="mt-6 pt-6 border-t border-[#235c38]">
                        <p class="text-gray-400 text-xs">{{ __('Spørgsmål? Skriv til os:') }}</p>
                        <a href="mailto:{{ $siteSettings->contact_email }}" class="text-white/80 text-sm hover:text-white hover:underline transition-colors">
                            {{ $siteSettings->contact_email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Back link --}}
        <div class="mt-10 pt-8 border-t border-gray-200">
            <a href="{{ route('departments.show', $department->slug) }}"
               class="inline-flex items-center text-[#1a472a] font-semibold hover:text-[#4a7a58] transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('Tilbage til') }} {{ $department->name }}
            </a>
        </div>

    </div>

@endsection
