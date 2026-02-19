@extends('layouts.app')

@section('title', 'Tilmeld dig')

@section('content')

    <div class="bg-[#1a472a] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold">Tilmeld dig</h1>
            <p class="mt-2 text-gray-300">Udfyld formularen herunder for at tilmelde dit barn</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Success message --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-6 text-green-800">
            <div class="flex items-center gap-2 mb-2">
                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="font-bold text-lg">Tilmelding modtaget!</p>
            </div>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        @endif

        {{-- Error summary --}}
        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 text-red-700">
            <p class="font-semibold mb-2">Ret venligst følgende fejl:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form
            action="{{ route('registration.store') }}"
            method="POST"
            x-data="registrationForm()"
            class="bg-white rounded-2xl shadow-md p-8 space-y-6"
        >
            @csrf

            {{-- Section: Barnets oplysninger --}}
            <div>
                <h2 class="text-lg font-bold text-[#1a472a] mb-4 pb-2 border-b border-gray-100">Barnets oplysninger</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="player_name">
                            Barnets fulde navn <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="player_name"
                            name="player_name"
                            value="{{ old('player_name') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('player_name') border-red-400 @enderror"
                            placeholder="fx. Emma Hansen"
                        >
                        @error('player_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="date_of_birth">
                            Fødselsdato <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="date_of_birth"
                            name="date_of_birth"
                            value="{{ old('date_of_birth') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('date_of_birth') border-red-400 @enderror"
                        >
                        @error('date_of_birth')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="department_id">
                            Afdeling <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="department_id"
                            name="department_id"
                            required
                            x-model="selectedDepartment"
                            @change="selectedAgeGroup = ''"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('department_id') border-red-400 @enderror"
                        >
                            <option value="">Vælg afdeling...</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', request('department') === $dept->slug ? $dept->id : '') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name_da }}
                            </option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="selectedDepartment" x-transition>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="age_group_id">
                            Årgang / Hold <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="age_group_id"
                            name="age_group_id"
                            x-model="selectedAgeGroup"
                            :required="selectedDepartment !== ''"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('age_group_id') border-red-400 @enderror"
                        >
                            <option value="">Vælg årgang...</option>
                            @foreach($ageGroups as $group)
                            <option
                                value="{{ $group->id }}"
                                data-department="{{ $group->department_id }}"
                                x-show="selectedDepartment == '{{ $group->department_id }}'"
                                {{ old('age_group_id') == $group->id ? 'selected' : '' }}
                            >
                                {{ $group->label_da }}
                            </option>
                            @endforeach
                        </select>
                        @error('age_group_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="current_club_experience">
                            Tidligere klub / erfaring
                        </label>
                        <input
                            type="text"
                            id="current_club_experience"
                            name="current_club_experience"
                            value="{{ old('current_club_experience') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent"
                            placeholder="fx. Ingen erfaring / Tidligere spillet i ..."
                        >
                    </div>
                </div>
            </div>

            {{-- Section: Forældreoplysninger --}}
            <div>
                <h2 class="text-lg font-bold text-[#1a472a] mb-4 pb-2 border-b border-gray-100">Forældreoplysninger</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="parent_name">
                            Forælders navn <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="parent_name"
                            name="parent_name"
                            value="{{ old('parent_name') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('parent_name') border-red-400 @enderror"
                            placeholder="fx. Mads Hansen"
                        >
                        @error('parent_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="parent_email">
                            E-mail <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="parent_email"
                            name="parent_email"
                            value="{{ old('parent_email') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('parent_email') border-red-400 @enderror"
                            placeholder="din@email.dk"
                        >
                        @error('parent_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="phone">
                            Telefon <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('phone') border-red-400 @enderror"
                            placeholder="fx. 12 34 56 78"
                        >
                        @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="address">
                            Adresse <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            value="{{ old('address') }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent @error('address') border-red-400 @enderror"
                            placeholder="fx. Nørrebrogade 1, 2200 København N"
                        >
                        @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" for="additional_info">
                            Besked / yderligere information
                        </label>
                        <textarea
                            id="additional_info"
                            name="additional_info"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a472a] focus:border-transparent"
                            placeholder="Har du spørgsmål eller særlige ønsker, er du velkommen til at skrive her..."
                        >{{ old('additional_info') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Consents --}}
            <div class="space-y-3">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input
                        type="checkbox"
                        name="gdpr_consent"
                        value="1"
                        required
                        {{ old('gdpr_consent') ? 'checked' : '' }}
                        class="mt-0.5 h-4 w-4 rounded border-gray-300 text-[#1a472a] focus:ring-[#1a472a]"
                    >
                    <span class="text-sm text-gray-600">
                        Jeg accepterer, at Fælled United må behandle ovenstående persondata med henblik på tilmelding.
                        <span class="text-red-500">*</span>
                    </span>
                </label>
                @error('gdpr_consent')
                <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror

                <label class="flex items-start gap-3 cursor-pointer group">
                    <input
                        type="checkbox"
                        name="photo_consent"
                        value="1"
                        {{ old('photo_consent') ? 'checked' : '' }}
                        class="mt-0.5 h-4 w-4 rounded border-gray-300 text-[#1a472a] focus:ring-[#1a472a]"
                    >
                    <span class="text-sm text-gray-600">
                        Jeg giver tilladelse til, at klubben må bruge billeder af barnet til klubbens kommunikation (hjemmeside, sociale medier).
                    </span>
                </label>
            </div>

            {{-- Friendly Captcha placeholder --}}
            {{-- TODO: Add Friendly Captcha widget here when sitekey is available
                 <div class="frc-captcha" data-sitekey="YOUR_SITEKEY_HERE"></div>
                 <script type="module" src="https://cdn.jsdelivr.net/npm/friendly-challenge@0.9.15/widget.module.min.js" async defer></script>
            --}}

            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full px-8 py-4 bg-[#1a472a] text-white font-bold rounded-lg text-lg hover:bg-[#235c38] transition-colors shadow-md"
                >
                    Send tilmelding
                </button>
            </div>
        </form>
    </div>

    <script>
    function registrationForm() {
        return {
            selectedDepartment: '{{ old('department_id', '') }}',
            selectedAgeGroup: '{{ old('age_group_id', '') }}',
        }
    }
    </script>

@endsection
