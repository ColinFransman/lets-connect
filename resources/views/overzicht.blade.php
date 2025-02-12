<?php
// Haal gegevens direct op binnen het PHP-script
$host = 'localhost';
$dbname = 'lets-connect';
$username = 'root';
$password = '';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Overzicht</title>
    <style>
        /* Deltion College Kleurenthema */
        :root {
            --primary-orange: rgb(245, 130,32); /* Deltion oranje */
            --secondary-orange: rgb(245, 130,32);
            --primary-blue: #343469; 
            --secondary-blue: #343469;
            --light-gray: #f4f4f4;
            --white: #ffffff;
            --text-gray: #333333;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-gray);
        }

        header {
            background-color: var(--primary-orange);
            color: var(--white);
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid var(--secondary-orange);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        #search-bar {
            width: 90%;
            max-width: 500px;
            padding: 10px;
            margin: 20px auto;
            border: 1px solid var(--secondary-orange);
            border-radius: 5px;
            font-size: 16px;
        }

        main {
            padding: 20px;
        }

        .workshop {
            border: 1px solid var(--secondary-blue);
            margin: 20px auto;
            max-width: 600px;
            border-radius: 5px;
            background-color: var(--white);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .workshop-header {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 15px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s;
        }

        .workshop-header:hover {
            background-color: var(--secondary-blue);
        }

        .workshop-details {
            padding: 15px;
            display: none;
            background-color: var(--light-gray);
            color: var(--text-gray);
            border-top: 1px solid var(--white);
        }

        .toggle-icon {
            transform: rotate(0deg);
            transition: transform 0.2s;
        }

        .toggle-icon.open {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
    <header>
        <h1>Deltion College Workshops</h1>
        <input type="text" id="search-bar" placeholder="Zoek workshops...">
    </header>
    <main>
        <div class="workshop">
            <div class="workshop-header" onclick="toggleDetails(1)">
                <span>Workshop 1: Introductie tot Coderen</span>
                <span class="toggle-icon" id="icon-1">&#9660;</span>
            </div>
            <div id="details-1" class="workshop-details">
                <p>Leer de basisprincipes van programmeren, zoals variabelen, loops en functies. Deze workshop is ideaal voor beginners!</p>
            </div>
        </div>

        <div class="workshop">
            <div class="workshop-header" onclick="toggleDetails(2)">
                <span>Workshop 2: Basis van Webontwikkeling</span>
                <span class="toggle-icon" id="icon-2">&#9660;</span>
            </div>
            <div id="details-2" class="workshop-details">
                <p>Ontdek de basisprincipes van het bouwen van websites met HTML, CSS en JavaScript. Maak je eerste webpagina in deze sessie.</p>
            </div>
        </div>

        <div class="workshop">
            <div class="workshop-header" onclick="toggleDetails(3)">
                <span>Workshop 3: Geavanceerde JavaScript</span>
                <span class="toggle-icon" id="icon-3">&#9660;</span>
            </div>
            <div id="details-3" class="workshop-details">
                <p>Verhoog je JavaScript-vaardigheden met onderwerpen zoals closures, promises en asynchroon programmeren.</p>
            </div>
        </div>
    </main>
    <script>
        function toggleDetails(id) {
            const details = document.getElementById('details-' + id);
            const icon = document.getElementById('icon-' + id);
            if (details.style.display === 'block') {
                details.style.display = 'none';
                icon.classList.remove('open');
            } else {
                details.style.display = 'block';
                icon.classList.add('open');
            }
        }

        document.getElementById('search-bar').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const workshops = document.querySelectorAll('.workshop');
            workshops.forEach(workshop => {
                const title = workshop.querySelector('.workshop-header span').textContent.toLowerCase();
                workshop.style.display = title.includes(query) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>






        