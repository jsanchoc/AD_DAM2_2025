<?php
require_once 'dbutils.php';
$conn = conectarDB();

$filas = getDatosCombinados($conn);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Datos Combinados</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <a href="index.php">Volver al Menú</a>
    <hr>

    <h1>Listado de Turnos Asignados</h1>

    <?php if (empty($filas)) { ?>
        <h3 style="color: red;">NO SE ENCONTRARON TURNOS.</h3>
        <p>Asegúrate de haber insertado un Turno en la página anterior.</p>
        <p>La tabla TURNOS es la que une Atracciones y Empleados.</p>
    <?php } else { ?>

        <table>
            <thead>
                <tr>
                    <th>Nombre Atracción</th>
                    <th>Tipo</th>
                    <th>Altura Mín.</th>
                    <th>Nombre Empleado</th>
                    <th>DNI</th>
                    <th>Horario Turno</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filas as $fila) { ?>
                    <tr>
                        <td><?php echo $fila['ATR_NOMBRE']; ?></td>
                        <td><?php echo $fila['TIPO']; ?></td>
                        <td><?php echo $fila['ALTURA_MIN']; ?></td>
                        <td><?php echo $fila['EMP_NOMBRE']; ?></td>
                        <td><?php echo $fila['DNI']; ?></td>
                        <td><?php echo $fila['HORARIO']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php } ?>

</body>
</html>