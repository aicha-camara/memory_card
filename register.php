<?php
session_start();
require_once 'config.php';
require_once 'Card.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pseudo']) && isset($_POST['password'])) {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];

        $user = new Memory($conn);
        if ($user->register($pseudo, $password)) {
            $message = 'Inscription réussie ! Vous pouvez maintenant vous connecter.';
        } else {
            $message = 'Erreur lors de l\'inscription. Veuillez réessayer.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <form method="POST" action="">
            <label for="pseudo">Pseudo :</label>
            <input type="text" name="pseudo" required><br>
            
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required><br>
            
            <button type="submit">S'inscrire</button>
        </form>
        <p><?php echo $message; ?></p>
        <p>Déjà inscrit ? <a href="index.php">Connectez-vous ici</a></p>
    </div>
</body>
</html>
