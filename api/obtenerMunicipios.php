<?php
require_once 'cors.php';
include '../conexion.php';

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