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

    .main, .rounds, .workshops {
        pointer-events: none; /* Prevents interaction with workshops */
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
                <div class="round highlight" ondrop="drop(event, this)" ondragover="allowDrop(event)" id="1">Ronde 1</div>
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
    </div>

    <div id="confirmation-popup" class="confpopup" style="display: none;">
        <div class="popup-content">
            <p>Wil je dit opslaan?</p>
            <button onclick="confirmSave()">Ja</button>
            <button onclick="cancelSave()">Nee</button>
        </div>

        <script>
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
            
</script>



    </body>
    </html>
</x-app-layout>
    </div>

    <script>
        const maxPlacesPerWorkshop = 3;
        const roundCapacity = 3;
        let planningChanged = false;

        function isWorkshopFull(workshopId) {
            const assignedRounds = [...document.querySelectorAll('.round')].filter(round => 
                round.contains(document.getElementById(workshopId))
            ).length;
            return assignedRounds >= maxPlacesPerWorkshop;
        }

        function updateWorkshopPlaces(workshopId) {
            const workshop = document.getElementById(workshopId);
            const placesSpan = document.getElementById(workshopId + '-places');
            const assignedRounds = [...document.querySelectorAll('.round')].filter(round => 
                round.contains(workshop)
            ).length;

            const remainingPlaces = maxPlacesPerWorkshop - assignedRounds;

            // Alleen de "x" plaatsen over tonen, zonder cijfers
            placesSpan.textContent = "x plaats(en) over";

            if (remainingPlaces <= 0) {
                workshop.setAttribute("draggable", "false");
                workshop.style.opacity = 0.5;
            } else {
                workshop.setAttribute("draggable", "true");
                workshop.style.opacity = 1;
            }
        }

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            const draggedElement = document.getElementById(ev.target.id);
            if (isWorkshopFull(draggedElement.id)) {
                ev.preventDefault();
            }
            ev.dataTransfer.setData("text", draggedElement.id);
        }

            function drop(ev) {
                ev.preventDefault();
                const data = ev.dataTransfer.getData("text");
                const draggedElement = document.getElementById(data);

            if (isWorkshopFull(draggedElement.id)) {
                alert("Deze workshop is vol en kan niet meer worden toegewezen.");
                return;
            }

            const roundId = ev.target.id;

            if (ev.target.classList.contains("round") && !ev.target.contains(draggedElement) && ev.target.children.length < roundCapacity) {
                ev.target.appendChild(draggedElement);
                planningChanged = true;
                updateWorkshopPlaces(draggedElement.id);
                showRemoveButton(draggedElement.id); // Zorg ervoor dat de knop wordt getoond
            } else if (ev.target.id === "4") {
                ev.target.appendChild(draggedElement);
            }

        document.querySelectorAll(".workshop").forEach(workshop => {
            updateWorkshopPlaces(workshop.id);
        });
    </script>
</body>
</html>


