@extends('layouts.app')

@section('title', __('Svar på henvendelse'))

@section('content')

    <div class="bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">{{ __('Svar til') }} {{ $inquiry->name }}</h1>
            <p class="mt-2 text-gray-300">{{ __('Fælled United · Intern svarformular') }}</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if (session('success'))
            {{-- Success state --}}
            <div class="bg-green-50 border border-green-200 rounded-xl p-8 text-center">
                <div class="flex justify-center mb-4">
                    <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-green-800 mb-2">{{ __('Svar sendt!') }}</h2>
                <p class="text-green-700">{{ __('Dit svar er sendt til') }} <strong>{{ $inquiry->name }}</strong> ({{ $inquiry->email }}).</p>
                <p class="text-green-600 text-sm mt-2">{{ __('Henvendelsen er markeret som besvaret.') }}</p>
            </div>
        @else
            {{-- Original inquiry context --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-8">
                <h2 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4">{{ __('Original henvendelse') }}</h2>
                <div class="space-y-3">
                    <div class="flex gap-4 text-sm">
                        <span class="w-20 text-gray-500 shrink-0">{{ __('Fra') }}</span>
                        <span class="font-semibold text-gray-800">{{ $inquiry->name }} &lt;{{ $inquiry->email }}&gt;</span>
                    </div>
                    <div class="flex gap-4 text-sm">
                        <span class="w-20 text-gray-500 shrink-0">{{ __('Emne') }}</span>
                        <span class="font-semibold text-gray-800">{{ $inquiry->subject }}</span>
                    </div>
                    <div class="flex gap-4 text-sm">
                        <span class="w-20 text-gray-500 shrink-0">{{ __('Modtaget') }}</span>
                        <span class="text-gray-600">{{ $inquiry->created_at->format('d. M Y \k\l. H:i') }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <p class="text-sm text-gray-500 mb-2">{{ __('Besked') }}</p>
                        <p class="text-gray-800 text-sm leading-relaxed whitespace-pre-wrap">{{ $inquiry->message }}</p>
                    </div>
                </div>
            </div>

            @if ($inquiry->status === 'replied')
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <svg class="h-5 w-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-amber-800">{{ __('Denne henvendelse er allerede besvaret.') }}</p>
                        <p class="text-sm text-amber-700 mt-0.5">{{ __('Du kan stadig sende et nyt svar ved at udfylde formularen nedenfor.') }}</p>
                    </div>
                </div>
            @endif

            {{-- Reply form --}}
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 mb-6">{{ __('Skriv dit svar') }}</h2>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ $postUrl }}">
                    @csrf

                    <div class="mb-6">
                        <label for="reply_message" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Svar til') }} {{ $inquiry->name }} <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="reply_message"
                            name="reply_message"
                            rows="8"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent placeholder-gray-400 @error('reply_message') border-red-400 @enderror"
                            placeholder="{{ __('Skriv dit svar her...') }}"
                        >{{ old('reply_message') }}</textarea>
                        @error('reply_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-400">{{ __('Svaret sendes til') }}: {{ $inquiry->email }}</p>
                        <button
                            type="submit"
                            class="bg-[#1a472a] hover:bg-[#235c38] text-white font-semibold px-6 py-3 rounded-lg text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:ring-offset-2"
                        >
                            {{ __('Send svar') }}
                        </button>
                    </div>
                </form>
            </div>
        @endif

    </div>

@endsection
