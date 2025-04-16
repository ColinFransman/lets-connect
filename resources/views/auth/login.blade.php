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
        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <!-- Username -->
            {{-- <div class="form-group mt-4">
                <x-input-label for="name" :value="__('Naam')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div> --}}

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('username')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            {{-- <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Onthoud Mij') }}</span>
                </label>
            </div> --}}

            <div class="flex items-center justify-end mt-4">
                {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Wachtwoord vergeten?') }}
                    </a>
                @endif --}}
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                    {{ __('Nog geen account?') }}
                </a>

                <x-primary-button class="ms-3">
                    {{ __('Log In') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
