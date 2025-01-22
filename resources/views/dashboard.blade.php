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
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Planning</title>
    </head>
    <body>
        <style>
        ::-webkit-scrollbar {
            width: 20px;
          }
          
          /* Track */
          ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey; 
            border-radius: 10px;
          }
           
          /* Handle */
          ::-webkit-scrollbar-thumb {
            background: blue; 
            border-radius: 10px;
          }
          
          /* Handle on hover */
          ::-webkit-scrollbar-thumb:hover {
            background: blue; 
          }
          </style>
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
                            <div class='info' onclick='info(event)' id='info" . $i . "' tabindex='0'>i</div>
                            <div class='popup' id='popup" . $i . "'>
                                <button class='close' onclick='closePopup(" . $i . ")'>x</button>
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

        <div id="confirmation-popup" class="confpopup" style="display: none;">
            <div class="popup-content">
                <p>Wil je dit opslaan?</p>
                <button onclick="confirmSave()">Ja</button>
                <button onclick="cancelSave()">Nee</button>
            </div>
        </div>

        <script>
            let planningChanged = false;
let workshopsInRounds = new Set(); // Houdt bij welke workshops naar een ronde zijn gesleept

// Zorg ervoor dat slepen mogelijk is
function allowDrop(ev) {
    ev.preventDefault();
}

// Sleep functie (om het workshop ID te verkrijgen)
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

// Drop functie
function drop(ev) {
    ev.preventDefault();
    const data = ev.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);

    // Zorg ervoor dat het een geldige drop is
    if (ev.target.classList.contains("round") && !ev.target.contains(draggedElement)) {
        ev.target.innerHTML = ""; // Leeg de ronde
        ev.target.appendChild(draggedElement); // Voeg de workshop toe
        planningChanged = true; // Markeer als gewijzigd

        // Voeg een rood kruisje toe
        addCloseButton(draggedElement);

        // Voeg workshop toe aan de Set van gesleepte workshops in rondes
        workshopsInRounds.add(draggedElement.id);
        checkWorkshopsInRounds(); // Controleer of er 3 workshops zijn gesleept
    } else if (ev.target.id === "4") {
        // Workshop terugplaatsen in de lijst
        ev.target.appendChild(draggedElement);
        planningChanged = true; // Markeer als gewijzigd

        // Verwijder workshop uit de Set van gesleepte workshops
        workshopsInRounds.delete(draggedElement.id);

        // Verwijder het kruisje
        const closeButton = draggedElement.querySelector(".close-button");
        if (closeButton) {
            closeButton.remove();
        }
    }
}

// Controleer of er 3 workshops in verschillende rondes zijn gesleept
function checkWorkshopsInRounds() {
    if (workshopsInRounds.size === 3) {
        showSavePopup(); // Toon opslaan popup als er 3 workshops gesleept zijn
    }
}

// Toon opslaan popup
function showSavePopup() {
    const popup = document.getElementById("confirmation-popup");
    popup.style.display = "flex";
}

// Sluit de opslaan popup
function closeSavePopup() {
    const popup = document.getElementById("confirmation-popup");
    popup.style.display = "none";
}

// Bevestigen opslaan
function confirmSave() {
    const rounds = [...document.querySelectorAll(".round")].map(round => ({
        roundId: round.id,
        workshops: [...round.children].map(workshop => workshop.id)
    }));
    console.log("Op te slaan data:", rounds);

    fetch("/save-planning", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify(rounds)
    })
        .then(response => response.json())
        .then(data => console.log("Planning opgeslagen:", data))
        .catch(error => console.error("Opslaan mislukt:", error));
    
    planningChanged = false;
    closeSavePopup();
}

// Annuleren opslaan
function cancelSave() {
    // Sluit de popup, maar doe verder niets
    closeSavePopup();
}

// Voeg een rood kruisje toe aan een workshop
function addCloseButton(workshop) {
    if (workshop.querySelector(".close-button")) {
        return; // Voorkom dubbele kruisjes
    }

    const closeButton = document.createElement("button");
    closeButton.classList.add("close-button");
    closeButton.textContent = "X";

    closeButton.addEventListener("click", function () {
        const workshopList = document.getElementById("4");
        workshopList.appendChild(workshop); // Verplaats terug naar workshoplijst
        workshopsInRounds.delete(workshop.id); // Verwijder uit geplaatste workshops
        closeButton.remove(); // Verwijder kruisje
    });

    workshop.appendChild(closeButton); // Voeg het kruisje toe
}

// Popup voor workshopinfo
let currentZIndex = 1000; // Start z-index voor popups
function info(event) {
    const buttonId = event.target.id;
    const popupId = "popup" + buttonId.match(/\d+/)[0];
    const popup = document.getElementById(popupId);
    
    // Sluit andere popups
    const allPopups = document.querySelectorAll(".popup");
    allPopups.forEach((p) => {
        if (p !== popup) {
            p.style.display = "none";
        }
    });
    // Toggle huidige popup
    if (popup.style.display === "flex") {
        popup.style.display = "none";
    } else {
        currentZIndex++;
        popup.style.zIndex = currentZIndex;
        popup.style.display = "flex";
    }
}

function closePopup(workshopId) {
    const popup = document.getElementById("popup" + workshopId);
    popup.style.display = "none";
}

// Sluit alle popups bij klikken buiten een popup
document.addEventListener("click", function (event) {
    const isInfoButton = event.target.classList.contains("info");
    const isPopup = event.target.closest(".popup");
    if (!isInfoButton && !isPopup) {
        const allPopups = document.querySelectorAll(".popup");
        allPopups.forEach((popup) => {
            popup.style.display = "none";
        });
    }
});

        </script>        
    </body>
    </html>
</x-app-layout>

