<?php
require_once __DIR__ . '/../modelos/modelo_jugadores.php';
require_once __DIR__ . '/../modelos/modelo_users.php';
include __DIR__."/../config/database.php";



if (!isset($_GET["page"]) && !isset($_POST["agregarUsuario"])&& !isset($_POST["loginUsuario"])){
    include __DIR__."/../vistas/landing.php";
    exit();
}

else if (isset($_POST["agregarUsuario"])) {
    $username  = trim($_POST["username"] ?? '');
    $pwdPlain  = trim($_POST["password"] ?? ''); // Nombre del campo en tu HTML
    $name      = trim($_POST["nombre"] ?? '');
    $surname   = trim($_POST["apellido"] ?? '');
    $age       = intval($_POST["edad"] ?? 0);
    $gender    = $_POST["genero"] ?? 'Otro';
    $privilege = 1;

    $errores = [];

    // Validaciones de "admin" (en minúsculas para atrapar variaciones)
    if (strtolower($username) == "admin") {
        $errores["username"] = "El usuario no puede ser admin.";
    }
    if (strtolower($pwdPlain) == "admin") {
        $errores["pwd"] = "La contraseña no puede ser admin.";
    }

    // Validaciones de longitud
    if (strlen($username) < 6) {
        $errores["username"] = "Mínimo 6 caracteres para el usuario.";
    }
    if (strlen($pwdPlain) < 11) {
        $errores["pwd"] = "Mínimo 11 caracteres para la contraseña.";
    }

    // Validación de complejidad (Mayúscula, Minúscula y Especial)
    if (!preg_match('/[A-Z]/', $pwdPlain) || 
        !preg_match('/[a-z]/', $pwdPlain) || 
        !preg_match('/[^a-zA-Z0-9]/', $pwdPlain)) {
        $errores["pwd"] = "Falta mayúscula, minúscula o carácter especial.";
    }

    // Procesar si no hay errores
    if (empty($errores)) {
        $pwdHash = password_hash($pwdPlain, PASSWORD_DEFAULT);
        crearUsuario($conexion, $pwdHash, $username, $name, $surname, $age, $gender, $privilege);
        include __DIR__ . "/../vistas/login.php";
        exit();
    } else {
        include __DIR__ . "/../vistas/register.php";
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

        /* COOKIES PARA VERIFICAR QUE HAS INICIADO SESION
        * Mete en una cookie un numero random que al dividir entre 69 sea entero
        */
        $minK = intdiv(1000000000, 69) + 1;
        $maxK = $minK + 1000000000;              

        $k = random_int($minK, $maxK);
        $valorCookie = $k * 69;  

        // crear la cookie (1 hora de duración, en todo el sitio)
        setcookie('UUID_Login', $valorCookie, time() + 3600, '/');
        

        $allPlayers = getAllplayers($conexion);
        include __DIR__ . "/../vistas/lista_players.php";
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
        //Si ya ha iniciado sesion
        if (!isset($_COOKIE['UUID_Login']) || $_COOKIE['UUID_Login'] % 69 !== 0) {
            include __DIR__."/../vistas/login.php";
            exit();
        }

        $allPlayers = getAllplayers($conexion);
        include __DIR__."/../vistas/lista_players.php";
        exit();


    case 'register':
        include __DIR__."/../vistas/register.php";
        exit();
    
    
    case 'verPlayers':
        comprobarCookieSesion();

        $allPlayers = getAllplayers($conexion);
        include __DIR__."/../vistas/lista_players.php";
        exit();

    case 'addPlayers':
        comprobarCookieSesion();

        include __DIR__."/../vistas/lista_usuarios.php";
        exit();

    case 'editarPerfil':
        comprobarCookieSesion();

        include __DIR__."/../vistas/lista_usuarios.php";
        exit();

    case 'logout':
        setcookie('UUID_Login', '', time() - 3600, '/');
        $logout = "Has cerrado sesion!";

        include __DIR__."/../vistas/landing.php";
        exit();

    default:
        $error = "Esa pagina no existe";
        include __DIR__."/../vistas/error.php";
        break;
}

?>
