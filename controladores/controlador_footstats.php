<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

ini_set('log_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../modelos/modelo_jugadores.php';
require_once __DIR__ . '/../modelos/modelo_users.php';
require_once __DIR__ . '/../modelos/modelo_api.php';
include __DIR__."/../config/database.php";



if (!isset($_GET["page"]) && !isset($_POST["agregarUsuario"])&& !isset($_POST["loginUsuario"])){
    include __DIR__."/../vistas/landing.php";
    exit();
}

else if (isset($_POST["agregarUsuario"])) {
    $username  = trim(htmlspecialchars($_POST["username"] ?? ''));
    $pwdPlain  = trim($_POST["pwd"] ?? '');
    $name      = trim(htmlspecialchars($_POST["name"] ?? ''));
    $surname   = trim(htmlspecialchars($_POST["surname"] ?? ''));
    $age       = intval($_POST["age"] ?? 0);
    $gender    = $_POST["gender"] ?? 'otro';
    $privilege = intval($_POST["privilege"] ?? 1);

    $errores = [];

    if (empty($username)) $errores["username"] = "Introduce un nombre de usuario";
    if (empty($pwdPlain)) $errores["pwd"]      = "Introduce una contraseña";
    if (empty($name))     $errores["name"]     = "Introduce un nombre";
    if (empty($surname))  $errores["surname"]  = "Introduce un apellido";

    if (strtolower($username) == "admin") $errores["username"] = "El usuario no puede ser admin.";
    if (strtolower($pwdPlain) == "admin") $errores["pwd"] = "La contraseña no puede ser admin.";

    // Validaciones de longitud
    if (strlen($username) < 4) $errores["username"] = "Mínimo 4 caracteres para el usuario";
    if (strlen($pwdPlain) < 8) $errores["pwd"] = "Mínimo 8 caracteres para la contraseña";
    if (strlen($name) < 4) $errores["name"] = "Mínimo 4 caracteres";
    if (strlen($surname) < 4) $errores["surname"] = "Mínimo 4 caracteres";

    if (!preg_match('/[A-Z]/', $pwdPlain) || 
        !preg_match('/[a-z]/', $pwdPlain) || 
        !preg_match('/[^a-zA-Z0-9]/', $pwdPlain)) {
        $errores["pwd"] = "Falta mayúscula, minúscula o carácter especial.";
    }

    if (existeUsuario($conexion, $username)) {
        $errores['username'] = 'Ese nombre de usuario ya está en uso';
    }

    // Procesar si no hay errores
    if (empty($errores)) {
        $pwdHash = password_hash($pwdPlain, PASSWORD_DEFAULT);
        crearUsuario($conexion, $pwdHash, $username, $name, $surname, $age, $gender, $privilege);
        header("Location: index.php?page=login");
        exit();
    } else {
        // variables que usará la vista para repintar el formulario
        $old = [
            'name'     => $name,
            'surname'  => $surname,
            'username' => $username,
            'age'      => $age,
            'gender'   => $gender,
        ];
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

        crearCookieSesionLogin($respuestaLogin['id']);
        
        $allPlayers = getAllplayers($conexion);

        header('Location: index.php?page=verPlayers');
        exit();
    } else {
        include __DIR__ . "/../vistas/login.php";
        exit();
    }
}
// Inicializar un array para almacenar errores



// Manejar las diferentes páginas
switch ($_GET["page"]) {
    case 'login':
        //Si ya ha iniciado sesion
        $userId = comprobarCookieSesion();

        $allPlayers = getAllplayers($conexion);
        include __DIR__."/../vistas/jugadores.php";
        exit();


    case 'register':
        include __DIR__."/../vistas/register.php";
        exit();
    
    case 'verPlayers':
        $userId = comprobarCookieSesion();

        $allPlayers = getAllplayers($conexion);
        include __DIR__."/../vistas/jugadores.php";
        exit();

    case 'refrescar_db':
        $userId = comprobarCookieSesion();
        if ($userId !== 1) {
            $allPlayers = getAllplayers($conexion);
            include __DIR__."/../vistas/jugadores.php";
            exit();
        }
        include __DIR__."/../vistas/refrescar_db.php";
        exit();


    case 'editar_perfil':
        $userId = comprobarCookieSesion();

        include __DIR__."/../vistas/editar_perfil.php";
        exit();

    case 'logout':
        setcookie('UUID_Login', '', time() - 3600, '/');
        $logout = "Has cerrado sesion!";

        include __DIR__."/../vistas/landing.php";
        exit();

    case 'refrescar_db_accion':
        $userId = leerUserIdDeCookie();

        if ($userId !== 1) {
            header('Location: index.php?page=verPlayers');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jugadoresPorEquipo = obtenerJugadoresTodosEquipos();

            foreach ($jugadoresPorEquipo as $equipo => $info) {
                guardarJugadoresEnBD($conexion, $equipo, $info['players'], 2024);
            }

            header('Location: index.php?page=verPlayers');
            exit();
        }

        break;

    default:
        $error = "Esa pagina no existe";
        include __DIR__."/../vistas/error.php";
        break;
}

?>
