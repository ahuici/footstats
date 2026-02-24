<?php
    require_once __DIR__ . '/cabecera.php';
    require_once __DIR__ . '/../modelos/modelo_users.php';
    require_once __DIR__ . '/../modelos/modelo_jugadores.php';
?>

<?php
    $jugadoresPorEquipo = obtenerJugadoresDesdeBD($conexion);
?>

<?php foreach ($jugadoresPorEquipo as $equipo => $info): ?>
    <h2 class="mt-4 mb-3">
        <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $equipo))) ?>
    </h2>

    <div class="row row-cols-1 row-cols-md-3 g-3">
        <?php foreach ($info['players'] as $p): ?>
            <?php
            $fullName = trim(($p['firstname'] ?? '') . ' ' . ($p['lastname'] ?? ''));
            if ($fullName === '') {
                $fullName = $p['name'] ?? '';
            }
            $number = $p['number'] ?? null;
            ?>
            <div class="col">
                <div class="card h-100">
                    <?php if (!empty($p['photo'])): ?>
                        <img src="<?= htmlspecialchars($p['photo']) ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($fullName) ?>">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title">
                            <?= htmlspecialchars($fullName) ?>
                        </h5>
                        <p class="card-text mb-1">
                            <strong>Equipo:</strong>
                            <?= htmlspecialchars($p['team_name'] ?? '') ?>
                        </p>
                        <p class="card-text mb-1">
                            <strong>Posición:</strong>
                            <?= htmlspecialchars($p['position'] ?? '') ?>
                        </p>
                        <p class="card-text mb-1">
                            <strong>Dorsal:</strong>
                            <?= $number !== null ? htmlspecialchars((string)$number) : '-' ?>
                        </p>
                        <p class="card-text mb-1">
                            <strong>Edad:</strong>
                            <?= htmlspecialchars((string)($p['age'] ?? '-')) ?>
                        </p>
                        <p class="card-text mb-1">
                            <strong>Nacionalidad:</strong>
                            <?= htmlspecialchars($p['nationality'] ?? '') ?>
                        </p>
                        <p class="card-text mb-1">
                            <strong>Altura:</strong>
                            <?= htmlspecialchars($p['height'] ?? '-') ?> cm
                        </p>
                        <p class="card-text mb-0">
                            <strong>Peso:</strong>
                            <?= htmlspecialchars($p['weight'] ?? '-') ?> kg
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
