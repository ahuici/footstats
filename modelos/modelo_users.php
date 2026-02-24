<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Función que obtiene todos los usuarios de la base de datos.
 *
 * @return array Resultado de la consulta con todos los usuarios.
 */

 function getAllUsers($conexion) {
    $sql = "SELECT * FROM users";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
 }


/**
 * Función que obtiene un criminal por su ID.
 *
 * @param int $id Identificador del criminal.
 * @return array Datos del criminal encontrado.
 */

function findByID($conexion, $id){
   $sql = "SELECT * FROM users WHERE id = '$id'";
   $resultado = mysqli_query($conexion, $sql);
   return $resultado;
}

/**
 * Función que agrega un nuevo usuario a la base de datos.
 *
 * @param mysqli $conexion Conexión a la base de datos.
 * @param string $pwd Contraseña (idealmente ya hasheada).
 * @param string $username Nombre de usuario.
 * @param string $name Nombre real.
 * @param string $surname Apellidos.
 * @param int    $age Edad.
 * @param string $gender 'hombre', 'mujer' u 'otro'.
 * @param int    $privilege Nivel de privilegio.
 * @return bool  Éxito o fracaso de la operación.
 */
function crearUsuario($conexion, $pwd, $username, $name, $surname, $age, $gender, $privilege) {
    $sql = "INSERT INTO users 
            (pwd, username, name, surname, age, gender, privilege) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        return false;
    }

    // s = string, i = int
    mysqli_stmt_bind_param(
        $stmt,
        "ssssisi",
        $pwd,       // s
        $username,  // s
        $name,      // s
        $surname,   // s
        $age,       // i
        $gender,    // s (ENUM se pasa como string)
        $privilege  // i
    );

    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}

function existeUsuario(mysqli $conexion, string $username): bool {
    $sql = "SELECT 1 FROM users WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) return false;

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $existe = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $existe;
}

/**
 * Función que edita la información de un criminal existente.
 *
 * @param int $id Identificador del criminal.
 * @param string $nombre Nuevo nombre del criminal.
 * @param string $alias Nuevo alias del criminal.
 * @param string $descripcion Nueva descripción del criminal.
 * @return bool Éxito o fracaso de la operación.
 */

function edit($conexion, $nombre, $alias, $descripcion, $id) {
   $sql = "UPDATE criminales set nombre = '$nombre', alias = '$alias', descripcion =  '$descripcion' WHERE id = '$id'";
   $resultado = mysqli_query($conexion, $sql);
   if (!$resultado) return false;
   return true;
   
}
/**
 * Función que elimina un criminal de la base de datos.
 *
 * @param int $id Identificador del criminal.
 * @return bool Éxito o fracaso de la operación.
 */
 function deleteByID($conexion, $id) {
    $sql = "DELETE FROM criminales WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    if (!$resultado) return false;
    return true;
 }

function login($conexion, $username, $passwordPlano) {
    $sql = "SELECT id, pwd, username, name, surname, privilege
            FROM users
            WHERE username = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) return false;

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($resultado);

    // Si no existe usuario o password no coincide
    if (!$user || !password_verify($passwordPlano, $user['pwd'])) {
        return false;
    }
    return true;
}


function comprobarCookieSesion() {
    if (!isset($_COOKIE['UUID_Login']) 
        || $_COOKIE['UUID_Login'] % 69 !== 0) {

        header('Location: index.php');
        exit();
    }
}
?>
