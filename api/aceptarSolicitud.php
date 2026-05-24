<?php

include '../conexion.php';

header('Content-Type: application/json');

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id_solicitud = intval($data['id_solicitud']);
$id_interprete = intval($data['id_interprete']);

/*
====================================
VALIDAR SI YA FUE ACEPTADA
====================================
*/

$sqlValidar = "
SELECT estado
FROM solicitud
WHERE id_solicitud = '$id_solicitud'
";

$result = mysqli_query($conn, $sqlValidar);

if(mysqli_num_rows($result) <= 0){

    echo json_encode([
        'ok'=>false,
        'mensaje'=>'Solicitud no encontrada'
    ]);

    exit();
}

$solicitud = mysqli_fetch_assoc($result);

if($solicitud['estado'] != 'buscando'){

    echo json_encode([
        'ok'=>false,
        'mensaje'=>'La llamada ya fue aceptada'
    ]);

    exit();
}

/*
====================================
ACTUALIZAR SOLICITUD
====================================
*/

$sqlActualizar = "
UPDATE solicitud
SET estado='aceptada'
WHERE id_solicitud='$id_solicitud'
";

mysqli_query($conn, $sqlActualizar);

/*
====================================
CREAR ASIGNACION
====================================
*/

$sqlAsignacion = "
INSERT INTO asignacion(
    Estado,
    id_solicitud,
    id_interprete,
    fecha
)
VALUES(
    1,
    '$id_solicitud',
    '$id_interprete',
    NOW()
)
";

mysqli_query($conn, $sqlAsignacion);

$id_asignacion = mysqli_insert_id($conn);

/*
====================================
CREAR SESION
====================================
*/

$sqlSesion = "
INSERT INTO sesion(
    estado,
    inicio,
    id_asignacion
)
VALUES(
    'activa',
    NOW(),
    '$id_asignacion'
)
";

mysqli_query($conn, $sqlSesion);

echo json_encode([
    'ok'=>true
]);

?>