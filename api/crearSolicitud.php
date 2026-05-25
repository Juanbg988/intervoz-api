<?php
require_once 'cors.php';
include '../conexion.php';

session_start();
include '../conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

/*
========================================
VALIDAR VARIANTE
========================================
*/

if(!isset($data['id_variante'])){

    echo json_encode([
        'ok' => false,
        'mensaje' => 'Variante no recibida'
    ]);

    exit();
}

$id_variante = intval($data['id_variante']);

/*
========================================
OBTENER LENGUA DE LA VARIANTE
========================================
*/

$sqlVariante = "
    SELECT id_lengua
    FROM variante
    WHERE id_variante = '$id_variante'
";

$resultVariante = mysqli_query($conn, $sqlVariante);

if(mysqli_num_rows($resultVariante) <= 0){

    echo json_encode([
        'ok' => false,
        'mensaje' => 'La variante no existe'
    ]);

    exit();
}

$variante = mysqli_fetch_assoc($resultVariante);

$id_lengua = $variante['id_lengua'];

/*
========================================
CREAR SOLICITUD
========================================
*/

$sqlSolicitud = "
    INSERT INTO solicitud(
        id_usuario,
        estado,
        id_variante
    )
    VALUES(
        '".$_SESSION['id_usuario']."',
        'buscando',
        '$id_variante'
    )
";

if(!mysqli_query($conn, $sqlSolicitud)){

    echo json_encode([
        'ok' => false,
        'mensaje' => mysqli_error($conn)
    ]);

    exit();
}

$id_solicitud = mysqli_insert_id($conn);

/*
========================================
BUSCAR INTERPRETES DISPONIBLES
========================================
*/

$sqlInterpretes = "
SELECT DISTINCT i.id_interprete

FROM interprete i

INNER JOIN interprete_lengua_municipio ilm
ON i.id_interprete = ilm.id_interprete

INNER JOIN disponibilidad d
ON i.id_interprete = d.id_interprete

INNER JOIN variante_municipio vm
ON vm.id_variante = '$id_variante'

WHERE ilm.id_lengua = '$id_lengua'
AND ilm.id_municipio = vm.id_municipio
AND d.disponible = 1
";

$resultInterpretes = mysqli_query($conn, $sqlInterpretes);

$interpretes = [];

while($row = mysqli_fetch_assoc($resultInterpretes)){

    $interpretes[] = $row;

}

/*
========================================
RESPUESTA
========================================
*/

echo json_encode([
    'ok' => true,
    'id_solicitud' => $id_solicitud,
    'id_lengua' => $id_lengua,
    'interpretes' => $interpretes
]);

?>