@extends('layouts.app')

@section('title', app()->getLocale() === 'en' ? 'Privacy Policy' : 'Privatlivspolitik')

@section('content')

    <div class="bg-gradient-to-br from-[#0f2718] via-[#1a472a] to-[#0d2014] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(app()->getLocale() === 'en')
                <h1 class="text-4xl font-extrabold">Privacy Policy</h1>
                <p class="mt-2 text-gray-300">How Fælled United handles your personal data</p>
            @else
                <h1 class="text-4xl font-extrabold">Privatlivspolitik</h1>
                <p class="mt-2 text-gray-300">Sådan behandler Fælled United dine personoplysninger</p>
            @endif
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="bg-white rounded-2xl shadow-md p-8 md:p-12">

            <div class="prose prose-lg max-w-none
                        prose-headings:text-[#1a472a]
                        prose-h1:text-3xl prose-h2:text-2xl prose-h3:text-xl
                        prose-a:text-[#1a472a] prose-a:no-underline hover:prose-a:text-[#4a7a58]
                        prose-hr:border-gray-200
                        prose-blockquote:border-l-[#1a472a]
                        prose-table:text-sm
                        prose-th:bg-gray-50 prose-th:text-[#1a472a]">
                {!! $contentHtml !!}
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 text-xs text-gray-400">
                @if(app()->getLocale() === 'en')
                    Last updated: {{ $updatedAt?->isoFormat('D MMMM YYYY') ?? now()->isoFormat('D MMMM YYYY') }}
                @else
                    Sidst opdateret: {{ $updatedAt?->isoFormat('D. MMMM YYYY') ?? now()->isoFormat('D. MMMM YYYY') }}
                @endif
            </div>
        </div>

    </div>

@endsection
