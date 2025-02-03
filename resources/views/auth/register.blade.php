<x-guest-layout>
    <link href="{{ asset('/css/register.css') }}" rel="stylesheet">
    
    <!-- Logo -->
    <div class="logo">
        <img src="https://xerte.deltion.nl/USER-FILES/3183-cmartens-site/media/Deltion_College_CMYK_145x57.png" alt="Deltion Logo" class="deltion-logo">
    </div>

    <!-- Achtergrond -->
    <div class="full-page-background"></div>

    <!-- Registratieformulier -->
    <div class="register-container">
        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf
            <!-- Naam -->
            <div class="form-group">
                <x-input-label for="name" :value="__('Naam')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                    :value="old('name')" placeholder="Voer je volledige naam in" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="form-group mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" 
                    :value="old('email')" placeholder="Voer je studentenemail in" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="form-group">
                <x-input-label for="klas" :value="__('Klas')" />
                <x-text-input id="klas" class="block mt-1 w-full" type="text" name="klas" 
                    :value="old('klas')" placeholder="Voer je volledige klassencode in" required autofocus autocomplete="klas" />
                <x-input-error :messages="$errors->get('Klas')" class="mt-2" />
            </div>
            <!-- Registreren Button -->
            <div class="form-actions flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
