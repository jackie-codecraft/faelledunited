<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation — Fælled United</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">

<div class="w-full max-w-md text-center">
    <img src="{{ asset('images/logo.jpg') }}"
         alt="Fælled United"
         class="w-20 h-20 rounded-full mx-auto mb-4 border-4 border-[#1a472a] shadow-md object-cover">
    <h1 class="font-['Bebas_Neue'] text-3xl text-[#1a472a] tracking-wider mb-6">FÆLLED UNITED</h1>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        @if($reason === 'already_accepted')
            <div class="text-4xl mb-4">✅</div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Konto allerede aktiveret</h2>
            <p class="text-gray-500 text-sm mb-6">
                Denne invitation er allerede brugt. Log ind med dit kodeord.
            </p>
        @elseif($reason === 'expired')
            <div class="text-4xl mb-4">⏰</div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Invitationen er udløbet</h2>
            <p class="text-gray-500 text-sm mb-6">
                Invitationslinks er gyldige i 7 dage. Bed en administrator om at sende et nyt link.
            </p>
        @else
            <div class="text-4xl mb-4">🔗</div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Ugyldigt link</h2>
            <p class="text-gray-500 text-sm mb-6">
                Dette invitationslink er ikke gyldigt. Kontakt en administrator.
            </p>
        @endif

        <a href="/admin/login"
           class="inline-block bg-[#1a472a] hover:bg-[#153a21] text-white font-semibold
                  py-2.5 px-6 rounded-xl transition text-sm">
            Gå til login
        </a>
    </div>
</div>

</body>
</html>
