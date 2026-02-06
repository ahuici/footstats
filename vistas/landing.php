<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootStats - Estadísticas de Fútbol en Tiempo Real</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a73e8;
            --primary-dark: #1557b0;
            --secondary: #34c759;
            --accent: #ff6b35;
            --dark: #1a1a1a;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-green: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        * { font-family: 'Poppins', sans-serif; }

        body {
            background: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        .hero {
            background: var(--gradient);
            color: white;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content { position: relative; z-index: 2; }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, rgba(255,255,255,0.8));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero .lead {
            font-size: 1.3rem;
            font-weight: 300;
            opacity: 0.95;
        }

        .stats-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient);
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }

        .feature-grid {
            padding: 80px 0;
            background: white;
        }

        .feature-item {
            text-align: center;
            padding: 2rem;
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .cta-section {
            padding: 80px 0;
            background: var(--gradient-green);
            color: white;
        }

        .btn-explore {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-explore:hover {
            background: white;
            color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .player-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .player-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .player-img {
            height: 200px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            position: relative;
        }

        .player-img::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .hero { padding: 80px 0 60px; }
            .stats-card { margin-bottom: 1.5rem; }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 hero-content">
                    <h1>FootStats</h1>
                    <p class="lead mb-4">Las estadísticas más completas de fútbol y futbolistas en tiempo real. 
                       Analiza, compara y descubre los mejores datos del mundo del fútbol.</p>
                    
                    <!-- NUEVOS BOTONES CTA -->
                    <div class="d-flex flex-column flex-sm-row gap-3 mb-4 justify-content-center justify-content-lg-start">
                        <a href="login.php" class="btn btn-outline-light btn-lg px-4 py-2 fw-semibold border-2 shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                        </a>
                        <a href="register.php" class="btn btn-light btn-lg px-4 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-person-plus me-2"></i>Registrarse
                        </a>
                    </div>
                    
                    <a href="#estadisticas" class="btn btn-explore btn-lg ms-lg-3">
                        <i class="bi bi-graph-up me-2"></i>Explorar Estadísticas
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Cards -->
    <section class="container py-5" id="estadisticas">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="stat-number">2.4M</div>
                    <h5>Partidos Analizados</h5>
                    <small class="text-muted">Desde 2010 hasta hoy</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="stat-number text-success">156K</div>
                    <h5>Jugadores</h5>
                    <small class="text-muted">En 200+ ligas</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="stat-number" style="color: var(--accent);">98%</div>
                    <h5>Precisión Datos</h5>
                    <small class="text-muted">Verificados por IA</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="stat-number">247</div>
                    <h5>Competiciones</h5>
                    <small class="text-muted">Mundiales cubiertas</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="feature-grid">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6 feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <h4>Estadísticas Jugadores</h4>
                    <p>Goals, asistencias, xG, mapas de calor y métricas avanzadas por temporada.</p>
                </div>
                <div class="col-lg-3 col-md-6 feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <h4>Análisis Equipos</h4>
                    <p>Posesión, pases progresivos, presión y rendimiento táctico completo.</p>
                </div>
                <div class="col-lg-3 col-md-6 feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4>Historical Data</h4>
                    <p>15+ años de datos históricos para análisis longitudinales profundos.</p>
                </div>
                <div class="col-lg-3 col-md-6 feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h4>Live Updates</h4>
                    <p>Estadísticas en tiempo real durante todos los partidos importantes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Players Preview -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Top Jugadores Hoy</h2>
                <p class="lead text-muted">Los futbolistas más destacados de la temporada</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="player-card h-100">
                        <div class="player-img d-flex align-items-end justify-content-center text-white">
                            <div class="text-center p-3">
                                <h3 class="mb-0">⚽</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            <h5 class="fw-bold mb-2">Mbappé</h5>
                            <p class="text-muted mb-2">32 Goles • 18 Asistencias</p>
                            <div class="d-flex justify-content-between">
                                <small class="text-success fw-bold">xG: 28.4</small>
                                <small class="text-primary">PSG</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Repite para otros jugadores -->
                <div class="col-lg-4 col-md-6">
                    <div class="player-card h-100">
                        <div class="player-img bg-warning bg-opacity-20 d-flex align-items-end justify-content-center text-white" style="background: linear-gradient(45deg, #ffc107, #ff6b35)!important;">
                            <div class="text-center p-3">
                                <h3 class="mb-0">👑</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            <h5 class="fw-bold mb-2">Haaland</h5>
                            <p class="text-muted mb-2">38 Goles • 12 Asistencias</p>
                            <div class="d-flex justify-content-between">
                                <small class="text-success fw-bold">xG: 35.2</small>
                                <small class="text-primary">Man City</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-section text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4">¿Listo para analizar?</h2>
            <p class="lead mb-5 opacity-90">Únete a miles de analistas que confían en FootStats</p>
            <a href="#" class="btn btn-explore btn-lg">
                <i class="bi bi-rocket-takeoff-fill me-2"></i>Comenzar Gratis
            </a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>