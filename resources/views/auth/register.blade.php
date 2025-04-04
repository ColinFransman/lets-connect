<x-guest-layout>
    <link href="{{ asset('/css/form.css') }}" rel="stylesheet">

    <!-- Registratieformulier -->
    <div class="register-container">
        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf

            <!-- Logo en tekst naast elkaar -->
            <div class="logo-container" style="display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                <!-- Logo -->
                <div class="logo" style="margin-right: 10px;">
                    <img src="{{ asset('/images/24213_SAVETHEDATE_LETS_CONNECT_01.jpg') }}" alt="Logo" class="logo-image" style="width: 150px; height: auto;">
                </div>
                
                <!-- "Let's Connect" tekst naast de afbeelding -->
                <div class="logo-text" style="font-size: 24px; display: flex; align-items: center; justify-content: center;">
                    <span style="color: rgb(245, 130, 32); font-weight: bold; margin-right: 5px;">Let's</span>
                    <span style="color: #343469; font-weight: bold;">Connect</span>
                </div>
            </div>

            <div class="forms">
                <!-- Naam invoeren -->
                <div class="form-group" style="margin-bottom: 5px;">
                    <x-input-label for="name" :value="__('Naam')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Voer je volledige naam in" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- E-mailadres invoeren -->
                <div class="form-group" style="margin-bottom: 5px;">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Voer je studentenemail in" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Opleiding en Klas -->
                <label for="opleiding" style="margin-bottom: 5px;">Opleiding:</label>
                <div class="form-group-row" style="margin-bottom: 5px;">
                    <div class="form-groupe">
                        <select id="opleiding" name="opleiding" style="margin-bottom: 5px;">
                            <option value="opleiding1">Sign</option>
                            <option value="opleiding2">Musicalperformer</option>
                            <option value="opleiding3">Podium-en Evenemententechniek</option>
                            <option value="opleiding4">Acteur</option>
                            <option value="opleiding5">Mode</option>
                            <option value="opleiding6">Mediavormgeving</option>
                            <option value="opleiding7">Av-Specialist</option>
                            <option value="opleiding8">Fotograaf</option>
                            <option value="opleiding9">Expert IT systems and devices</option>
                            <option value="opleiding10">Allround medewerkers IT systems and devices</option>
                            <option value="opleiding11">Software Developer</option>
                            <option value="opleiding12">Interieuradviseur</option>
                            <option value="opleiding13">Creative Development</option>
                        </select>
                    </div>

                    <select id="klas" name="klas" style="margin-bottom: 5px;">
                        <option value="">Kies een klas</option>
                    </select>
                </div>

                <!-- Registreren Button -->
                <div class="form-actions flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Al geregistreerd?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Registreren') }}
                    </x-primary-button>
                </div>
            </div>
        </form>

        <div id="dataPopup" style="display: none">
            <div class="dataWrapperPopup">
                <div class="innerDataTitel">
                    Weet je zeker dat deze gegevens kloppen?
                </div>
                <div class="innerDataWrapper">
                    <div id="userData"></div>
                </div>
                <div class="buttonWrapper">
                    <x-secondary-button class="popupButtonNo">
                        Nee
                    </x-secondary-button>
                    <x-primary-button class="popupButtonYes">
                        Ja
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('/js/register.js') }}"></script>
    <script src="{{ asset('/js/registerConfirm.js') }}"></script>
</x-guest-layout>
