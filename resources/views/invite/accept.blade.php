<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Acceptér invitation') }} — Fælled United</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">

<div class="w-full max-w-md">
    {{-- Club header --}}
    <div class="text-center mb-8">
        <img src="{{ asset('images/logo.jpg') }}"
             alt="Fælled United"
             class="w-20 h-20 rounded-full mx-auto mb-4 border-4 border-[#1a472a] shadow-md object-cover">
        <h1 class="font-['Bebas_Neue'] text-3xl text-[#1a472a] tracking-wider">FÆLLED UNITED</h1>
        <p class="text-gray-500 text-sm mt-1 uppercase tracking-widest">Administration</p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-1">Sæt dit kodeord</h2>
        <p class="text-gray-500 text-sm mb-6">
            Hej <span class="font-medium text-gray-700">{{ $user->name }}</span> — vælg et kodeord for at aktivere din konto.
        </p>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('invite.accept', $token) }}" class="space-y-4">
            @csrf

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Kodeord
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       autocomplete="new-password"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50
                              focus:outline-none focus:ring-2 focus:ring-[#1a472a]/30 focus:border-[#1a472a]
                              text-gray-900 text-sm transition">
                <p class="text-xs text-gray-400 mt-1">Minimum 8 tegn</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gentag kodeord
                </label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       autocomplete="new-password"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50
                              focus:outline-none focus:ring-2 focus:ring-[#1a472a]/30 focus:border-[#1a472a]
                              text-gray-900 text-sm transition">
            </div>

            <button type="submit"
                    class="w-full bg-[#1a472a] hover:bg-[#153a21] text-white font-semibold py-3 px-6
                           rounded-xl transition text-sm tracking-wide mt-2">
                Aktiver konto
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">
        Fælled United — Administration
    </p>
</div>

</body>
</html>
