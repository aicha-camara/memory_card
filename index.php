<?php
session_start();
require_once 'config.php';
require_once 'Card.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $user = new Memory($conn);

        if ($user->connect($login, $password)) {
            header('Location: home.php');
            exit();
        } else {
            $message = 'Erreur de connexion. Veuillez vérifier vos identifiants.';
        }
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
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form method="POST" action="">
            <label for="login">Login :</label>
            <input type="text" name="login" required><br>
            
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required><br>
            
            <button type="submit">Connexion</button>
        </form>
        <p><?php echo $message; ?></p>
        <p>Pas encore inscrit ? <a href="register.php">Inscrivez-vous ici</a></p>
    </div>
</body>
</html>
