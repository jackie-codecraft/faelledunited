@extends('layouts.app')

@section('title', __('Kontakt'))

@section('content')

    <div class="bg-[#1a472a] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">{{ __('Kontakt os') }}</h1>
            <p class="mt-2 text-gray-300">{{ __('Vi svarer så hurtigt som muligt — typisk inden for 2 hverdage') }}</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Contact info --}}
            <div class="lg:col-span-1 space-y-8">
                <div>
                    <h2 class="text-xl font-bold text-[#1a472a] mb-4">{{ __('Find os') }}</h2>

                    <div class="space-y-4 text-sm text-gray-600">
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-[#c9a84c] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-800">{{ __('Adresse') }}</p>
                                <p>Fælledparken<br>2100 København Ø</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-[#c9a84c] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-800">{{ __('E-mail') }}</p>
                                <a href="mailto:info@faelledunited.dk" class="text-[#1a472a] hover:text-[#c9a84c] transition-colors">
                                    info@faelledunited.dk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="font-bold text-gray-800 mb-2">{{ __('Vil du tilmelde dit barn?') }}</h3>
                    <p class="text-gray-500 text-sm mb-4">{{ __('contact.reg_promo') }}</p>
                    <a href="{{ route('registration.create') }}"
                       class="inline-block px-5 py-2.5 bg-[#c9a84c] text-[#1a472a] font-bold rounded-lg text-sm hover:bg-[#dfc06a] transition-colors">
                        {{ __('Gå til tilmelding') }}
                    </a>
                </div>
            </div>

            {{-- Contact form --}}
            <div class="lg:col-span-2">

                {{-- Success --}}
                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-6 text-green-800">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="font-bold">{{ __('Besked sendt!') }}</p>
                    </div>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                @endif

                {{-- Errors --}}
                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 text-red-700">
                    <p class="font-semibold mb-2">{{ __('Ret venligst følgende fejl:') }}</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="bg-white rounded-2xl shadow-md p-8 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1" for="name">
                                {{ __('Navn') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('name') border-red-400 @enderror"
                                placeholder="Dit navn"
                            >
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1" for="email">
                                {{ __('E-mail') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('email') border-red-400 @enderror"
                                placeholder="din@email.dk"
                            >
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="subject">
                            {{ __('Emne') }} <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            value="{{ old('subject') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('subject') border-red-400 @enderror"
                            placeholder="fx. Spørgsmål om tilmelding"
                        >
                        @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="message">
                            {{ __('Besked') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('message') border-red-400 @enderror"
                            placeholder="Skriv din besked her..."
                        >{{ old('message') }}</textarea>
                        @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full px-8 py-4 bg-[#1a472a] text-white font-bold rounded-lg text-lg hover:bg-[#235c38] transition-colors shadow-md"
                        >
                            {{ __('Send besked') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
