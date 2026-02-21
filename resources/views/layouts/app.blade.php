<!DOCTYPE html>
<html lang="da" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Fælled United — Mere end en klub, en familie. Fodbold og håndbold i København.')">
    <title>@hasSection('title') @yield('title') — Fælled United @else Fælled United @endif</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 font-sans antialiased">

    {{-- NAVBAR --}}
    <header
        x-data="{ open: false }"
        class="bg-[#1a472a] text-white shadow-md sticky top-0 z-50"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo / Club name --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-full bg-[#c9a84c] flex items-center justify-center font-bold text-[#1a472a] text-sm leading-none select-none">
                        FU
                    </div>
                    <span class="font-bold text-xl tracking-tight group-hover:text-[#c9a84c] transition-colors">
                        Fælled United
                    </span>
                </a>

                {{-- Desktop navigation --}}
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors {{ request()->routeIs('home') ? 'text-[#c9a84c]' : 'text-white' }}">
                        Hjem
                    </a>
                    <a href="{{ route('news.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors {{ request()->routeIs('news.*') ? 'text-[#c9a84c]' : 'text-white' }}">
                        Nyheder
                    </a>
                    <a href="{{ route('departments.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors {{ request()->routeIs('departments.*') ? 'text-[#c9a84c]' : 'text-white' }}">
                        Afdelinger
                    </a>
                    <a href="{{ route('about') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors {{ request()->routeIs('about') ? 'text-[#c9a84c]' : 'text-white' }}">
                        Om klubben
                    </a>
                    <a href="{{ route('contact') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors {{ request()->routeIs('contact') ? 'text-[#c9a84c]' : 'text-white' }}">
                        Kontakt
                    </a>
                    <a href="{{ route('registration.create') }}" class="ml-3 px-4 py-2 bg-[#c9a84c] text-[#1a472a] rounded-md text-sm font-bold hover:bg-[#dfc06a] transition-colors">
                        Tilmeld dig
                    </a>
                </nav>

                {{-- Mobile hamburger --}}
                <button
                    @click="open = !open"
                    class="md:hidden p-2 rounded-md hover:bg-[#235c38] transition-colors focus:outline-none"
                    aria-label="Åbn menu"
                >
                    <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden border-t border-[#235c38]"
        >
            <nav class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors">Hjem</a>
                <a href="{{ route('news.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors">Nyheder</a>
                <a href="{{ route('departments.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors">Afdelinger</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors">Om klubben</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-[#c9a84c] transition-colors">Kontakt</a>
                <a href="{{ route('registration.create') }}" class="block mt-2 px-4 py-2 bg-[#c9a84c] text-[#1a472a] rounded-md text-sm font-bold text-center hover:bg-[#dfc06a] transition-colors">Tilmeld dig</a>
            </nav>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#132f1e] text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Club info --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-[#c9a84c] flex items-center justify-center font-bold text-[#1a472a] text-xs">FU</div>
                        <span class="font-bold text-lg">Fælled United</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Mere end en klub — en familie.<br>
                        Fodbold og håndbold for børn i København.
                    </p>
                    <p class="text-gray-500 text-sm mt-3">
                        {{-- Address placeholder — Sam to confirm --}}
                        Fælledparken, København Ø<br>
                        <a href="mailto:info@faelledunited.dk" class="hover:text-[#c9a84c] transition-colors">info@faelledunited.dk</a>
                    </p>
                </div>

                {{-- Quick links --}}
                <div>
                    <h3 class="font-semibold text-[#c9a84c] mb-4 uppercase text-xs tracking-wider">Links</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Hjem</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-white transition-colors">Nyheder</a></li>
                        <li><a href="{{ route('departments.index') }}" class="hover:text-white transition-colors">Afdelinger</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">Om klubben</a></li>
                        <li><a href="{{ route('vedtaegter') }}" class="hover:text-white transition-colors">Vedtægter</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Kontakt</a></li>
                    </ul>
                </div>

                {{-- Social --}}
                <div>
                    <h3 class="font-semibold text-[#c9a84c] mb-4 uppercase text-xs tracking-wider">Følg os</h3>
                    <div class="flex gap-3">
                        {{-- Facebook placeholder — Sam to add real URL --}}
                        <a href="#" class="w-9 h-9 rounded-full bg-[#1a472a] flex items-center justify-center hover:bg-[#c9a84c] hover:text-[#1a472a] transition-colors text-sm font-bold" title="Facebook">
                            f
                        </a>
                        {{-- Instagram placeholder — Sam to add real URL --}}
                        <a href="#" class="w-9 h-9 rounded-full bg-[#1a472a] flex items-center justify-center hover:bg-[#c9a84c] hover:text-[#1a472a] transition-colors text-sm font-bold" title="Instagram">
                            ig
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#235c38] mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-600">
                <p>&copy; {{ date('Y') }} Fælled United. Alle rettigheder forbeholdes.</p>
                <p>Bygget med ❤️ af frivillige forældre</p>
            </div>
        </div>
    </footer>

</body>
</html>
