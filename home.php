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

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['start_game'])) {
        header('Location: game.php');
        exit();
    }

    if (isset($_POST['view_score'])) {
        header('Location: score.php');
        exit();
    }

    if (isset($_POST['logout'])) {
        $user->disconnect();
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue, <?php echo htmlspecialchars($user->pseudo); ?>!</h1>
        <form method="POST" action="">
            <button type="submit" name="start_game">Démarrer le Jeu</button>
            <button type="submit" name="view_score">Voir le Score</button>
            <button type="submit" name="logout">Déconnexion</button>
        </form>
    </div>
</body>
</html>
