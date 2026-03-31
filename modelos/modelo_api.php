<?php

require_once __DIR__ . '/../controladores/env.php';

loadEnv(__DIR__ . '/../.env');

define('API_FOOTBALL_KEY', $_ENV['API_KEY_FOOTBALL']);
const API_FOOTBALL_BASE = 'https://v3.football.api-sports.io';

function apiFootballRequest(string $endpoint, array $params = []): ?array {
    $query = http_build_query($params);
    $url   = API_FOOTBALL_BASE . $endpoint . '?' . $query;

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_HTTPHEADER     => [
            'x-apisports-key: ' . API_FOOTBALL_KEY,
        ],
    ]);

    $response = curl_exec($curl);
    if ($response === false) {
        curl_close($curl);
        return null;
    }
    curl_close($curl);

    return json_decode($response, true);
}

function obtenerJugadoresTodosEquipos(): array {
    $teams = [
        'osasuna'       => 727,
        'barcelona'     => 529,
        'madrid'        => 541,
        'real_sociedad' => 548,
    ];

    $resultadoFinal = [];

    foreach ($teams as $nombreEquipo => $teamId) {
        $resultadoFinal[$nombreEquipo] = [
            'team_id'  => $teamId,
            'players'  => [],  // lista plana de jugadores
            'pages'    => [],  // jugadores por página si quieres
        ];

        for ($page = 1; $page <= 3; $page++) {
            $data = apiFootballRequest('/players', [
                'season' => 2024,
                'league' => 140,
                'team'   => $teamId,
                'page'   => $page,
            ]);

            if (!$data || empty($data['response'])) {
                continue;
            }

            // Guardar por página (opcional)
            $resultadoFinal[$nombreEquipo]['pages'][$page] = $data['response'];

            // Aplanar todos los jugadores en una sola lista
            foreach ($data['response'] as $item) {
              $player    = $item['player'];
              $stats0    = $item['statistics'][0] ?? [];
              $games     = $stats0['games']  ?? [];
              $teamStats = $stats0['team']   ?? [];

              $resultadoFinal[$nombreEquipo]['players'][] = [
                  'id'          => $player['id'] ?? null,
                  'name'        => $player['name'] ?? '',
                  'firstname'   => $player['firstname'] ?? '',
                  'lastname'    => $player['lastname'] ?? '',
                  'age'         => $player['age'] ?? null,
                  'nationality' => $player['nationality'] ?? '',
                  'height'      => $player['height'] ?? '',
                  'weight'      => $player['weight'] ?? '',
                  'photo'       => $player['photo'] ?? '',
                  'team_name'   => $teamStats['name'] ?? '',
                  'position'    => $games['position'] ?? '',
                  'number'      => $games['number'] ?? null,
              ];
          }
        }
    }

    return $resultadoFinal;
}

function guardarJugadoresEnBD(mysqli $conexion, string $teamKey, array $players, int $season = 2024): void
{
    $teamIds = [
        'osasuna'       => 727,
        'barcelona'     => 529,
        'madrid'        => 541,
        'real_sociedad' => 548,
    ];
    $teamId = $teamIds[$teamKey] ?? 0;

    $sql = "INSERT INTO api_players (
                api_player_id, team_id, season,
                name, firstname, lastname,
                age, nationality, position, number,
                height, weight, photo
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
            ON DUPLICATE KEY UPDATE
                name = VALUES(name),
                firstname = VALUES(firstname),
                lastname = VALUES(lastname),
                age = VALUES(age),
                nationality = VALUES(nationality),
                position = VALUES(position),
                number = VALUES(number),
                height = VALUES(height),
                weight = VALUES(weight),
                photo = VALUES(photo)";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        return;
    }

    foreach ($players as $p) {
        $apiId       = $p['id'] ?? null;
        $name        = $p['name'] ?? '';
        $firstname   = $p['firstname'] ?? '';
        $lastname    = $p['lastname'] ?? '';
        $age         = $p['age'] ?? null;
        $nationality = $p['nationality'] ?? '';
        $position    = $p['position'] ?? '';
        $number      = $p['number'] ?? null;
        $height      = $p['height'] ?? '';
        $weight      = $p['weight'] ?? '';
        $photo       = $p['photo'] ?? '';

        mysqli_stmt_bind_param(
            $stmt,
            "iiisssissssss",
            $apiId,
            $teamId,
            $season,
            $name,
            $firstname,
            $lastname,
            $age,
            $nationality,
            $position,
            $number,
            $height,
            $weight,
            $photo
        );

        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
}

function obtenerJugadoresDesdeBD(mysqli $conexion): array {
    $sql = "SELECT *
            FROM api_players
            ORDER BY team_id, name";
    $res = mysqli_query($conexion, $sql);

    $equipos = [
        727 => 'osasuna',
        529 => 'barcelona',
        541 => 'madrid',
        548 => 'real_sociedad',
    ];

    $salida = [];
    foreach ($equipos as $id => $key) {
        $salida[$key] = ['team_id' => $id, 'players' => []];
    }

    while ($row = mysqli_fetch_assoc($res)) {
        $key = $equipos[$row['team_id']] ?? 'otros';
        $salida[$key]['players'][] = $row;
    }
    return $salida;
}

?>
