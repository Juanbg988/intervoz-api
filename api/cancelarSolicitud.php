<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

include '../conexion.php';

$data =
json_decode(
    file_get_contents("php://input"),
    true
);

$id =
intval($data['id_solicitud']);

$sql = "
UPDATE solicitud
SET estado='cancelada'
WHERE id_solicitud='$id'
";

mysqli_query($conn,$sql);

echo json_encode([
    'ok'=>true
]);

?>