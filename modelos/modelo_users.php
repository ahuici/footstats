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

function findById(mysqli $conexion, int $id): ?array {
    $sql = "SELECT id, username, name, surname, age, gender, privilege 
            FROM users 
            WHERE id = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($stmt);

    return $user ?: null;
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

    // Opcional: quitar el hash de la contraseña antes de devolver
    unset($user['pwd']);

    return $user; // array con id, username, name, surname, privilege...
}



/*
 * Comprueba si la cookie es divisible entre 69, si da 0 es una cookie valida.
 */
function comprobarCookieSesion(): int {
    if (empty($_COOKIE['UUID_Login'])) {
        include __DIR__."/../vistas/login.php";
        exit();
    }

    $raw = base64_decode($_COOKIE['UUID_Login'], true);
    if ($raw === false) {
        header('Location: index.php?page=login');
        exit();
    }

    $parts = explode('.', $raw, 2);
    if (count($parts) !== 2) {
        header('Location: index.php?page=login');
        exit();
    }

    [$sig, $data] = $parts;

    $calcSig = hash_hmac('sha256', $data, COOKIE_SECRET);
    if (!hash_equals($sig, $calcSig)) {
        // cookie manipulada
        header('Location: index.php?page=login');
        exit();
    }

    $payload = json_decode($data, true);
    if (!is_array($payload) || !isset($payload['uid'], $payload['v'])) {
        header('Location: index.php?page=login');
        exit();
    }

    $valorCookie = $payload['v'];

    // tu check del múltiplo de 69
    if ($valorCookie % 69 !== 0) {
        header('Location: index.php?page=login');
        exit();
    }

    // Aquí la cookie es válida: devolvemos el id de usuario
    return (int)$payload['uid'];
}

function leerUserIdDeCookie(): ?int {
    if (empty($_COOKIE['UUID_Login'])) {
        return null;
    }

    $raw = base64_decode($_COOKIE['UUID_Login'], true);
    if ($raw === false) {
        return null;
    }

    $parts = explode('.', $raw, 2);
    if (count($parts) !== 2) {
        return null;
    }

    [$sig, $data] = $parts;

    $calcSig = hash_hmac('sha256', $data, COOKIE_SECRET);
    if (!hash_equals($sig, $calcSig)) {
        return null;
    }

    $payload = json_decode($data, true);
    if (!is_array($payload) || !isset($payload['uid'], $payload['v'])) {
        return null;
    }

    if ($payload['v'] % 69 !== 0) {
        return null;
    }

    return (int)$payload['uid'];
}


/* Variable para guardar la firma para forgar cookies */
const COOKIE_SECRET = 'EsTo_3s_L4_Cl4v3_Qu3_Va_4.C1fR4R_Las_C00k1Es123123holakaixohelloegunonrootroot';

/*
 * Crea una cookie multiplo de 69, para que sea facil de verificar. Ademas guarda el id del usuario
 * dentro de la cookie para poder saber que usuario es el que esta logeado.
 */
function crearCookieSesionLogin(int $userId) {
    // Tu lógica del múltiplo de 69
    $minK = intdiv(1000000000, 69) + 1;
    $maxK = $minK + 1000000000;

    $k           = random_int($minK, $maxK);
    $valorCookie = $k * 69;

    // Payload con user_id + valor
    $data = json_encode([
        'uid' => $userId,      // id del usuario
        'v'   => $valorCookie, // múltiplo de 69
        'ts'  => time()        // timestamp opcional
    ]);

    $sig  = hash_hmac('sha256', $data, COOKIE_SECRET);
    $pack = base64_encode($sig . '.' . $data);

    setcookie(
        'UUID_Login',
        $pack,
        time() + 3600,
        '/',
        '',
        true,   // secure
        true    // httponly
    );
}

/**
 * Actualiza los datos del perfil de un usuario.
 */
function updateUser(mysqli $conexion, int $id, string $username, string $name, string $surname, int $age, string $gender): bool {
    $sql = "UPDATE users SET username = ?, name = ?, surname = ?, age = ?, gender = ? WHERE id = ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        error_log("updateUser PREPARE failed: " . mysqli_error($conexion));
        return false;
    }
    
    // ORDEN CORRECTO: sssisi (4 strings + 2 ints)
    mysqli_stmt_bind_param($stmt, "sssisi", $username, $name, $surname, $age, $gender, $id);
    
    if (!mysqli_stmt_execute($stmt)) {
        error_log("updateUser EXECUTE failed: " . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        return false;
    }
    
    $affected = mysqli_stmt_affected_rows($stmt); 
    error_log("updateUser SUCCESS: affected_rows = $affected, id=$id");
    
    mysqli_stmt_close($stmt);
    return $affected > 0;  // Solo TRUE si cambió algo
}

?>
