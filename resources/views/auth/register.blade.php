<x-guest-layout>
    <link href="{{ asset('/css/form.css') }}" rel="stylesheet">

    <!-- Registratieformulier -->
    <div class="register-container" style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf

            <!-- Logo en tekst naast elkaar -->
            <div class="logo-container" style="display: flex; align-items: center; justify-content: center; margin-bottom: 5px; text-align: center;">
                <div class="logo">
                    <img src="{{ asset('/images/Letsconnect2.0.jpeg') }}" alt="Logo" class="logo-image" style="max-width: 250px; height: auto; margin-bottom: 0;">
                </div>
                <div class="logo-text" style="margin-left: 10px; font-size: 20px; font-weight: bold;">
        
                </div>
            </div>

            <div class="forms">
                <!-- Naam invoeren -->
                <div class="form-group" style="margin-bottom: 10px;">
                    <x-input-label for="name" :value="__('Naam')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Voer je volledige naam in" required autofocus autocomplete="name" style="width: 100%; max-width: 550px;" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- E-mailadres invoeren -->
                <div class="form-group" style="margin-bottom: 10px;">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Voer je studentenemail in" required autocomplete="username" style="width: 100%; max-width: 550px;" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Opleiding en Klas -->
                <label for="opleiding" style="margin-bottom: 5px;">Opleiding:</label>
                <div class="form-group-row" style="margin-bottom: 10px; display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <select id="opleiding" name="opleiding" style="width: 100%; max-width: 280px;">
                            <option value="">Kies een opleiding</option>
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
                    <div class="form-group" style="flex: 1;">
                        <select id="klas" name="klas" style="width: 100%; max-width: 280px;">
                            <option value="">Kies een klas</option>
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
                </div>

                <!-- Registreren Button -->
                <div class="form-actions flex items-center justify-end mt-2">
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
