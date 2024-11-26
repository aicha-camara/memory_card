<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memory";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Définir les images des cartes
$images = ['img1.png', 'img1.png', 'img2.png', 'img2.png', 'img3.png', 'img3.png'];

// Mélanger les images pour obtenir des positions aléatoires
shuffle($images);

// Insérer les cartes dans la base de données
$level_id = 1; // ID du niveau

foreach ($images as $position => $image) {
    $card_number = array_search($image, $images) + 1; // Numéro de carte
    $sql = "INSERT INTO cards (level_id, card_number, image, position) VALUES
            ($level_id, $card_number, '$image', " . ($position + 1) . ")";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully for position " . ($position + 1) . "<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
