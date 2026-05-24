<?php
$host = "sql211.infinityfree.com";
$user = "if0_42008691";
$pass = "AzQqNHENw5E";
$db   = "if0_42008691_intervoz";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
