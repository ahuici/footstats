<?php
    require_once __DIR__ . '/cabecera.php';
    require_once __DIR__ . '/../modelos/modelo_users.php';
    require_once __DIR__ . '/../modelos/modelo_jugadores.php';
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-lg border-0" style="max-width: 500px; width: 100%;">
        <div class="card-body text-center p-5">
            <h2 class="mb-4">Refrescar base de jugadores</h2>
            <p class="text-muted mb-1">
                Esta operación actualizará la base de datos de jugadores desde la API externa.
            </p>
            <p class="mb-4" style="color: red; !important">
                CUIDADO: Solo tenemos 3 llamadas al dia!
            </p>

            <form action="index.php?page=refrescar_db_accion" method="post">
                <button type="submit" class="btn btn-primary btn-lg px-4">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    Refrescar base de jugadores
                </button>
            </form>

            <p class="mt-3 mb-0">
                <small class="text-muted">
                    Solo deberías usar esta opción cuando quieras sincronizar con los últimos datos disponibles.
                </small>
            </p>
        </div>
    </div>
</div>
