<?php
require_once 'Card.php';

session_start();
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
$user->disconnect();
header('Location: index.php');
exit();
?>
