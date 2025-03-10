<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="https://xerte.deltion.nl/play.php?template_id=8708#programma">Lets-Connect</a> 
        </h2>
    </x-slot>

    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
        <script src="../resources/js/api.js"></script>
        <script src="../resources/js/dragAndDrop.js"></script>
        <script src="../resources/js/errorPopup.js"></script>
        <script src="../resources/js/infoPopup.js"></script>
        <script src="../resources/js/confirmPopup.js"></script>
        <script src="../resources/js/tutorial.js"></script>     
    </head>
    <body>
         <!-- Tutorial -->
         <div class="tutorial-overlay" id="tutorial-overlay" style="display: none;">
            <div class="tutorial-step" id="tutorial-step">
                <p id="tutorial-text">Welkom op het dashboard! Laten we leren hoe je deze pagina gebruikt.</p>
                <div class="tutorial-buttons">
                    <button onclick="prevStep()">Terug</button>
                    <button onclick="nextStep()">Volgende</button>
                </div>
            </div>
        </div>
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
                <?php /* for ($i = 1; $i < 13; $i++) { 
                    echo " 
                        <div class='workshop' id='workshop" . $i . "' draggable='true' ondragstart='drag(event)'>
                            <div class='info' onclick='info(event)' onclick='info(event)' id='info" . $i . "' tabindex='0'>i</div>
                            <div class='popup' id='popup" . $i . "'>
                                <button class='close' onclick='closePopup(" . $i . ")'>x</button>
                                <p>Lokaal: " . $i . "</p>
                                <p>Details over workshop " . $i . "</p>
                            </div>
                            <div class='title' id='title" . $i . "'>" . $i . "</div>
                        </div>
                    ";
                } */ ?>
            </div>
        </div>
        <div class="flex">
            <div id="save-button-container" style="display: none;">
            </div>
            
            <div id="confirmation-popup" class="confpopup" style="display: none;">
                <div class="popup-content">
                    <p>Wil je dit opslaan?</p>
                    <form method="POST" action="{{ url('/save') }}" onsubmit="updateHiddenInputs()">
                        @csrf
                        <input type="hidden" name="save1" id="save1" value="">
                        <input type="hidden" name="save2" id="save2" value="">
                        <input type="hidden" name="save3" id="save3" value="">
                        <input type="submit" value="Ja">
                    </form>
                    <button onclick="cancelSave()">Nee</button>
                </div>
            </div>
        </div>
 
        <div class="flex">
            <button id="save-button" style="display: none;" onclick="showSavePopup()">Opslaan</button>

        </div> 
    </body>
    </html>
</x-app-layout>