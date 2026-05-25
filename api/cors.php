<?php

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

$allowed = [
    "https://intervoz-frontend.onrender.com"
];

if (in_array($origin, $allowed)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: https://intervoz-frontend.onrender.com");
}

header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// PRE-FLIGHT
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}