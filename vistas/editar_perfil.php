<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar perfil</title>
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
            max-width: 600px; /* Igual al login para mantener simetría */
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="card shadow">
        <div class="card-body p-5"> <h3 class="text-center mb-4">Editar perfil</h3>
            
        <form action="index.php" method="POST">
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