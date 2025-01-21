<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mijn Planning') }}
        </h2>
    </x-slot>

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
        background: darkblue; 
        border-radius: 10px;
      }
      
      /* Handle on hover */
      ::-webkit-scrollbar-thumb:hover {
        background: darkblue; 
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

        <div id="confirmation-popup" class="confpopup" style="display: none;">
            <div class="popup-content">
                <p>Wil je dit opslaan?</p>
                <button onclick="confirmSave()">Ja</button>
                <button onclick="cancelSave()">Nee</button>
            </div>
        </div>

        <script>
            let planningChanged = false;
            let currentZIndex = 1000;

            // Popup tonen/verbergen
            function showSavePopup() {
                document.getElementById("confirmation-popup").style.display = "flex";
            }

            function closeSavePopup() {
                document.getElementById("confirmation-popup").style.display = "none";
            }

            function confirmSave() {
                const rounds = [...document.querySelectorAll(".round")].map(round => ({
                    roundId: round.id,
                    workshops: [...round.children].map(workshop => workshop.id)
                }));

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

            // Drag & drop functies
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

                if (ev.target.classList.contains("round")) {
                    const targetRoundId = parseInt(ev.target.id);
                    const workshopId = parseInt(draggedElement.id.replace('workshop', ''));

                    if (
                        (workshopId === 1 && targetRoundId === 1) ||
                        (workshopId === 2 && targetRoundId === 2) ||
                        (workshopId === 3 && targetRoundId === 3) ||
                        (workshopId >= 4 && workshopId <= 12)
                    ) {
                        if (!ev.target.contains(draggedElement)) {
                            ev.target.innerHTML = "";
                            ev.target.appendChild(draggedElement);
                            planningChanged = true;
                        }
                    } else {
                        alert('Deze workshop kan niet op deze ronde worden geplaatst!');
                    }
                } else if (ev.target.id === "4") {
                    ev.target.appendChild(draggedElement);
                    planningChanged = true;
                }

                checkRoundsFilled();
            }

            // Workshopinfo popup
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
                document.getElementById("popup" + workshopId).style.display = "none";
            }

            // Sluit popups bij klikken buiten de popup
            document.addEventListener("click", function (event) {
                if (!event.target.classList.contains("info") && !event.target.closest(".popup")) {
                    document.querySelectorAll(".popup").forEach(popup => popup.style.display = "none");
                }
            });
        </script>
    </body>
    </html>
</x-app-layout>
