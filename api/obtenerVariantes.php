<?php

include '../conexion.php';

header('Content-Type: application/json');

$id_lengua =
intval($_GET['id_lengua']);

$id_municipio =
intval($_GET['id_municipio']);

$sql = "
SELECT v.id_variante, v.nombre
FROM variante v

INNER JOIN variante_municipio vm
ON v.id_variante = vm.id_variante

WHERE v.id_lengua = '$id_lengua'
AND vm.id_municipio = '$id_municipio'

ORDER BY v.nombre ASC
";

$result = mysqli_query($conn, $sql);

$variantes = [];

while($row = mysqli_fetch_assoc($result)){

    $variantes[] = $row;

}

echo json_encode([
    'ok' => true,
    'variantes' => $variantes
]);

?>