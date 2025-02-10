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
        <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">    <a href="https://xerte.deltion.nl/play.php?template_id=8708#programma" class="text-blue-500 underline">Ga naar Xerte</a>
        
        <title>Planning</title>
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
        <div id="error-popup" class="error-overlay" style="display:none;">
            <div class="error-box">
                <h3 id="error-title">Foutmelding</h3>
                <p id="error-message">Dit is een foutmelding.</p>
                <button onclick="closeErrorPopup()">Sluiten</button>
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
            <div id="save-button-container" style="display: none;">
                <button id="save-button" onclick="showSavePopup()">Opslaan</button>
            </div>
            
            <div id="confirmation-popup" class="confpopup" style="display: none;">
                <div class="popup-content">
                    <p>Wil je dit opslaan?</p>
                    <button onclick="confirmSave()">Ja</button>
                    <button onclick="cancelSave()">Nee</button>
                </div>

                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="flex">
            <button id="save-button" onclick="showSavePopup()">Opslaan</button>
        </div>
        <script>
           let planningChanged = false;
           let workshopsInRounds = new Set(); 
            let tutorialSteps = [
                { title: "Welcome to Mijn Planning", text: "This is a drag-and-drop interface where you can plan your workshops.", highlight: ".round.highlight" },
                { title: "Workshop Sections", text: "Drag workshops into the rounds to assign them.", highlight: ".workshops" },
                { title: "Save Button", text: "Click this button to save your planning.", highlight: ".button.save" }
            ];
            let currentStep = 0;

            let originalWorkshopOrder = [];
            document.addEventListener("DOMContentLoaded", () => {
    const workshops = document.querySelectorAll(".workshop");
    originalWorkshopOrder = Array.from(workshops).map(w => w.id);
});


          
            document.addEventListener("DOMContentLoaded", () => {
                const visited = localStorage.getItem("tutorialCompleted");
                if (!visited) {
                    startTutorial();
                }
            });

            function startTutorial() {
                currentStep= 0;
                
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

      
            function allowDrop(ev) {
                ev.preventDefault();
            }

         
            function drag(ev) {
                ev.dataTransfer.setData("text", ev.target.id);
            }
          
            function drop(ev) {
    ev.preventDefault();
    const data = ev.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);
    const targetRound = ev.target.closest(".round");

    if (!targetRound) return;

    // Controleer of de workshop naar de verkeerde ronde wordt gesleept
    if (draggedElement.id === "workshop0" && targetRound.id !== "1") {
        showErrorPopup("Theaterworkshop 1 kan alleen in Ronde 1 geplaatst worden.");
        return;
    }

    if (draggedElement.id === "workshop1" && targetRound.id !== "2") {
        showErrorPopup("Theaterworkshop 2 kan alleen in Ronde 2 geplaatst worden.");
        return;
    }

    if (draggedElement.id === "workshop2" && targetRound.id !== "3") {
        showErrorPopup("Theaterworkshop 3 kan alleen in Ronde 3 geplaatst worden.");
        return;
    }

    if (!targetRound.contains(draggedElement)) {
        targetRound.appendChild(draggedElement);
        planningChanged = true;
        addCloseButton(draggedElement);
        workshopsInRounds.add(draggedElement.id);
        checkWorkshopsInRounds();
    }
}

// Toon de foutmelding popup
function showErrorPopup(message) {
    const popup = document.getElementById("error-popup");
    const errorMessage = document.getElementById("error-message");
    const errorTitle = document.getElementById("error-title");

    errorMessage.textContent = message;
    errorTitle.textContent = "Foutmelding"; // Je kunt hier de titel aanpassen indien nodig

    popup.style.display = "flex"; // Toon de popup
}

// Sluit de foutmelding popup
function closeErrorPopup() {
    const popup = document.getElementById("error-popup");
    popup.style.display = "none"; // Verberg de popup
}




        
            function checkWorkshopsInRounds() {
                if (workshopsInRounds.size === 3) {
                    showSavePopup();
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
    closeSavePopup();
    document.getElementById("save-button-container").style.display = "block";
}


         
            function cancelSave() {
            
                closeSavePopup();
            }

            function addCloseButton(workshop) {
    if (workshop.querySelector(".close-button")) {
        return; 
    }

    const closeButton = document.createElement("button");
    closeButton.classList.add("close-button");
    closeButton.textContent = "X";

    closeButton.addEventListener("click", function () {
        const workshopList = document.getElementById("4");

       
        let index = originalWorkshopOrder.indexOf(workshop.id);
 
        if (index !== -1) {
            let referenceNode = workshopList.children[index] || null;
            workshopList.insertBefore(workshop, referenceNode);
        } else {
            workshopList.appendChild(workshop);
        }

        workshopsInRounds.delete(workshop.id); 
        closeButton.remove();
    });

    workshop.appendChild(closeButton); 
}


          
            function checkRoundsFilled() {
                const rounds = document.querySelectorAll(".round");
                const isFilled = [...rounds].every(round => round.children.length > 0);

       
                if (isFilled && planningChanged) {
                    showSavePopup();
                }
            }

       
            let currentZIndex = 1000; 
            function info(event) {
                const buttonId = event.target.id;
                const popupId = "popup" + buttonId.match(/\d+/)[0];
                const popup = document.getElementById(popupId);

      
                const allPopups = document.querySelectorAll(".popup");
                allPopups.forEach(p => {
                    if (p !== popup) {
                        p.style.display = "none";
                    }
                });

         
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