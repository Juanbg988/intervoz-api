<?php

session_start();
include '../conexion.php';

header('Content-Type: application/json');

$sql = "
SELECT
ilm.id_lengua,
ilm.id_municipio

FROM interprete i

INNER JOIN interprete_lengua_municipio ilm
ON i.id_interprete = ilm.id_interprete

WHERE i.id_usuario='".$_SESSION['id_usuario']."'
";

$result = mysqli_query($conn,$sql);

$lenguas = [];

while($row = mysqli_fetch_assoc($result)){

    $lenguas[] = [
        'id_lengua'=>
        intval($row['id_lengua']),

        'id_municipio'=>
        intval($row['id_municipio'])
    ];

}

echo json_encode([
    'ok'=>true,
    'lenguas'=>$lenguas
]);

?>