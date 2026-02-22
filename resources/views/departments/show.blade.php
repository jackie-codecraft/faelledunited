@extends('layouts.app')

@section('title', $department->name)

@section('content')

    {{-- Department header --}}
    @php
        $deptHero = $department->hero_image
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($department->hero_image)
            : asset('images/departments/' . $department->slug . '.jpg');
    @endphp
    <div class="relative text-white py-12 overflow-hidden"
         style="background-image: url('{{ $deptHero }}'); background-size: cover; background-position: center;">
        {{-- Dark overlay so text stays readable --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#0f2718]/90 via-[#1a472a]/80 to-[#0d2014]/90"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('Hjem') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('departments.index') }}" class="hover:text-white transition-colors">{{ __('Afdelinger') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-200">{{ $department->name }}</span>
            </nav>
            <div>
                <span class="text-xs font-bold tracking-widest uppercase text-white/40 block mb-2">{{ __('Afdeling') }}</span>
                <h1 class="text-4xl md:text-5xl font-extrabold">{{ $department->name }}</h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Left: description --}}
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-[#1a472a] mb-4">
                    @if(app()->getLocale() === 'en')
                        About the {{ $department->name }} department
                    @else
                        Om {{ $department->name }}-afdelingen
                    @endif
                </h2>
                <div class="w-12 h-1 bg-[#1a472a] rounded-full mb-6"></div>

                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    {{ app()->getLocale() === 'en'
                        ? ($department->description ?: 'We offer ' . strtolower($department->name ?? $department->name) . ' for children and young people of all ages in Copenhagen. With us it is about having fun, learning new skills and creating friendships for life. Everyone is welcome — regardless of level and experience.')
                        : ($department->description ?: 'Vi tilbyder ' . strtolower($department->name) . ' for børn og unge i alle aldre i København. Hos os handler det om at have det sjovt, lære nye færdigheder og skabe venskaber for livet. Alle er velkomne — uanset niveau og erfaring.') }}
                </p>

                {{-- Age groups --}}
                @if($department->ageGroups->count() > 0)
                <h3 class="text-xl font-bold text-[#1a472a] mb-4">{{ __('Årgange & hold') }}</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($department->ageGroups as $group)
                    <a href="{{ route('departments.agegroups.show', [$department->slug, $group->slug]) }}"
                       class="block bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-[#1a472a] hover:shadow-md transition-all group">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-gray-800 group-hover:text-[#1a472a]">
                                {{ $group->label }}
                            </h4>
                            <span class="text-xs px-2 py-1 rounded-full
                                @if($group->gender === 'boys') bg-blue-100 text-blue-700
                                @elseif($group->gender === 'girls') bg-pink-100 text-pink-700
                                @else bg-purple-100 text-purple-700
                                @endif">
                                @if($group->gender === 'boys') {{ __('Drenge') }}
                                @elseif($group->gender === 'girls') {{ __('Piger') }}
                                @else {{ __('Mixed') }}
                                @endif
                            </span>
                        </div>
                        @if($group->description)
                        <p class="text-gray-500 text-sm mt-2">
                            {{ Str::limit(app()->getLocale() === 'en' ? ($group->description ?: $group->description) : $group->description, 80) }}
                        </p>
                        @endif
                        @if($group->coach_info && !empty($group->coach_info['name']))
                        <p class="text-xs text-[#1a472a] mt-2 font-medium">👤 {{ $group->coach_info['name'] }}</p>
                        @endif
                        @if($group->training_schedule && !empty($group->training_schedule['days']))
                        <p class="text-xs text-gray-400 mt-1">📅 {{ $group->training_schedule['days'] }}</p>
                        @endif
                        <span class="mt-3 inline-flex items-center text-xs font-semibold text-[#1a472a] group-hover:underline">
                            {{ __('Se hold') }}
                        </span>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-amber-800">
                    <p class="font-semibold">{{ __('Hold kommer snart') }}</p>
                    <p class="text-sm mt-1">{{ __('teams.coming_soon.body') }}</p>
                </div>
                @endif
            </div>

            {{-- Right: CTA sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-[#1a472a] text-white rounded-2xl p-8 sticky top-24">
                    <h3 class="text-xl font-bold mb-2">{{ __('Tilmeld dit barn') }}</h3>
                    <div class="w-10 h-1 bg-white/30 rounded-full mb-4"></div>
                    <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                        {{ __('dept.cta.body') }}
                    </p>
                    <a href="{{ route('registration.create') }}?department={{ $department->slug }}"
                       class="block w-full text-center px-6 py-3 bg-white text-[#1a472a] font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        {{ __('Tilmeld dig nu') }}
                    </a>
                    <div class="mt-6 pt-6 border-t border-[#235c38]">
                        <p class="text-gray-400 text-xs">{{ __('Spørgsmål? Skriv til os:') }}</p>
                        <a href="mailto:info@faelledunited.dk" class="text-white/80 text-sm hover:text-white hover:underline transition-colors">
                            info@faelledunited.dk
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-10 pt-8 border-t border-gray-200">
            <a href="{{ route('departments.index') }}"
               class="inline-flex items-center text-[#1a472a] font-semibold hover:text-[#4a7a58] transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('Alle afdelinger') }}
            </a>
        </div>

    </div>

@endsection
