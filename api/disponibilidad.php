<?php
require_once 'cors.php';
include '../conexion.php';

session_start();
include '../conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$disponible = intval($data['disponible']);

/*
========================================
OBTENER ID_INTERPRETE
========================================
*/

$sqlInterprete = "
    SELECT id_interprete
    FROM interprete
    WHERE id_usuario = '".$_SESSION['id_usuario']."'
";

$result = mysqli_query($conn, $sqlInterprete);

if(mysqli_num_rows($result) <= 0){

    echo json_encode([
        'ok' => false,
        'mensaje' => 'Intérprete no encontrado'
    ]);

    exit();
}

$interprete = mysqli_fetch_assoc($result);

$id_interprete = $interprete['id_interprete'];

/*
========================================
ACTUALIZAR DISPONIBILIDAD
========================================
*/

$sql = "
    UPDATE disponibilidad
    SET disponible = '$disponible'
    WHERE id_interprete = '$id_interprete'
";

mysqli_query($conn, $sql);

echo json_encode([
    'ok' => true
]);

?>