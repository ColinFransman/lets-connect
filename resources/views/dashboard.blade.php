<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mijn Planning') }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
        <title>Planning</title>
    </head>
    <body>
        <div class="main">
            <div class="rounds">
                <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="1">Ronde 1</div>
                <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="2">Ronde 2</div>
                <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="3">Ronde 3</div>
            </div>
            <div class="workshops" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="4">
                <?php for ($i = 1; $i < 13; $i++) { 
                    echo " 
                        <div class='workshop' id='workshop" . $i . "' draggable='true' ondragstart='drag(event)'>
                            <div class='info' id='info" . $i . "' tabindex='0'>i</div>
                            <div class='popup' id='popup" . $i . "'>
                                <p>Lokaal: " . $i . "</p>
                                <p>Details over workshop " . $i . "</p>
                            </div>
                            <div class='title' id='title" . $i . "'>Workshop " . $i . "</div>
                        </div> 
                    ";
                } ?>
            </div>
        </div>
        <div class="flex">
            <button onclick="alert('placeholder')" value="opslaan" class="button save">Opslaan</button>
        </div>
    </body>
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }
        
        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }
        
        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            // console.log(ev.target.id);
            if (ev.target.id < 5) {
                if (ev.target.id < 4) {
                    ev.target.innerHTML = "";
                }
                ev.target.append(document.getElementById(data));
            }
        }
    </script>
</x-app-layout>


