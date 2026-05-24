<?php

$host = getenv("MYSQL_HOST");
$user = getenv("MYSQL_USER");
$pass = getenv("MYSQL_PASSWORD");
$db   = getenv("MYSQL_DATABASE");

$conn = mysqli_connect(
    $host,
    $user,
    $pass,
    $db
);

if (!$conn) {

    die(
        json_encode([
            "ok" => false,
            "mensaje" => mysqli_connect_error()
        ])
    );
}
?>