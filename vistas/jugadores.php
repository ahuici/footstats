<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootStats - Dashboard Visual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #1d2671;
            --accent: #c33764;
        }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        
        /* Sidebar lateral */
        .sidebar {
            background: var(--primary-dark);
            min-height: 100vh;
            color: white;
            padding: 20px;
        }
        .nav-link { color: rgba(255,255,255,0.7); border-radius: 8px; margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        
        /* Contenedor de tabla */
        .main-content { padding: 30px; }
        .stats-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s;
        }
        .stats-card:hover { transform: translateY(-5px); }
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .thead-custom { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; }
        .badge-position { width: 90px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 sidebar d-none d-md-block">
            <div class="text-center mb-4">
                <h4 class="fw-bold"><i class="bi bi-trophy-fill me-2"></i>FOOTSTATS</h4>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-grid-1x2-fill me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-person-badge me-2"></i> Jugadores</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-shield-check me-2"></i> Equipos</a></li>
                <hr>
                <li class="nav-item"><a class="nav-link text-danger" href="#"><i class="bi bi-box-arrow-left me-2"></i> Cerrar Sesión</a></li>
            </ul>
        </nav>