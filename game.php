<?php
session_start();
require_once 'config.php';
require_once 'Card.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$dsn = 'mysql:host=localhost;dbname=memory';
$username = 'root';
$password = '';     
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

$user = new Memory($pdo);
$user->setId($_SESSION['user_id']);

// Logique du jeu ici

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jeu Memory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Jeu Memory</h2>
        <!-- Affichage du jeu ici -->
        <form method="POST" action="home.php">
            <button type="submit">Retour au Menu</button>
        </form>
    </div>
</body>
</html>
