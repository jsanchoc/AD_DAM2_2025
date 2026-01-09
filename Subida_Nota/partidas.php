<?php
include 'db.php';
$action = $_GET['action'] ?? 'list';

if ($action == 'delete') {
    $pdo->prepare("DELETE FROM PARTIDAS WHERE id=?")->execute([$_GET['id']]);
    header("Location: partidas.php"); exit;
}
if ($action == 'insert' && $_POST) {
    $pdo->prepare("INSERT INTO PARTIDAS (id_game, id_player1, id_player2, nombre, fecha) VALUES (?,?,?,?,?)")
        ->execute([$_POST['id_game'], $_POST['id_player1'], $_POST['id_player2'], $_POST['nombre'], $_POST['fecha']]);
    header("Location: partidas.php"); exit;
}
if ($action == 'update' && $_POST) {
    $pdo->prepare("UPDATE PARTIDAS SET nombre=? WHERE id=?")->execute([$_POST['nombre'], $_POST['id']]);
    header("Location: partidas.php"); exit;
}
?>
<!DOCTYPE html>
<html>
<body>
    <a href="index.php">Volver</a>
    <h1>Gestión PARTIDAS</h1>

    <?php if ($action == 'list'): ?>
        <a href="partidas.php?action=form_insert">Nueva Partida</a><br><br>
        <table border="1">
            <tr><th>ID</th><th>Game</th><th>P1</th><th>P2</th><th>Nombre</th><th>Fecha</th><th>Acciones</th></tr>
            <?php
            foreach($pdo->query("SELECT * FROM PARTIDAS") as $r) {
                echo "<tr><td>{$r['id']}</td><td>{$r['id_game']}</td><td>{$r['id_player1']}</td>
                      <td>{$r['id_player2']}</td><td>{$r['nombre']}</td><td>{$r['fecha']}</td>
                      <td><a href='partidas.php?action=form_update&id={$r['id']}'>Modificar</a> | 
                          <a href='partidas.php?action=delete&id={$r['id']}'>Borrar</a></td></tr>";
            }
            ?>
        </table>
    <?php elseif ($action == 'form_insert'): ?>
        <form method="POST" action="partidas.php?action=insert">
            ID Game: <input type="number" name="id_game"><br>
            ID P1: <input type="number" name="id_player1"><br>
            ID P2: <input type="number" name="id_player2"><br>
            Nombre: <input type="text" name="nombre"><br>
            Fecha: <input type="date" name="fecha"><br>
            <button>Guardar</button>
        </form>
    <?php elseif ($action == 'form_update'): ?>
        <form method="POST" action="partidas.php?action=update">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            Nombre: <input type="text" name="nombre"><br>
            <button>Actualizar</button>
        </form>
    <?php endif; ?>
</body>
</html>