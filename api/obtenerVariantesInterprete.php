<?php
require_once 'cors.php';
include '../conexion.php';

session_start();
include '../conexion.php';

header('Content-Type: application/json');

$sql = "
SELECT
    ilm.id_lengua,
    l.nombre AS lengua,

    ilm.id_municipio,
    m.nombre AS municipio

FROM interprete i

INNER JOIN interprete_lengua_municipio ilm
ON i.id_interprete = ilm.id_interprete

INNER JOIN lengua l
ON ilm.id_lengua = l.id_lengua

INNER JOIN municipio m
ON ilm.id_municipio = m.id_municipio

WHERE i.id_usuario='".$_SESSION['id_usuario']."'
";

$result = mysqli_query($conn,$sql);

$lenguas = [];

while($row = mysqli_fetch_assoc($result)){

    $lenguas[] = [
        'id_lengua'=>
        intval($row['id_lengua']),

        'lengua'=>
        $row['lengua'],

        'id_municipio'=>
        intval($row['id_municipio']),

        'municipio'=>
        $row['municipio']
    ];
}

echo json_encode([
    'ok'=>true,
    'lenguas'=>$lenguas
]);

?>