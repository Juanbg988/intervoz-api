<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

include '../conexion.php';

if(isset($_GET['id_lengua'])){

    $id_lengua = intval($_GET['id_lengua']);

    $sql = "
        SELECT DISTINCT m.id_municipio, m.nombre
        FROM municipio m

        INNER JOIN variante_municipio vm
            ON m.id_municipio = vm.id_municipio

        INNER JOIN variante v
            ON vm.id_variante = v.id_variante

        WHERE v.id_lengua = $id_lengua

        ORDER BY m.nombre ASC
    ";

    $resultado = mysqli_query($conn, $sql);

    $municipios = [];

    while($fila = mysqli_fetch_assoc($resultado)){
        $municipios[] = $fila;
    }

    echo json_encode($municipios);
}
?>