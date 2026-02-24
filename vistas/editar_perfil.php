<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../modelos/modelo_users.php'; // corrige el path si es necesario

// Al inicio de editar_perfil.php, DESPUÉS de require_once
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Ya llegó POST del formulario → no hacer nada más, controlador lo maneja
}

// 1. Validar cookie y obtener id usuario logeado
$userId = comprobarCookieSesion(); // devuelve int uid

// 2. Obtener datos del usuario desde la BD
$usuario = findById($conexion, $userId);

if (!$usuario) {
    // Si por lo que sea el usuario no existe en BD
    header('Location: index.php?page=login');
    exit();
}

// 3. Preparar array $old para reutilizar la vista (si ya lo usabas para errores)
$old = [
    'name'     => $usuario['name']     ?? '',
    'surname'  => $usuario['surname']  ?? '',
    'username' => $usuario['username'] ?? '',
    'age'      => $usuario['age']      ?? '',
    'gender'   => $usuario['gender']   ?? '',
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="card shadow">
        <div class="card-body p-5">
            <h3 class="text-center mb-4">Editar perfil</h3>

            <form action="index.php" method="POST">
                <!-- id del usuario logeado -->
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control"
                               name="name"
                               placeholder="Nombre"
                               value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                        <?php if (!empty($errores['name'])): ?>
                            <div class="text-danger small"><?= $errores['name'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control"
                               name="surname"
                               placeholder="Apellido"
                               value="<?= htmlspecialchars($old['surname'] ?? '') ?>">
                        <?php if (!empty($errores['surname'])): ?>
                            <div class="text-danger small"><?= $errores['surname'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control"
                           name="username"
                           placeholder="Nombre usuario"
                           value="<?= htmlspecialchars($old['username'] ?? '') ?>">
                    <?php if (!empty($errores['username'])): ?>
                        <div class="text-danger small"><?= $errores['username'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-5">
                        <input type="number" class="form-control"
                               name="age" min="1" max="120"
                               placeholder="Edad"
                               value="<?= htmlspecialchars($old['age'] ?? '') ?>">
                        <?php if (!empty($errores['age'])): ?>
                            <div class="text-danger small"><?= $errores['age'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7">
                        <select class="form-select" name="gender">
                            <option value="" disabled <?= empty($old['gender']) ? 'selected' : '' ?>>Género</option>
                            <option value="hombre" <?= ($old['gender'] ?? '') === 'hombre' ? 'selected' : '' ?>>Masculino</option>
                            <option value="mujer"  <?= ($old['gender'] ?? '') === 'mujer'  ? 'selected' : '' ?>>Femenino</option>
                            <option value="otro"   <?= ($old['gender'] ?? '') === 'otro'   ? 'selected' : '' ?>>Otro</option>
                        </select>
                        <?php if (!empty($errores['gender'])): ?>
                            <div class="text-danger small"><?= $errores['gender'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

            <div class="mb-3">
                <input type="text" class="form-control"
                    name="username"
                    placeholder="Nombre usuario"
                    value="<?= htmlspecialchars($old['username'] ?? '') ?>">
                <?php if (!empty($errores['username'])): ?>
                    <div class="text-danger small"><?= $errores['username'] ?></div>
                <?php endif; ?>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md-5">
                    <input type="number" class="form-control"
                        name="age" min="1" max="120"
                        placeholder="Edad">
                </div>
                <div class="col-md-7">
                    <select class="form-select" name="gender">
                        <option value="" disabled <?= empty($old['gender']) ? 'selected' : '' ?>>Género</option>
                        <option value="hombre" <?= ($old['gender'] ?? '') === 'hombre' ? 'selected' : '' ?>>Masculino</option>
                        <option value="mujer"  <?= ($old['gender'] ?? '') === 'mujer' ? 'selected' : '' ?>>Femenino</option>
                        <option value="otro"   <?= ($old['gender'] ?? '') === 'otro' ? 'selected' : '' ?>>Otro</option>
                    </select>
                </div>
            </div>

            <div class="d-grid mt-4 gap-1">
                <button type="submit" class="btn btn-primary"
                        value="editarUsuario" name="editarUsuario">Guardar cambios</button>
                <a href="?page=verPlayers" class="btn btn-outline-secondary">Cancelar</a>      
            </div>
        </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
