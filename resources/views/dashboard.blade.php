<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Planning</title>
    <style>
        /* ... je CSS blijft hetzelfde ... */
    </style>
</head>
<body>
    <div class="main">
        <div class="rounds">
            <div class="round" ondrop="drop(event)" ondragover="allowDrop(event)" id="1">Ronde 1</div>
            <div class="round" ondrop="drop(event)" ondragover="allowDrop(event)" id="2">Ronde 2</div>
            <div class="round" ondrop="drop(event)" ondragover="allowDrop(event)" id="3">Ronde 3</div>
        </div>
        <div class="workshops" id="workshops">
            <?php for ($i = 1; $i <= 12; $i++) { ?>
                <div class="workshop" id="workshop<?= $i ?>" draggable="true" ondragstart="drag(event)">
                    <div class="info" onclick="info(event)" id="info<?= $i ?>">i</div>
                    <div class="popup" id="popup<?= $i ?>" style="display: none;">
                        <button onclick="closePopup(<?= $i ?>)" class="close">x</button>
                        <p>Lokaal: <?= $i ?></p>
                        <p>Details over workshop <?= $i ?></p>
                    </div>
                    <div class="title">Workshop <?= $i ?></div>
                    <div class="places" id="workshop<?= $i ?>-places">x plaats(en) over</div>
                    <div class="remove" id="remove<?= $i ?>" onclick="removeFromRound(event)">x</div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div id="confirmation-popup" class="confpopup" style="display: none;">
        <div class="popup-content">
            <p>Wil je dit opslaan?</p>
            <button onclick="confirmSave()">Ja</button>
            <button onclick="cancelSave()">Nee</button>
        </div>
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
                planningChanged = true;
            }

            checkRoundsFilled();
        }

        function showRemoveButton(workshopId) {
            const removeButton = document.getElementById("remove" + workshopId);
            removeButton.style.display = "block"; // Maak de x-knop zichtbaar
        }

        function removeFromRound(event) {
            const workshopId = event.target.id.replace("remove", "");
            const workshop = document.getElementById("workshop" + workshopId);
            const round = document.querySelector(`#${workshop.dataset.round}`);

            if (round) {
                round.removeChild(workshop);
            }

            const removeButton = document.getElementById("remove" + workshopId);
            removeButton.style.display = "none"; // Verberg de knop wanneer het verwijderd is

            planningChanged = true;
            updateWorkshopPlaces(workshopId);
            checkRoundsFilled();
        }

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

            document.querySelectorAll(".popup").forEach(p => {
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
                document.querySelectorAll(".popup").forEach(popup => {
                    popup.style.display = "none";
                });
            }
        });

        document.querySelectorAll(".workshop").forEach(workshop => {
            updateWorkshopPlaces(workshop.id);
        });
    </script>
</body>
</html>


