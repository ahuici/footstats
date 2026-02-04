<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card shadow">
        <div class="card-body p-5">
            <h3 class="text-center mb-4">Iniciar Sesión</h3>
            
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Nombre usuario" required value="<?php if(isset($username)) echo $username ?>">
                    <span class="error"><?php if (isset($errores["username"])) echo $errores["username"]?></span><br/>
                </div>

                <div class="mb-3">
                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="********" required value="<?php if(isset($pwd)) echo $pwd ?>">
                    <span class="error"><?php if (isset($errores["pwd"])) echo $errores["pwd"]?></span><br/>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" name="loginUsuario" value="loginUsuario" class="btn btn-primary">Entrar al Sistema</button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <small class="text-muted">¿No tienes cuenta? <a href="/register.php">Regístrate aquí</a></small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>