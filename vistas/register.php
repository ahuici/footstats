<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-container {
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="card shadow">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Crear Cuenta</h3>
            
            <form action="registrar_usuario.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="apellido" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Edad</label>
                        <input type="number" class="form-control" name="edad" min="1" max="120" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Género</label>
                        <select class="form-select" name="genero" required>
                            <option value="" selected disabled>Elegir...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-success">Registrarse</button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <small class="text-muted">¿Ya tienes cuenta? <a href="/login.php">Inicia sesión</a></small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>