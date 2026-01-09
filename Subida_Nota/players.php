<?php
include 'db.php';
$action = $_GET['action'] ?? 'list';

if ($action == 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM PLAYERS WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    header("Location: players.php"); exit;
}
if ($action == 'insert' && $_POST) {
    $stmt = $pdo->prepare("INSERT INTO PLAYERS (alias, nivel) VALUES (?, ?)");
    $stmt->execute([$_POST['alias'], $_POST['nivel']]);
    header("Location: players.php"); exit;
}
if ($action == 'update' && $_POST) {
    $stmt = $pdo->prepare("UPDATE PLAYERS SET alias = ? WHERE id = ?");
    $stmt->execute([$_POST['alias'], $_POST['id']]);
    header("Location: players.php"); exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Players</title></head>
<body>
    <a href="index.php">Volver al Inicio</a>
    <h1>Gestión de PLAYERS</h1>

    <?php if ($action == 'list'): ?>
        <a href="players.php?action=form_insert">Insertar Nuevo Player</a>
        <br><br>
        <table border="1">
            <tr><th>ID</th><th>Alias</th><th>Nivel</th><th>Acciones</th></tr>
            <?php
            $stmt = $pdo->query("SELECT * FROM PLAYERS");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['alias']}</td>
                        <td>{$row['nivel']}</td>
                        <td>
                            <a href='players.php?action=form_update&id={$row['id']}'>Modificar</a> |
                            <a href='players.php?action=delete&id={$row['id']}'>Borrar</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>

    <?php elseif ($action == 'form_insert'): ?>
        <h3>Insertar</h3>
        <form method="POST" action="players.php?action=insert">
            Alias: <input type="text" name="alias" required><br>
            Nivel: <input type="number" name="nivel" required><br>
            <button type="submit">Guardar</button>
        </form>

    <?php elseif ($action == 'form_update'): 
        $stmt = $pdo->prepare("SELECT * FROM PLAYERS WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $r = $stmt->fetch();
    ?>
        <h3>Modificar Alias (ID: <?= $r['id'] ?>)</h3>
        <form method="POST" action="players.php?action=update">
            <input type="hidden" name="id" value="<?= $r['id'] ?>">
            Nuevo Alias: <input type="text" name="alias" value="<?= $r['alias'] ?>"><br>
            <button type="submit">Actualizar</button>
        </form>
    <?php endif; ?>
</body>
</html>