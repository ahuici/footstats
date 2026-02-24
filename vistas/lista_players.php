<?php
    require_once __DIR__ . '/cabecera.php';
    require_once __DIR__ . '/../modelos/modelo_users.php';
    require_once __DIR__ . '/../modelos/modelo_jugadores.php';
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark">Panel de Estadísticas</h2>
        <p class="text-muted">Rendimiento y detalles de la plantilla actual</p>
    </div>

    

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
    <?php
            echo "<h1>ID DEL USERE: $userId </h1>";

    if (mysqli_num_rows($allPlayers) <= 0) {
        echo "<div class='col-12'><p class='text-center text-muted'>No hay jugadores registrados. Añade alguno para comenzar.</p></div>";
    } else {
        while ($fila = mysqli_fetch_assoc($allPlayers)) {
            $position  = $fila['position']  ?? 'delantero';
            $number    = $fila['number']    ?? 0;
            $team      = $fila['team']      ?? 'Sin equipo';
            $selection = $fila['selection'] ?? 'Sin selección';
            $goals     = $fila['goals']     ?? 0;

            // Badge de color según posición (sutil, no toda la tarjeta)
            $badgeColor = 'bg-secondary';
            if ($position == 'portero') $badgeColor = 'bg-success';
            elseif ($position == 'defensa') $badgeColor = 'bg-primary';
            elseif ($position == 'mediocentro') $badgeColor = 'bg-warning text-dark';
            elseif ($position == 'delantero') $badgeColor = 'bg-danger';

            echo '
            <div class="col">
                <div class="card h-100 border-0 shadow-sm player-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge '.$badgeColor.'">'.ucfirst(htmlspecialchars($position)).'</span>
                            <span class="h4 fw-bold text-light-emphasis">#'.$number.'</span>
                        </div>
                        
                        <div class="text-center mb-4">
                            <h5 class="fw-bold mb-0 text-dark">'.htmlspecialchars($fila['name']).'</h5>
                            <h5 class="fw-bold text-dark">'.htmlspecialchars($fila['surname']).'</h5>
                        </div>

                        <div class="player-stats-grid">
                            <div class="stat-item">
                                <span class="stat-label">Equipo</span>
                                <span class="stat-value">'.htmlspecialchars($team).'</span>
                            </div>
                            <div class="stat-item border-start border-end">
                                <span class="stat-label">Goles</span>
                                <span class="stat-value fw-bold text-primary">'.$goals.'</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">País</span>
                                <span class="stat-value">'.htmlspecialchars($selection).'</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    ?>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa; /* Fondo gris muy claro igual que el login */
    }

    .player-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 15px; /* Bordes redondeados similares al login */
        background: #ffffff;
    }

    .player-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .player-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 5px;
        text-align: center;
        background: #fcfcfc;
        padding: 10px 5px;
        border-radius: 10px;
        border: 1px solid #eee;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #888;
        margin-bottom: 2px;
    }

    .stat-value {
        font-size: 0.85rem;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
        border-radius: 8px;
    }
</style>