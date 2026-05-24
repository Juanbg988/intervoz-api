<?php

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