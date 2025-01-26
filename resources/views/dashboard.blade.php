<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="color: orange">
            {{ __("Let's Connect") }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Let's Connect</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
        <style>

            body {
                font-family: Arial, sans-serif;
                position: relative;
            }

            .tutorial-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                z-index: 1000; /* High priority for the overlay */
                display: none;
                justify-content: center;
                align-items: center;
                pointer-events: auto; /* Allows interaction with the tutorial */
            }

            .tutorial-box {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                text-align: center;
                width: 300px;
                max-width: 90%;
                position: relative;
                z-index: 1001; /* Above the overlay */
            }

            .tutorial-box h3 {
                margin: 0;
                font-size: 18px;
                color: #333;
            }

            .tutorial-box p {
                margin: 10px 0;
                font-size: 14px;
                color: #555;
            }

            .tutorial-buttons {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
            }

            .tutorial-buttons button {
                background-color: #0078d7;
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 5px;
                cursor: pointer;
                z-index: 1002; /* Interactive buttons */
            }

            .tutorial-buttons button:hover {
                background-color: #0056a1;
            }

            .highlight {
                position: relative;
                z-index: 999; /* Below tutorial but above normal content */
                outline: 3px solid orange;
                transition: outline 0.3s ease-in-out;
            }

            .workshops::-webkit-scrollbar {
                width: 20px;
            }
            
            /* Track */
            .workshops::-webkit-scrollbar-track {
                box-shadow: inset 0 0 5px grey; 
                border-radius: 10px;
            }
            
            /* Handle */
            .workshops::-webkit-scrollbar-thumb {
                background: #343469; 
                border-radius: 10px;
            }
            
            /* Handle on hover */
            .workshops::-webkit-scrollbar-thumb:hover {
                background: rgb(245, 130, 32); 
            }
        </style>
    </head>
    <body>
        <!-- Tutorial Overlay -->
        <div class="tutorial-overlay" id="tutorial-overlay">
            <div class="tutorial-box">
                <h3 id="tutorial-title">Welcome to Mijn Planning</h3>
                <p id="tutorial-text">This is a drag-and-drop interface where you can plan your workshops.</p>
                <div class="tutorial-buttons">
                    <button id="previous-btn" onclick="navigateTutorial(-1)" disabled>Previous</button>
                    <button id="next-btn" onclick="navigateTutorial(1)">Next</button>
                    <button id="finish-btn" onclick="endTutorial()" style="display: none;">Finish</button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main">
            <div class="rounds">
                <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="1">Ronde 1</div>
                <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="2">Ronde 2</div>
                <div class="round" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="3">Ronde 3</div>
            </div>
            <div class="workshops" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="4">
                <?php /* for ($i = 1; $i < 13; $i++) { 
                    echo " 
                        <div class='workshop' id='workshop" . $i . "' draggable='true' ondragstart='drag(event)'>
                            <div class='info' onclick='info(event)' id='info" . $i . "' tabindex='0'>i</div>
                            <div class='popup' id='popup" . $i . "'>
                                <button class='close' onclick='closePopup(" . $i . ")'>x</button>
                                <p>Lokaal: " . $i . "</p>
                                <p>Details over workshop " . $i . "</p>
                            </div>
                            <div class='title' id='title" . $i . "'>" . $i . "</div>
                        </div>
                    ";
                } */ ?>
                <script src="../resources/js/api.js"></script>
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
        </div>
        <script>
            let planningChanged = false;
            let workshopsInRounds = new Set(); // Houdt bij welke workshops naar een ronde zijn gesleept

            let tutorialSteps = [
                { title: "Welcome to Mijn Planning", text: "This is a drag-and-drop interface where you can plan your workshops.", highlight: ".round.highlight" },
                { title: "Workshop Sections", text: "Drag workshops into the rounds to assign them.", highlight: ".workshops" },
                { title: "Save Button", text: "Click this button to save your planning.", highlight: ".button.save" }
            ];
            let currentStep = 0;

            // Start tutorial on page load
            document.addEventListener("DOMContentLoaded", () => {
                const visited = localStorage.getItem("tutorialCompleted");
                if (!visited) {
                    startTutorial();
                }
            });

            function startTutorial() {
                const overlay = document.getElementById("tutorial-overlay");
                overlay.style.display = "flex";
                togglePointerEvents("disable");
                highlightElement(tutorialSteps[currentStep].highlight);
            }

            function navigateTutorial(direction) {
                unhighlightElement(tutorialSteps[currentStep].highlight);

                currentStep += direction;

                if (currentStep < tutorialSteps.length) {
                    document.getElementById("tutorial-title").textContent = tutorialSteps[currentStep].title;
                    document.getElementById("tutorial-text").textContent = tutorialSteps[currentStep].text;

                    highlightElement(tutorialSteps[currentStep].highlight);

                    document.getElementById("previous-btn").disabled = currentStep === 0;
                    document.getElementById("next-btn").style.display = currentStep < tutorialSteps.length - 1 ? "inline-block" : "none";
                    document.getElementById("finish-btn").style.display = currentStep === tutorialSteps.length - 1 ? "inline-block" : "none";
                } else {
                    endTutorial();
                }
            }

            function endTutorial() {
                document.getElementById("tutorial-overlay").style.display = "none";
                togglePointerEvents("enable");
                localStorage.setItem("tutorialCompleted", "true");
            }

            function togglePointerEvents(state) {
                const mainContent = document.querySelector(".main");
                mainContent.style.pointerEvents = state === "disable" ? "none" : "auto";
            }

            function highlightElement(selector) {
                const element = document.querySelector(selector);
                if (element) element.classList.add("highlight");
            }

            function unhighlightElement(selector) {
                const element = document.querySelector(selector);
                if (element) element.classList.remove("highlight");
            }

            //e

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
                } /*else if (ev.target.id === "4") {
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
                }*/
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

            function closeSavePopup() {
                const popup = document.getElementById("confirmation-popup");
                popup.style.display = "none"; 
            }

                
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

                
            function cancelSave() {
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

            // Controleer of alle rondes gevuld zijn
            function checkRoundsFilled() {
                const rounds = document.querySelectorAll(".round");
                const isFilled = [...rounds].every(round => round.children.length > 0);

                // Toon de opslaan popup alleen als alle rondes gevuld zijn én er wijzigingen zijn
                if (isFilled && planningChanged) {
                    showSavePopup();
                }
            }

            // Popup voor workshopinfo
            let currentZIndex = 1000; // Start z-index voor popups
            function info(event) {
                const buttonId = event.target.id;
                const popupId = "popup" + buttonId.match(/\d+/)[0];
                const popup = document.getElementById(popupId);

                // Sluit andere popups
                const allPopups = document.querySelectorAll(".popup");
                allPopups.forEach(p => {
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