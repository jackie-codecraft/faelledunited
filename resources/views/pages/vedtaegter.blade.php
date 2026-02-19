@extends('layouts.app')

@section('title', 'Vedtægter')

@section('content')

    <div class="bg-[#1a472a] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">Vedtægter</h1>
            <p class="mt-2 text-gray-300">Fælled Uniteds gældende vedtægter</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="bg-white rounded-2xl shadow-md p-8 md:p-12">

            {{-- Markdown content rendered as HTML --}}
            <div class="prose prose-lg max-w-none
                        prose-headings:text-[#1a472a]
                        prose-h1:text-3xl prose-h2:text-2xl prose-h3:text-xl
                        prose-a:text-[#1a472a] prose-a:no-underline hover:prose-a:text-[#c9a84c]
                        prose-hr:border-gray-200
                        prose-blockquote:border-l-[#c9a84c]">
                {!! $contentHtml !!}
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 text-xs text-gray-400">
                Sidst opdateret: {{ now()->isoFormat('MMMM YYYY') }}
            </div>
        </div>

    </div>

@endsection
