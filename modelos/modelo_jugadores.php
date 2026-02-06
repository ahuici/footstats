<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Función que obtiene todos los usuarios de la base de datos.
 *
 * @return array Resultado de la consulta con todos los usuarios.
 */

 function getAllplayers($conexion) {
    $sql = "SELECT * FROM players";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
 }

?>
