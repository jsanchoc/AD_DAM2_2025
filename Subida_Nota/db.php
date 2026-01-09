<?php
// db.php
$host = 'localhost';
$db   = 'BD_GAMES';
$user = 'root'; // Cambia esto si tu usuario es diferente
$pass = '';     // Cambia esto si tienes contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>