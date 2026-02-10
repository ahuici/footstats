<?php
// Configurar la conexión a la base de datos
$conexion = mysqli_connect("db", "footuser", "footpass");
if (!$conexion){
    $error = "Imposible establecer conexión con el servidor de BD";
    include "error.php";
    exit();
}


// Manejar posibles errores de conexión

$bd = "footstats";
$resul = mysqli_select_db($conexion, $bd);
if (!$resul){
    $error = "Imposible localizar la base de datos $bd";
    include __DIR__."/../error.php";
    exit();
}
?>
