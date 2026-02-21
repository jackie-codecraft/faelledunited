@extends('layouts.app')

@section('title', __('Om klubben'))

@section('content')

    <div class="bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">{{ __('Om Fælled United') }}</h1>
            <p class="mt-2 text-gray-300">{{ __('Lær os at kende — hvem vi er og hvad vi tror på') }}</p>
        </div>
    </div>

    {{-- Club story --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-[#1a472a] mb-4">{{ __('Vores historie') }}</h2>
                    <div class="w-16 h-1 bg-[#1a472a] rounded-full mb-6"></div>
                    <p class="text-gray-600 leading-relaxed mb-4">{{ __('about.history.p1') }}</p>
                    <p class="text-gray-600 leading-relaxed mb-4">{{ __('about.history.p2') }}</p>
                    <p class="text-gray-600 leading-relaxed">{{ __('about.history.p3') }}</p>
                </div>
                <div class="rounded-2xl overflow-hidden h-64 md:h-80 shadow-lg">
                    <img src="{{ asset('images/club-photo.jpg') }}"
                         alt="Fælled United"
                         class="w-full h-full object-cover object-center">
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#1a472a] mb-4">{{ __('Vores værdier') }}</h2>
                <div class="w-16 h-1 bg-[#1a472a] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-[#1a472a] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🤝</span>
                    </div>
                    <h3 class="font-bold text-xl text-[#1a472a] mb-2">{{ __('Fællesskab') }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ __('value.community') }}
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-[#1a472a] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <h3 class="font-bold text-xl text-[#1a472a] mb-2">{{ __('Udvikling') }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ __('value.development') }}
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-[#1a472a] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">😄</span>
                    </div>
                    <h3 class="font-bold text-xl text-[#1a472a] mb-2">{{ __('Glæde') }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ __('value.joy') }}
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
                <h2 class="text-3xl font-bold text-[#1a472a] mb-4">{{ __('Bestyrelsen') }}</h2>
                <div class="w-16 h-1 bg-[#1a472a] mx-auto rounded-full mb-4"></div>
                <p class="text-gray-500 max-w-xl mx-auto text-sm">
                    {{ __('about.board.body') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($boardMembers as $member)
                <div class="text-center group">
                    @if($member->photo)
                    <img
                        src="{{ Storage::url($member->photo) }}"
                        alt="{{ $member->name }}"
                        class="w-28 h-28 rounded-full object-cover mx-auto mb-4 border-4 border-gray-100 group-hover:border-[#1a472a] transition-colors"
                    >
                    @else
                    <div class="w-28 h-28 rounded-full bg-gradient-to-br from-[#1a472a] to-[#235c38] mx-auto mb-4 flex items-center justify-center border-4 border-gray-100 group-hover:border-[#1a472a] transition-colors">
                        <span class="text-white text-3xl font-bold">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </span>
                    </div>
                    @endif

                    <h3 class="font-bold text-gray-900">{{ $member->name }}</h3>
                    <p class="text-[#4a7a58] text-sm font-medium mt-1">{{ $member->role_da }}</p>
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
    <section class="bg-[#0f0f0f] py-14">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-white mb-4">{{ __('Bliv en del af familien') }}</h2>
            <p class="text-gray-400 text-lg mb-8">{{ __('about.cta.body') }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('registration.create') }}"
                   class="px-8 py-3 bg-white text-[#1a472a] font-bold rounded-lg hover:bg-gray-100 transition-colors">
                    {{ __('Tilmeld dig') }}
                </a>
                <a href="{{ route('contact') }}"
                   class="px-8 py-3 border-2 border-white/40 text-white font-bold rounded-lg hover:bg-white hover:text-[#1a472a] transition-colors">
                    {{ __('Kontakt os') }}
                </a>
            </div>
        </div>
    </section>

@endsection
