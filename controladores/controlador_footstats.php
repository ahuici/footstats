<?php
require_once __DIR__ . '/../modelos/modelo_jugadores.php';
require_once __DIR__ . '/../modelos/modelo_users.php';
include __DIR__."/../config/database.php";



if (!isset($_GET["page"]) && !isset($_POST["agregar"])&& !isset($_POST["editar"])){
    $allCriminales = getAll($conexion);
    // include __DIR__."/../vistas/lista_criminales.php";
    exit();
}

else if (isset($_POST["agregar"])){
    $nombre = trim(htmlspecialchars($_POST["nombre"]));
    $alias = trim(htmlspecialchars($_POST["alias"]));
    $descripcion = trim(htmlspecialchars($_POST["descripcion"]));
    $errores = array();

    if(empty($nombre)) $errores["nombre"] = "Introduce un nombre";

    if (empty($errores)){
        añadirCriminal($conexion, $nombre, $alias, $descripcion);
        $allCriminales = getAll($conexion);
        include __DIR__."/../vistas/lista_criminales.php";
        exit();
    }
    else{
        include __DIR__."/../vistas/agregar_criminal.php";
        exit();
    }
}
else if (isset($_POST["editar"])){
    $nombre = trim(htmlspecialchars($_POST["nombre"]));
    $alias = trim(htmlspecialchars($_POST["alias"]));
    $descripcion = trim(htmlspecialchars($_POST["descripcion"]));
    $errores = array();

    if(empty($nombre)) $errores["nombre"] = "Introduce un nombre";

    if (empty($errores)){
        edit($conexion, $nombre, $alias, $descripcion, $_POST["idCriminal"]);
        $allCriminales = getAll($conexion);
        include __DIR__."/../vistas/lista_criminales.php";
        exit();
    }
    else{
        $criminarlRaw = findByID($conexion, $_POST["idCriminal"]);
        include __DIR__."/../vistas/editar_criminal.php";
        exit();
    }
}
// Inicializar un array para almacenar errores


// Manejar las solicitudes para agregar o editar criminales


// Manejar las diferentes páginas
switch ($_GET["page"]) {
    case 'ver':
        $allCriminales = getAll($conexion);
        include __DIR__."/../vistas/lista_criminales.php";
        exit();
    
    case 'agregar':
        include __DIR__."/../vistas/agregar_criminal.php";
        exit();

    case 'editar':
        $criminarlRaw = findByID($conexion, $_GET["idEditar"]);
        include __DIR__."/../vistas/editar_criminal.php";
        exit();

    case 'eliminar': 
        deleteByID($conexion, $_GET["idEliminar"]);
        $allCriminales = getAll($conexion);
        include __DIR__."/../vistas/lista_criminales.php";
        exit();

    case 'detalles': 
        $criminarlRaw = findByID($conexion , $_GET["idDetalles"]);
        include __DIR__."/../vistas/ver_criminal.php";
        exit();
    
    default:
        $error = "Esa pagina no existe";
        include __DIR__."/../vistas/error.php";
        break;
}

?>
