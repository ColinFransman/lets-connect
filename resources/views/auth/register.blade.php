<x-guest-layout>
    <link href="{{ asset('/css/form.css') }}" rel="stylesheet">
    

    
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
            <div class="form-group mt-4">
                <label for="opleiding">Opleiding:</label>
                <select id="opleiding" name="opleiding">
                    <option value="opleiding1">Sign</option>
                    <option value="opleiding2">Muscialperformer</option>
                    <option value="opleiding3">Podium-en Evenemententeckniek</option>
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
                <br><br>
            
                <label for="klas">Kies een klas:</label> 
                <select id="klas" name="klas">
                    <option value="">Kies een klas</option>
                </select>
                <x-input-error :messages="$errors->get('klas')" class="mt-2" />
            </div>
            
            <script src="{{ asset('/js/register.js') }}"></script>
              
                      
                </select>
                <x-input-error :messages="$errors->get('klas')" class="mt-2" />
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

    <script src="{{ asset('/js/registerConfirm.js') }}"></script>
</x-guest-layout>
