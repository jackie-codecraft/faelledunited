@extends('layouts.app')

@section('title', app()->getLocale() === 'en' ? 'Unsubscribed' : 'Afmeldt')

@section('content')

    <div class="bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(app()->getLocale() === 'en')
                <h1 class="text-4xl font-extrabold">You're unsubscribed</h1>
            @else
                <h1 class="text-4xl font-extrabold">Du er afmeldt</h1>
            @endif
        </div>
    </div>

    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="bg-white rounded-2xl shadow-md p-8 md:p-10 text-center">

            <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-6">
                <svg class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            @if(app()->getLocale() === 'en')
                <h2 class="text-xl font-bold text-gray-900 mb-3">Done — you've been removed</h2>
                <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                    Your email address has been removed from the Fælled United mailing list. You won't receive any further emails from us.
                    <br><br>
                    You are always welcome to sign up again on our website.
                </p>
            @else
                <h2 class="text-xl font-bold text-gray-900 mb-3">Du er nu afmeldt</h2>
                <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                    Din e-mailadresse er fjernet fra Fælled Uniteds mailingliste. Du modtager ikke flere e-mails fra os.
                    <br><br>
                    Du er altid velkommen til at tilmelde dig igen på vores hjemmeside.
                </p>
            @endif

            <a href="{{ route('home') }}"
               class="inline-flex items-center px-6 py-3 bg-[#1a472a] text-white text-sm font-bold rounded-xl hover:bg-[#235c38] transition-colors">
                {{ app()->getLocale() === 'en' ? 'Back to home' : 'Tilbage til forsiden' }}
            </a>

        </div>

    </div>

@endsection
