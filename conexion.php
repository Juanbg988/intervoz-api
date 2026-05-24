<?php
$host = "sql211.infinityfree.com";
$user = "if0_42008691"; // Usuario por defecto en XAMPP
$pass = "AzQqNHENw5E";     // Contraseña por defecto vacía
$db   = "if0_42008691_intervoz";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>