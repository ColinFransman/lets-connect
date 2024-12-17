<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mijn Planning') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planning</title>
    <style>
        .main {
            width: 100%;
            display: flex;
            margin-top: 50px;
            justify-content: space-around;
        }

        .rounds {
            display: flex;
            flex-direction: column;
        }

        .round {
            width: 300px;
            height: 150px;
            margin: 20px;
            border: 1px solid black;
            border-radius: 10px;
            background-color: lightgrey;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .workshops {
            width: 40%;
            max-height: 580px;
            display: grid;
            grid-template-columns: auto auto;
            overflow: auto;
        }

        .workshops .workshop {
            width: 90%;
            height: 150px;
            margin: 10px;
            border: 1px solid black;
            border-radius: 10px;
            background-color: lightgrey;
            display: flex;
            align-items: end;
            flex-direction: column;
        }

        .info {
            width: 10%;
            margin: 10px;
            padding-left: 12px;
            padding-right: 12px;
            border: 2px solid black;
            border-radius: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }

        .title {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .round .workshop{
            width: 100%;
            height: 100%;
            margin: 0;
            display: flex;
            align-items: end;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="rounds">
            <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="1">Ronde 1</div>
            <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="2">Ronde 2</div>
            <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="3">Ronde 3</div>
        </div>
        <div class="workshops" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="4">
            <?php for ($i=1; $i < 13; $i++) { 
                 echo " 
                    <div class='workshop' id='workshop" . $i . "' draggable='true' ondragstart='drag(event)'>
                        <div class='info' id='info" . $i . "'>i</div>
                        <div class='title' id='title" . $i . "'>Workshop " . $i . "</div>
                    </div> 
                ";
            } ?>
        </div>
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
        console.log(ev.target.id);
        if (ev.target.id < 5) {
            if (ev.target.id < 4) {
                ev.target.innerHTML = "";
            }
            ev.target.append(document.getElementById(data));
        }
    }
</script>
</x-app-layout>