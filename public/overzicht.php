<?php
// Fetch data directly within the PHP script
$host = 'localhost';
$dbname = 'deltion';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch workshops
    $stmt = $pdo->prepare("SELECT * FROM workshops");
    $stmt->execute();
    $workshops = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deltion College Overview</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Deltion College Overview</h1>
        <input type="text" id="search-bar" placeholder="Search workshops...">
    </header>
    <main>
        <?php foreach ($workshops as $workshop): ?>
            <div class="workshop">
                <div class="workshop-header" onclick="toggleDetails(<?= $workshop['id']; ?>)">
                    <?= htmlspecialchars($workshop['title']); ?>
                </div>
                <div id="details-<?= $workshop['id']; ?>" class="workshop-details" style="display: none;">
                    <?= htmlspecialchars($workshop['description']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </main>
    <script>
        // JavaScript for toggling collapsible details
        function toggleDetails(id) {
            const details = document.getElementById('details-' + id);
            details.style.display = details.style.display === 'block' ? 'none' : 'block';
        }

        // Search functionality
        document.getElementById('search-bar').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const workshops = document.querySelectorAll('.workshop');
            workshops.forEach(workshop => {
                const title = workshop.querySelector('.workshop-header').textContent.toLowerCase();
                workshop.style.display = title.includes(query) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
