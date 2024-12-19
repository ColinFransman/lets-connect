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
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    <title>Planning</title>
</head>
<body>
    <div class="main">
        <div class="rounds">
            <div class="round" id="1">Ronde 1</div>
            <div class="round" id="2">Ronde 2</div>
            <div class="round" id="3">Ronde 3</div>
        </div>
        <div class="workshops">
            <?php for ($i=1; $i < 13; $i++) { 
                echo "
                    <div class='workshop' draggable='true' id=" . $i . ">
                        <div class='info'>i</div>
                        <div class='title'>Workshop " . $i . "</div>
                    </div> 
                ";
            } ?>
        </div>
    </div>
</body>
</x-app-layout>