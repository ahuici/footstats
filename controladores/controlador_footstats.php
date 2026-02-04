<?php
require_once __DIR__ . '/../modelos/modelo_jugadores.php';
require_once __DIR__ . '/../modelos/modelo_users.php';
include __DIR__."/../config/database.php";



if (!isset($_GET["page"]) && !isset($_POST["agregarUsuario"])&& !isset($_POST["loginUsuario"])){
    include __DIR__."/../vistas/login.php";
    exit();
}

else if (isset($_POST["agregarUsuario"])) {
    $username = trim(htmlspecialchars($_POST["username"]));
    $pwd      = trim($_POST["pwd"]); // luego la puedes hashear
    $name     = trim(htmlspecialchars($_POST["name"]));
    $surname  = trim(htmlspecialchars($_POST["surname"]));
    $age      = intval($_POST["age"]);
    $gender   = $_POST["gender"] ?? 'otro';
    $privilege = intval($_POST["privilege"] ?? 1);

    $errores = [];

    if (empty($username)) $errores["username"] = "Introduce un nombre de usuario";
    if (empty($pwd))      $errores["pwd"]      = "Introduce una contraseña";
    if (empty($name))     $errores["name"]     = "Introduce un nombre";
    if (empty($surname))  $errores["surname"]  = "Introduce un apellido";

    if (empty($errores)) {
        // opcional: $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
        crearUsuario($conexion, $pwd, $username, $name, $surname, $age, $gender, $privilege);
        $allUsers = getAllUsers($conexion);
        include __DIR__ . "/../vistas/lista_usuarios.php";
        exit();
    } else {
        include __DIR__ . "/../vistas/agregar_usuario.php";
        exit();
    }
}

/* LOGICA DEL LOGIN */
else if (isset($_POST["loginUsuario"])) {
    $username  = trim(htmlspecialchars($_POST["username"]));
    $pwd       = trim($_POST["pwd"]); // luego la puedes hashear

    $errores = array();

    if (empty($username)) $errores["username"] = "Introduce un nombre de usuario";
    if (empty($pwd))      $errores["pwd"]      = "Introduce una contraseña";

    if (empty($errores)) {
        $respuestaLogin = login($conexion, $username, $pwd);
        if (!$respuestaLogin){
             $errores["pwd"] = "Contraseña incorrecta!";
            include __DIR__ . "/../vistas/login.php";
            exit();
        }
        $allUsers = getAllUsers($conexion);
        include __DIR__ . "/../vistas/lista_usuarios.php";
        exit();
    } else {
        include __DIR__ . "/../vistas/login.php";
        exit();
    }
}
// Inicializar un array para almacenar errores


// Manejar las solicitudes para agregar o editar criminales


// Manejar las diferentes páginas
switch ($_GET["page"]) {
    case 'login':
        $allCriminales = getAllUsers($conexion);
        include __DIR__."/../vistas/login.php";
        exit();
    
    case 'users':
        include __DIR__."/../vistas/lista_usuarios.php";
        exit();
    default:
        $error = "Esa pagina no existe";
        include __DIR__."/../vistas/error.php";
        break;
}

?>
