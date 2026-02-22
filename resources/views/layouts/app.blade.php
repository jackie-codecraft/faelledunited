<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Fælled United — Mere end en klub, en familie. Fodbold og håndbold i København.')">
    <title>@hasSection('title') @yield('title') — Fælled United @else Fælled United @endif</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Fælled United" class="w-12 h-12 rounded-full object-cover ring-2 ring-white/30">
                    <span class="font-[family-name:var(--font-display)] text-2xl tracking-wide group-hover:text-white/80 transition-colors">
                        Fælled United
                    </span>
                </a>

                {{-- Desktop navigation --}}
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors {{ request()->routeIs('home') ? 'text-white font-semibold' : 'text-white/80' }}">
                        {{ __('Hjem') }}
                    </a>
                    <a href="{{ route('news.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors {{ request()->routeIs('news.*') ? 'text-white font-semibold' : 'text-white/80' }}">
                        {{ __('Nyheder') }}
                    </a>
                    <a href="{{ route('departments.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors {{ request()->routeIs('departments.*') ? 'text-white font-semibold' : 'text-white/80' }}">
                        {{ __('Afdelinger') }}
                    </a>
                    <a href="{{ route('about') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors {{ request()->routeIs('about') ? 'text-white font-semibold' : 'text-white/80' }}">
                        {{ __('Om klubben') }}
                    </a>
                    <a href="{{ route('contact') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors {{ request()->routeIs('contact') ? 'text-white font-semibold' : 'text-white/80' }}">
                        {{ __('Kontakt') }}
                    </a>

                    {{-- Language switcher (desktop) --}}
                    <div class="ml-2 flex items-center gap-0.5 border border-[#235c38] rounded-md overflow-hidden">
                        <a href="{{ route('language.switch', 'da') }}"
                           class="px-2.5 py-1.5 text-xs font-bold transition-colors {{ app()->getLocale() === 'da' ? 'bg-white text-[#1a472a]' : 'text-gray-300 hover:bg-[#235c38] hover:text-white' }}">
                            DA
                        </a>
                        <a href="{{ route('language.switch', 'en') }}"
                           class="px-2.5 py-1.5 text-xs font-bold transition-colors {{ app()->getLocale() === 'en' ? 'bg-white text-[#1a472a]' : 'text-gray-300 hover:bg-[#235c38] hover:text-white' }}">
                            EN
                        </a>
                    </div>

                    <a href="{{ route('registration.create') }}" class="ml-3 px-4 py-2 bg-white text-[#1a472a] rounded-md text-sm font-bold hover:bg-gray-100 transition-colors">
                        {{ __('Tilmeld dig') }}
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
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors">{{ __('Hjem') }}</a>
                <a href="{{ route('news.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors">{{ __('Nyheder') }}</a>
                <a href="{{ route('departments.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors">{{ __('Afdelinger') }}</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors">{{ __('Om klubben') }}</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-[#235c38] hover:text-white transition-colors">{{ __('Kontakt') }}</a>
                <a href="{{ route('registration.create') }}" class="block mt-2 px-4 py-2 bg-white text-[#1a472a] rounded-md text-sm font-bold text-center hover:bg-gray-100 transition-colors">{{ __('Tilmeld dig') }}</a>

                {{-- Language switcher (mobile) --}}
                <div class="flex items-center gap-2 pt-3 px-3 border-t border-[#235c38] mt-2">
                    <span class="text-xs text-gray-400 mr-1">{{ __('Sprog') ?? 'Sprog' }}:</span>
                    <a href="{{ route('language.switch', 'da') }}"
                       class="px-3 py-1 text-xs font-bold rounded transition-colors {{ app()->getLocale() === 'da' ? 'bg-white text-[#1a472a]' : 'text-gray-300 hover:text-white border border-[#235c38]' }}">
                        🇩🇰 DA
                    </a>
                    <a href="{{ route('language.switch', 'en') }}"
                       class="px-3 py-1 text-xs font-bold rounded transition-colors {{ app()->getLocale() === 'en' ? 'bg-white text-[#1a472a]' : 'text-gray-300 hover:text-white border border-[#235c38]' }}">
                        🇬🇧 EN
                    </a>
                </div>
            </nav>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0a0a0a] text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Club info --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Fælled United" class="w-10 h-10 rounded-full object-cover ring-2 ring-white/20">
                        <span class="font-bold text-lg">Fælled United</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        {{ __('Mere end en klub — en familie') }}<br>
                        {{ __('Fodbold og håndbold for børn i København.') }}
                    </p>
                    <p class="text-gray-500 text-sm mt-3">
                        Ørestad, København S<br>
                        <a href="mailto:{{ $siteSettings->contact_email }}" class="hover:text-white transition-colors">{{ $siteSettings->contact_email }}</a>
                    </p>
                </div>

                {{-- Quick links --}}
                <div>
                    <h3 class="font-semibold text-[#4a7a58] mb-4 uppercase text-xs tracking-wider">{{ __('Links') }}</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('Hjem') }}</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-white transition-colors">{{ __('Nyheder') }}</a></li>
                        <li><a href="{{ route('departments.index') }}" class="hover:text-white transition-colors">{{ __('Afdelinger') }}</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">{{ __('Om klubben') }}</a></li>
                        <li><a href="{{ route('vedtaegter') }}" class="hover:text-white transition-colors">{{ __('Vedtægter') }}</a></li>
                        <li><a href="{{ route('privacy-policy') }}" class="hover:text-white transition-colors">{{ __('Privatlivspolitik') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">{{ __('Kontakt') }}</a></li>
                    </ul>
                </div>

                {{-- Social --}}
                <div>
                    <h3 class="font-semibold text-[#4a7a58] mb-4 uppercase text-xs tracking-wider">{{ __('Følg os') }}</h3>
                    <div class="flex gap-3">
                        @if($siteSettings->facebook_url)
                        <a href="{{ $siteSettings->facebook_url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-[#1a472a] flex items-center justify-center hover:bg-white hover:text-[#1a472a] transition-colors text-sm font-bold" title="Facebook">
                            f
                        </a>
                        @endif
                        @if($siteSettings->instagram_url)
                        <a href="{{ $siteSettings->instagram_url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-[#1a472a] flex items-center justify-center hover:bg-white hover:text-[#1a472a] transition-colors text-sm font-bold" title="Instagram">
                            ig
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-t border-[#1a1a1a] mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-600">
                <p>{{ __('footer.copyright', ['year' => date('Y')]) }}</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('privacy-policy') }}" class="hover:text-gray-400 transition-colors">
                        {{ app()->getLocale() === 'en' ? 'Privacy Policy' : 'Privatlivspolitik' }}
                    </a>
                    <a href="{{ route('vedtaegter') }}" class="hover:text-gray-400 transition-colors">
                        {{ app()->getLocale() === 'en' ? 'Statutes' : 'Vedtægter' }}
                    </a>
                </div>
                <div class="text-right space-y-0.5">
                    <p>{{ app()->getLocale() === 'en' ? 'Administered with love by volunteers' : 'Drevet med kærlighed af frivillige' }}</p>
                    <p>Built by <a href="https://sc-codecraft.com" target="_blank" rel="noopener" class="hover:text-gray-400 transition-colors">SC CodeCraft</a></p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
