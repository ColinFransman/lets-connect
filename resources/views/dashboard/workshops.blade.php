<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Overzicht</title>

    <!-- Zorg ervoor dat de CSS-bestanden correct worden ingeladen -->
    <link rel="stylesheet" href="{{ asset('/css/wdashboard.css') }}">

</head>
<body>

    <div class="container">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Workshop Overzicht</h1>

        <button id="toggleAllBtn" class="accordion-toggle-all-btn" onclick="toggleAllAccordions()">Alles uitklappen</button>
        @php
            $workshopsByName = $workshopmoments->groupBy('workshop.name');
        @endphp

        <div>
            @foreach ($workshopsByName as $workshopName => $workshopMoments)
                <div class="border border-gray-300 rounded-lg mb-2">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        <span>{{ $workshopName }}</span>
                        <span>+</span>
                    </button>

                    <div class="accordion-content">
                        <div class="workshop-table">
                            <table>
                                <thead>
                                 
                                <tbody>
                                    @foreach ($workshopMoments as $wm)
                                        <tr>
                                            <td data-label="Tijd">{{ $wm->moment->time }}</td>
                                            <td data-label="Locatie">{{ $wm->workshop->room_name }}</td>
                                            <td data-label="Capaciteit">{{ $wm->workshop->capacity }}</td>
                                            <td data-label="Boekingen">{{ count($wm->bookings) }}</td>
                                            <td data-label="Status">
                                                @if (count($wm->bookings) < $wm->workshop->capacity)
                                                <span class="text-green-600 font-semibold">✅ Nog plek</span>
                                                @else
                                                    <span class="text-red-600 font-semibold">❌ Vol</span>
                                                @endif
                                            </td>
                                            <td data-label="Actie">
                                                <a href="{{ route('workshop-moment.showbookings', ['wsm' => $wm]) }}" class="text-blue-600 font-semibold hover:underline">
                                                    🔗 Bekijk
                                                </a>
                                            </td>
                                            <td data-label="">
                                                @if (count($wm->bookings) == 0)
                                                    <span class="error-icon">
                                                        ❗
                                                        <span class="error-tooltip">{{ $workshopName }} heeft geen boekingen.</span>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Javascript voor de accordion toggle -->
    <script>
        function toggleAccordion(button) {
            let content = button.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
                button.classList.remove('open');  // Verwijder de "open" class van de knop
                button.querySelector("span:last-child").textContent = "+";  // Zet het teken terug naar "+"
            } else {
                content.style.display = "block";
                button.classList.add('open');  // Voeg de "open" class toe aan de knop
                button.querySelector("span:last-child").textContent = "−";  // Zet het teken naar "-"
            }
        }

        // Deze code zorgt ervoor dat alle accordion-content standaard zichtbaar zijn
        document.addEventListener("DOMContentLoaded", function () {
            let accordionContents = document.querySelectorAll(".accordion-content");
            accordionContents.forEach(function (content) {
                content.style.display = "block";  // Zorg ervoor dat alle accordion-secties open zijn
            });

            // Ook de "+" naar "−" veranderen voor de visuele indicatie
            let accordionButtons = document.querySelectorAll(".accordion-btn");
            accordionButtons.forEach(function (button) {
                button.querySelector("span:last-child").textContent = "−";  // Zet de teken om naar "-"
            });
        });

        // Nieuwe functie om alles open of dicht te klappen
        function toggleAllAccordions() {
            let accordionContents = document.querySelectorAll(".accordion-content");
            let accordionButtons = document.querySelectorAll(".accordion-btn");
            let toggleButton = document.getElementById("toggleAllBtn");
            let isAnyOpen = Array.from(accordionContents).some(content => content.style.display === "block");

            if (isAnyOpen) {
                // Als een van de accordion-secties open is, sluit dan alles
                accordionContents.forEach(function (content) {
                    content.style.display = "none";
                });
                accordionButtons.forEach(function (button) {
                    button.querySelector("span:last-child").textContent = "+";  // Zet de teken om naar "+"
                });
                toggleButton.textContent = "Alles uitklappen"; // Zet de knoptekst naar 'Alles uitklappen'
            } else {
                // Als geen enkele accordion-sectie open is, open dan alles
                accordionContents.forEach(function (content) {
                    content.style.display = "block";
                });
                accordionButtons.forEach(function (button) {
                    button.querySelector("span:last-child").textContent = "−";  // Zet de teken om naar "−"
                });
                toggleButton.textContent = "Alles inklappen"; // Zet de knoptekst naar 'Alles inklappen'
            }
        }
    </script>

</body>
</html>
