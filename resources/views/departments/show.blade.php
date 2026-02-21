@extends('layouts.app')

@section('title', $department->name_da)

@section('content')

    {{-- Department header --}}
    <div class="bg-[#1a472a] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-[#c9a84c] transition-colors">Hjem</a>
                <span class="mx-2">/</span>
                <a href="{{ route('departments.index') }}" class="hover:text-[#c9a84c] transition-colors">Afdelinger</a>
                <span class="mx-2">/</span>
                <span class="text-gray-200">{{ $department->name_da }}</span>
            </nav>
            <div class="flex items-center gap-4">
                <span class="text-5xl">
                    @if($department->slug === 'fodbold') ⚽
                    @elseif($department->slug === 'haandbold') 🤾
                    @else 🏆
                    @endif
                </span>
                <h1 class="text-4xl font-extrabold">{{ $department->name_da }}</h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Left: description --}}
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-[#1a472a] mb-4">Om {{ $department->name_da }}-afdelingen</h2>
                <div class="w-12 h-1 bg-[#c9a84c] rounded-full mb-6"></div>

                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    {{ $department->description_da ?: 'Vi tilbyder ' . strtolower($department->name_da) . ' for børn og unge i alle aldre i København. Hos os handler det om at have det sjovt, lære nye færdigheder og skabe venskaber for livet. Alle er velkomne — uanset niveau og erfaring.' }}
                </p>

                {{-- Age groups --}}
                @if($department->ageGroups->count() > 0)
                <h3 class="text-xl font-bold text-[#1a472a] mb-4">Årgange & hold</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($department->ageGroups as $group)
                    <a href="{{ route('departments.agegroups.show', [$department->slug, $group->slug]) }}"
                       class="block bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-[#c9a84c] hover:shadow-md transition-all group">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-gray-800 group-hover:text-[#1a472a]">{{ $group->label_da }}</h4>
                            <span class="text-xs px-2 py-1 rounded-full
                                @if($group->gender === 'boys') bg-blue-100 text-blue-700
                                @elseif($group->gender === 'girls') bg-pink-100 text-pink-700
                                @else bg-purple-100 text-purple-700
                                @endif">
                                @if($group->gender === 'boys') Drenge
                                @elseif($group->gender === 'girls') Piger
                                @else Mixed
                                @endif
                            </span>
                        </div>
                        @if($group->description_da)
                        <p class="text-gray-500 text-sm mt-2">{{ Str::limit($group->description_da, 80) }}</p>
                        @endif
                        @if($group->coach_info && !empty($group->coach_info['name']))
                        <p class="text-xs text-[#1a472a] mt-2 font-medium">👤 {{ $group->coach_info['name'] }}</p>
                        @endif
                        @if($group->training_schedule && !empty($group->training_schedule['days']))
                        <p class="text-xs text-gray-400 mt-1">📅 {{ $group->training_schedule['days'] }}</p>
                        @endif
                        <span class="mt-3 inline-flex items-center text-xs font-semibold text-[#c9a84c] group-hover:underline">
                            Se hold →
                        </span>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-amber-800">
                    <p class="font-semibold">Hold kommer snart</p>
                    <p class="text-sm mt-1">Vi er ved at sætte holdene op. Tilmeld dig allerede nu, og vi kontakter dig, når vi er klar.</p>
                </div>
                @endif
            </div>

            {{-- Right: CTA sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-[#1a472a] text-white rounded-2xl p-8 sticky top-24">
                    <h3 class="text-xl font-bold mb-2">Tilmeld dit barn</h3>
                    <div class="w-10 h-1 bg-[#c9a84c] rounded-full mb-4"></div>
                    <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                        Udfyld tilmeldingsformularen, og vi vender tilbage til dig hurtigst muligt.
                        Det er gratis at tilmelde, og du forpligter dig ikke.
                    </p>
                    <a href="{{ route('registration.create') }}?department={{ $department->slug }}"
                       class="block w-full text-center px-6 py-3 bg-[#c9a84c] text-[#1a472a] font-bold rounded-lg hover:bg-[#dfc06a] transition-colors">
                        Tilmeld dig nu
                    </a>
                    <div class="mt-6 pt-6 border-t border-[#235c38]">
                        <p class="text-gray-400 text-xs">Spørgsmål? Skriv til os:</p>
                        <a href="mailto:info@faelledunited.dk" class="text-[#c9a84c] text-sm hover:underline">
                            info@faelledunited.dk
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-10 pt-8 border-t border-gray-200">
            <a href="{{ route('departments.index') }}"
               class="inline-flex items-center text-[#1a472a] font-semibold hover:text-[#c9a84c] transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Alle afdelinger
            </a>
        </div>

    </div>

@endsection
