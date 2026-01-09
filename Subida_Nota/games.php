<?php
include 'db.php';
$action = $_GET['action'] ?? 'list';

if ($action == 'delete') {
    $pdo->prepare("DELETE FROM GAMES WHERE id=?")->execute([$_GET['id']]);
    header("Location: games.php"); exit;
}
if ($action == 'insert' && $_POST) {
    $pdo->prepare("INSERT INTO GAMES (nombre, plataforma) VALUES (?,?)")->execute([$_POST['nombre'], $_POST['plataforma']]);
    header("Location: games.php"); exit;
}
if ($action == 'update' && $_POST) {
    $pdo->prepare("UPDATE GAMES SET nombre=? WHERE id=?")->execute([$_POST['nombre'], $_POST['id']]);
    header("Location: games.php"); exit;
}
?>
<!DOCTYPE html>
<html>
<body>
    <a href="index.php">Volver</a>
    <h1>Gestión GAMES</h1>

    <?php if ($action == 'list'): ?>
        <a href="games.php?action=form_insert">Insertar Game</a><br><br>
        <table border="1">
            <tr><th>ID</th><th>Nombre</th><th>Plataforma</th><th>Acciones</th></tr>
            <?php
            foreach($pdo->query("SELECT * FROM GAMES") as $r) {
                echo "<tr><td>{$r['id']}</td><td>{$r['nombre']}</td><td>{$r['plataforma']}</td>
                      <td><a href='games.php?action=form_update&id={$r['id']}'>Modificar</a> | 
                          <a href='games.php?action=delete&id={$r['id']}'>Borrar</a></td></tr>";
            }
            ?>
        </table>
    <?php elseif ($action == 'form_insert'): ?>
        <form method="POST" action="games.php?action=insert">
            Nombre: <input type="text" name="nombre"><br>
            Plataforma: <input type="text" name="plataforma"><br>
            <button>Guardar</button>
        </form>
    <?php elseif ($action == 'form_update'): ?>
        <form method="POST" action="games.php?action=update">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            Nombre: <input type="text" name="nombre"><br>
            <button>Actualizar</button>
        </form>
    <?php endif; ?>
</body>
</html>