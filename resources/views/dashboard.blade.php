<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="https://xerte.deltion.nl/play.php?template_id=8708#programma" target="_blank" style="display: flex"><p class="deltion-blue">Let's</p><pre> </pre><p class="deltion-orange">Connect</p></a> 
        </h2>
    </x-slot>

    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <title>Let's Connect</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
        {{-- <script src="{{ asset('/js/api.js') }}"></script> --}}
        <script src="{{ asset('/js/confirmPopup.js') }}"></script> 
        <script src="{{ asset('/js/dragAndDrop.js') }}"></script>   
        <script src="{{ asset('/js/errorPopup.js') }}"></script>
        <script src="{{ asset('/js/infoPopup.js') }}"></script>
        <script src="{{ asset('/js/register.js') }}"></script>
    </head>
    <body>
        <!-- Tutorial -->
        <div class="tutorial-overlay" id="tutorial-overlay" style="display: none;">
            <div class="tutorial-step" id="tutorial-step">
                <p id="tutorial-text"></p>
                <div class="tutorial-buttons">
                    <button id="prevButton" onclick="prevStep()" >Terug</button>
                    <button id="nextButton" onclick="nextStep()">Volgende</button>
                </div>
            </div>
        </div>

        <!-- Foutmelding bij workshop ongeldige ronde -->
        <div id="error-popup" class="error-overlay" style="display:none;">
            <div class="error-box">
                <h3 id="error-title">Foutmelding</h3>
                <p id="error-message">Dit is een foutmelding.</p>
                <button onclick="closeErrorPopup()">Sluiten</button>
            </div>
        </div>

        @if (session('status') == 'success')
        <x-success-msg message="{{ session('message') }}" color="green" />
        @elseif (session('status') == 'failed')
        <x-success-msg message="{{ session('message') }}" color="red" />
        @endif
        
        <!-- Main Content -->
        <div class="main">
            <div class="rounds">
                <div class="flex" id="round1">
                    <div class="flex col round placeholder">
                        <p>Ronde 1</p>
                        <p>13:00 - 13:45</p>
                    </div>
                    <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="1"></div>
                </div>
                <div class="flex" id="round2">
                    <div class="flex col round placeholder">
                        <p>Ronde 2</p>
                        <p>13:45 - 14:30</p>
                    </div>
                    <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="2"></div>
                </div>
                <div class="flex" id="round3">
                    <div class="flex col round placeholder">
                        <p>Ronde 3</p>
                        <p>15:00 - 15:45</p>
                    </div>
                    <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="3"></div>
                </div>
            </div>
            <div class="workshops" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="4">
                @foreach ($workshops as $workshop)
                    <div class='workshop' id='workshop{{ $workshop->id - 1 }}' capacity="{{ $workshop->capacity}}" draggable='true' ondragstart='drag(event)'> 
                        <div class='info' onclick='info(event)' id='info{{ $workshop->id - 1 }}' tabindex='0'>i</div> 
                        <div class='popup' id='popup{{ $workshop->id - 1 }}' draggable='false'>
                            <button class='close' onclick='closePopup({{ $workshop->id - 1 }})'>x</button> 
                            <a href='https://xerte.deltion.nl/play.php?template_id=8708#programma' class='popup-header' target='_blank'>Klik <span class='highlight'>hier</span> voor meer informatie</a>  
                            <div class='description'>
                                <div class='descriptionText'>{{ $workshop->full_description }} </div>
                                <div class='descriptionImage'><img src='{{ $workshop->image_url }}'></div> 
                            </div>
                         </div>
                        <div class='title' id='title{{ $workshop->id - 1 }}'>{{$workshop->name }}  </div> 
                        <div class="capacityText" id="capacityText{{ $workshop->id -1}}"></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex">
            <div id="save-button-container" style="display: none;">
            </div>
            
            <div id="confirmation-popup" class="confpopup" style="display: none;">
                <div class="popup-content">
                    <p>Wil je dit opslaan?</p>
                    <form method="POST" action="{{ url('/save') }}">
                        @csrf
                        <input type="hidden" name="save1" id="save1" value="">
                        <input type="hidden" name="save2" id="save2" value="">
                        <input type="hidden" name="save3" id="save3" value="">
                        <button onclick="SaveSave()">Ja</button>
                    </form>
                    <button onclick="cancelSave()">Nee</button>
                </div>
            </div>
        </div>
 
        <div class="flex">
            <button id="save-button" style="display: none;" onclick="showSavePopup()">Opslaan</button>

        </div> 
        <!-- loading script after html has loaded because of getElementById -->
        <script src="{{ asset('/js/tutorial.js') }}"></script>
        <script src="{{ asset('/js/capacityWorkshops.js') }}"></script>
    </body>
    </html>
</x-app-layout>