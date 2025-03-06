<x-guest-layout>
    <link href="{{ asset('/css/form.css') }}" rel="stylesheet">

        <!-- Logo -->
    <div class="logo">
        <img src="https://xerte.deltion.nl/USER-FILES/3183-cmartens-site/media/Deltion_College_CMYK_145x57.png" alt="Deltion Logo" class="deltion-logo">
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="full-page-background"></div>

    <div class="login-container">
        <form method="GET" action="{{ route('login') }}" class="login-form">
            @csrf
            <!-- Email Address -->
            <div class="form-group mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Klassen -->
            <div class="form-group mt-4">
                <x-input-label for="klas" :value="__('Klas')" />
                <select id="klas" name="klas" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    <option value="" disabled selected>Kies je klas</option>
                    <option value="ICT1A" {{ old('klas') == 'ICT1A' ? 'selected' : '' }}>ICT1A</option>
                    <option value="ICT1B" {{ old('klas') == 'ICT1B' ? 'selected' : '' }}>ICT1B</option>
                    <option value="ICT2A" {{ old('klas') == 'ICT2A' ? 'selected' : '' }}>ICT2A</option>
                    <option value="ICT2B" {{ old('klas') == 'ICT2B' ? 'selected' : '' }}>ICT2B</option>
                    <option value="ICT3A" {{ old('klas') == 'ICT3A' ? 'selected' : '' }}>ICT3A</option>
                    <option value="ICT3B" {{ old('klas') == 'ICT3B' ? 'selected' : '' }}>ICT3B</option>
                </select>
                <x-input-error :messages="$errors->get('klas')" class="mt-2" />
            </div>

            <!-- Wachtwoord -->
            <!-- <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div> -->

            <!-- Onthouden -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Onthouden') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Wachtwoord vergeten?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Inloggen') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
