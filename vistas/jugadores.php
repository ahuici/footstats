<?php
    require_once __DIR__ . '/cabecera.php';
    require_once __DIR__ . '/../modelos/modelo_users.php';
    require_once __DIR__ . '/../modelos/modelo_jugadores.php';

    $jugadoresPorEquipo = obtenerJugadoresDesdeBD($conexion);
?>

<div class="container py-4">

    <div class="d-flex align-items-center mb-4">
        <h1 class="h3 mb-0 me-3">Plantillas de equipos</h1>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
            <?= count($jugadoresPorEquipo) ?> equipos
        </span>
    </div>

    <?php foreach ($jugadoresPorEquipo as $equipo => $info): ?>
        <?php
            $nombreEquipo = htmlspecialchars(ucfirst(str_replace('_', ' ', $equipo)));
            $totalJugadores = isset($info['players']) ? count($info['players']) : 0;
        ?>

        <section class="mb-5">
            <div class="d-flex align-items-center mb-3">
                <h2 class="h4 mb-0"><?= $nombreEquipo ?></h2>
                <span class="badge bg-secondary-subtle text-secondary ms-3">
                    <?= $totalJugadores ?> jugadores
                </span>
            </div>
            <hr class="mt-2 mb-3">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-3">
                <?php foreach ($info['players'] as $p): ?>
                    <?php
                        $fullName = trim(($p['firstname'] ?? '') . ' ' . ($p['lastname'] ?? ''));
                        if ($fullName === '') {
                            $fullName = $p['name'] ?? '';
                        }
                        $fullName = htmlspecialchars($fullName);

                        $number = $p['number'] ?? null;
                        $teamName = htmlspecialchars($p['team_name'] ?? '');
                        $position = htmlspecialchars($p['position'] ?? '');
                        $age      = htmlspecialchars((string)($p['age'] ?? '-'));
                        $nation   = htmlspecialchars($p['nationality'] ?? '');
                        $height   = htmlspecialchars($p['height'] ?? '-');
                        $weight   = htmlspecialchars($p['weight'] ?? '-');
                        $photo    = !empty($p['photo']) ? htmlspecialchars($p['photo']) : null;
                    ?>

                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <?php if ($photo): ?>
                                <div class="ratio ratio-4x3">
                                    <img src="<?= $photo ?>"
                                         class="card-img-top object-fit-cover"
                                         alt="<?= $fullName ?>">
                                </div>
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title mb-1"><?= $fullName ?></h5>
                                <p class="text-muted small mb-2">
                                    <?= $teamName ?> · <?= $position ?>
                                </p>

                                <dl class="row mb-0 small">
                                    <dt class="col-5">Dorsal</dt>
                                    <dd class="col-7 mb-1"><?= $number !== null ? htmlspecialchars((string)$number) : '-' ?></dd>

                                    <dt class="col-5">Edad</dt>
                                    <dd class="col-7 mb-1"><?= $age ?></dd>

                                    <dt class="col-5">Nacionalidad</dt>
                                    <dd class="col-7 mb-1"><?= $nation ?></dd>

                                    <dt class="col-5">Altura</dt>
                                    <dd class="col-7 mb-1"><?= $height ?> cm</dd>

                                    <dt class="col-5">Peso</dt>
                                    <dd class="col-7"><?= $weight ?> kg</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>

</div>
