@extends('layouts.app')

@section('title', app()->getLocale() === 'en' ? 'Unsubscribe' : 'Afmeld nyhedsbrev')

@section('content')

    <div class="bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(app()->getLocale() === 'en')
                <h1 class="text-4xl font-extrabold">Unsubscribe</h1>
                <p class="mt-2 text-gray-300">Manage your mailing list preferences</p>
            @else
                <h1 class="text-4xl font-extrabold">Afmeld nyhedsbrev</h1>
                <p class="mt-2 text-gray-300">Administrer dine mailinglisteindstillinger</p>
            @endif
        </div>
    </div>

    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="bg-white rounded-2xl shadow-md p-8 md:p-10 text-center">

            @if($subscriber)
                {{-- Valid token — ask for confirmation --}}
                <div class="w-14 h-14 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                @if(app()->getLocale() === 'en')
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Confirm unsubscribe</h2>
                    <p class="text-gray-500 text-sm mb-2 leading-relaxed">
                        You are about to unsubscribe <strong class="text-gray-700">{{ $subscriber->email }}</strong> from the Fælled United mailing list.
                    </p>
                    <p class="text-gray-400 text-sm mb-8">You can sign up again at any time on our website.</p>
                @else
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Bekræft afmelding</h2>
                    <p class="text-gray-500 text-sm mb-2 leading-relaxed">
                        Du er ved at afmelde <strong class="text-gray-700">{{ $subscriber->email }}</strong> fra Fælled Uniteds mailingliste.
                    </p>
                    <p class="text-gray-400 text-sm mb-8">Du kan til enhver tid tilmelde dig igen på vores hjemmeside.</p>
                @endif

                <form method="POST" action="{{ route('unsubscribe.process') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition-colors">
                        {{ app()->getLocale() === 'en' ? 'Yes, unsubscribe me' : 'Ja, afmeld mig' }}
                    </button>
                </form>

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        {{ app()->getLocale() === 'en' ? 'No, take me back' : 'Nej, tag mig tilbage' }}
                    </a>
                </div>

            @else
                {{-- Invalid or missing token --}}
                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                @if(app()->getLocale() === 'en')
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Link not found</h2>
                    <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                        This unsubscribe link is invalid or has already been used. If you are still receiving emails, please contact us at
                        <a href="mailto:info@faelledunited.dk" class="text-[#1a472a] hover:underline">info@faelledunited.dk</a>.
                    </p>
                @else
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Linket blev ikke fundet</h2>
                    <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                        Dette afmeldingslink er ugyldigt eller allerede brugt. Modtager du stadig e-mails, kan du kontakte os på
                        <a href="mailto:info@faelledunited.dk" class="text-[#1a472a] hover:underline">info@faelledunited.dk</a>.
                    </p>
                @endif

                <a href="{{ route('home') }}"
                   class="inline-flex items-center px-6 py-3 bg-[#1a472a] text-white text-sm font-bold rounded-xl hover:bg-[#235c38] transition-colors">
                    {{ app()->getLocale() === 'en' ? 'Back to home' : 'Tilbage til forsiden' }}
                </a>

            @endif

        </div>

    </div>

@endsection
