<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Función que obtiene todos los usuarios de la base de datos.
 *
 * @return array Resultado de la consulta con todos los usuarios.
 */

 function getAll($conexion) {
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
 * @param string $nombre Nombre del criminal.
 * @param string $alias Alias del criminal.
 * @param string $descripcion Descripción del criminal.
 * @return bool Éxito o fracaso de la operación.
 */

function crearUsuario($conexion, $pwd, $username, $name, $surname, $age, $gender, $privilege) {
    $sql = "INSERT INTO users (pwd, username, name, surname, age, gender, privilege) VALUES ('$pwd', '$username', '$name', '$surname', $age, '$gender', $privilege)";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado ? true : false;
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

?>
