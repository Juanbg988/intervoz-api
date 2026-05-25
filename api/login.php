<?php
require_once __DIR__ . "/../cors.php";
include "../conexion.php";

session_start();

$data = json_decode(file_get_contents("php://input"), true);

$correo = mysqli_real_escape_string($conn, $data['correo']);
$pass = mysqli_real_escape_string($conn, $data['pass']);

$sql = "SELECT u.id_usuario, u.nombre, p.rol
        FROM usuario u
        INNER JOIN perfil p ON p.id_usuario = u.id_usuario
        WHERE u.correo = '$correo' AND u.password = '$pass'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $user = mysqli_fetch_assoc($result);

    $_SESSION['id_usuario'] = $user['id_usuario'];
    $_SESSION['rol'] = $user['rol'];

    echo json_encode([
        "ok" => true,
        "redirect" => $user['rol'] == 'interprete'
            ? "https://intervoz-frontend.onrender.com/pages/interprete/dashboard.php"
            : "https://intervoz-frontend.onrender.com/pages/solicitante/dashboard.php"
    ]);

} else {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Credenciales incorrectas"
    ]);
}