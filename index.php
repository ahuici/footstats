<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Punto de entrada al sistema (emplear __DIR__ si la ruta da problemas)
include __DIR__."/controladores/controlador_footstats.php";

?>
