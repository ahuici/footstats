<?php
    require_once __DIR__ . '/cabecera.php';
    require_once __DIR__ . '/../modelos/modelo_users.php';
    require_once __DIR__ . '/../modelos/modelo_jugadores.php';

?>

<div class="container my-4">

  <h2 class="text-center mb-4">Jugadores</h2>

  <div class="row row-cols-4 g-3">
  <?php
  if (mysqli_num_rows($allPlayers) <= 0) {
      echo "<p class=\"text-center\">No hay jugadores, añade alguno.</p>";
  } else {
      while ($fila = mysqli_fetch_assoc($allPlayers)) {

          $position  = $fila['position']  ?? 'delantero';
          $number    = $fila['number']    ?? 0;
          $team      = $fila['team']      ?? 'Sin equipo';
          $selection = $fila['selection'] ?? 'Sin selección';
          $goals     = $fila['goals']     ?? 0;

          $bgClass = 'bg-dark';
          if ($position == 'portero') {
              $bgClass = 'bg-success';
          } elseif ($position == 'defensa') {
              $bgClass = 'bg-primary';
          } elseif ($position == 'mediocentro') {
              $bgClass = 'bg-warning';
          } elseif ($position == 'delantero') {
              $bgClass = 'bg-danger';
          }

          echo '
          <div class="col">
            <div class="card player-card text-white '.$bgClass.' border shadow">
              <div class="card-body d-flex flex-column justify-content-between text-center">

                <div class="mb-2">
                  <h3 class="player-name mb-1"><b>'.htmlspecialchars($fila['name']).' '.htmlspecialchars($fila['surname']).'</b></h3>
                  <div class="player-number">#'.$number.'</div>
                </div>

                <hr class="player-divider">

                <div class="player-info">
                  <div><strong>Posición:</strong> '.htmlspecialchars($position).'</div>
                  <div><strong>Equipo:</strong> '.htmlspecialchars($team).'</div>
                  <div><strong>Selección:</strong> '.htmlspecialchars($selection).'</div>
                  <div><strong>Goles:</strong> '.$goals.'</div>
                </div>

              </div>
            </div>
          </div>';
      }
  }
  ?>
  </div>

</div>

</main>
</body>

<style>
.player-card {
    border-radius: 18px;
    overflow: hidden;
    min-height: 260px;
}
.player-name {
    font-size: 1.2rem;
    font-weight: bold;
}
.player-number {
    font-size: 1.6rem;
    font-weight: bold;
}
.player-divider {
    border-color: rgba(255,255,255,0.6);
}
.player-info div {
    font-size: 0.9rem;
    margin-bottom: 2px;
}
</style>
