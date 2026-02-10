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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            width: 100%;
            max-width: 400px; /* Igual al login para mantener simetría */
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="card shadow">
        <div class="card-body p-5"> <h3 class="text-center mb-4">Crear Cuenta</h3>
            
            <form action="index.php" method="POST">
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="surname" placeholder="Apellido" required>
                    </div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Nombre usuario" required>
                </div>

                <div class="mb-3">
                    <input type="password" class="form-control" name="pwd" placeholder="Contraseña" required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="age" min="1" max="120" placeholder="Edad" required>
                    </div>
                    <div class="col-md-7">
                        <select class="form-select" name="gender" required>
                            <option value="" selected disabled>Género</option>
                            <option value="hombre">Masculino</option>
                            <option value="mujer">Femenino</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary" value="agregarUsuario" name="agregarUsuario">Registrarse</button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <small class="text-muted">¿Ya tienes cuenta? <a href="index.php?page=login">Inicia sesión</a></small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>