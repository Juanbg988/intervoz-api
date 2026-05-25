<?php

$host = getenv("MYSQL_HOST");
$user = getenv("MYSQL_USER");
$pass = getenv("MYSQL_PASSWORD");
$db   = getenv("MYSQL_DATABASE");
$port = getenv("MYSQL_PORT") ?: 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die(json_encode([
        "ok" => false,
        "mensaje" => mysqli_connect_error()
    ]));
}
?>