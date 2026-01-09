<?php
include 'db.php';

$total_games = $pdo->query("SELECT COUNT(*) FROM GAMES")->fetchColumn();
$total_players = $pdo->query("SELECT COUNT(*) FROM PLAYERS")->fetchColumn();
$total_partidas = $pdo->query("SELECT COUNT(*) FROM PARTIDAS")->fetchColumn();

function contarJugadores($pdo, $n, $op) {
    $sql = "SELECT COUNT(*) FROM (
                SELECT p_id, COUNT(*) as total FROM (
                    SELECT id_player1 as p_id FROM PARTIDAS
                    UNION ALL
                    SELECT id_player2 as p_id FROM PARTIDAS
                ) as u GROUP BY p_id HAVING total $op $n
            ) as f";
    return $pdo->query($sql)->fetchColumn();
}
?>

<!DOCTYPE html>
<html>
<head><title>Panel BD_GAMES</title></head>
<body>
    <h1>Panel de Control</h1>

    <p>
        <a href="players.php">Gestionar PLAYERS</a> |
        <a href="games.php">Gestionar GAMES</a> |
        <a href="partidas.php">Gestionar PARTIDAS</a>
    </p>

    <hr>

    <h3>Resumen General</h3>
        <p>Total Games: <?= $total_games ?></p>
        <p>Total Players: <?= $total_players ?></p>
        <p>Total Partidas: <?= $total_partidas ?></p>

    <h3>Estadísticas Jugadores</h3>
        <p>Jugadores con 2 partidas: <?= contarJugadores($pdo, 2, '=') ?></p>
        <p>Jugadores con 3 partidas: <?= contarJugadores($pdo, 3, '=') ?></p>
        <p>Jugadores con > 3 partidas: <?= contarJugadores($pdo, 3, '>') ?></p>
</body>
</html>