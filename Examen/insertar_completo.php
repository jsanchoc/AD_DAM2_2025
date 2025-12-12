<?php
require_once 'dbutils.php';
$conn = conectarDB();
$mensaje = "";

if (isset($_POST['btnInsertar'])) {
    
    $nombreAtr = $_POST['nombre_atr'];
    $tipoAtr   = $_POST['tipo_atr'];
    $alturaAtr = $_POST['altura_atr'];
    
    $nombreEmp = $_POST['nombre_emp'];
    $dniEmp    = $_POST['dni_emp'];
    
    $horario   = $_POST['horario'];

    
    $idAtraccion = getIDAtraccionPorNombre($conn, $nombreAtr);
    
    if ($idAtraccion == false) {
        $idAtraccion = insertarAtraccion($conn, $nombreAtr, $tipoAtr, $alturaAtr);
        $mensaje .= "Atracción creada nueva. ";
    } else {
        $mensaje .= "Atracción ya existía (usamos su ID). ";
    }

    $idEmpleado = getIDEmpleadoPorDNI($conn, $dniEmp);

    if ($idEmpleado == false) {
        $idEmpleado = insertarEmpleado($conn, $nombreEmp, $dniEmp);
        $mensaje .= "Empleado creado nuevo. ";
    } else {
        $mensaje .= "Empleado ya existía (usamos su ID). ";
    }

    if ($idAtraccion == false && $idEmpleado == false) {
        insertarTurno($conn, $idAtraccion, $idEmpleado, $horario);
        $mensaje .= "Turno asignado correctamente.";
    } else {
        $mensaje .= "ERROR CRÍTICO: No se pudieron obtener los IDs.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Completo</title>
</head>
<body>
    <a href="index.php">Volver al Menú</a>
    <hr>

    <h1>Insertar Atracción + Empleado + Turno</h1>

    <h3 style="color: blue;"><?php echo $mensaje; ?></h3>

    <form method="post">

    <h3>Atracción</h3>
        Nombre: <input type="text" name="nombre_atr" required> <br><br>
        Tipo: <input type="text" name="tipo_atr" required> <br><br>
        Altura Mínima: <input type="number" name="altura_atr" required>
    <br>
    <br>
    
    <h3>Empleado</h3>
        Nombre: <input type="text" name="nombre_emp" required> <br><br>
        DNI: <input type="text" name="dni_emp" required>
    <br>
    <br>

    <h3>Turno</h3>
        Horario: <input type="text" name="horario" placeholder="Ej: Mañana" required>
    <br>
    <br>

        <input type="submit" name="btnInsertar" value="INSERTAR">

    </form>
</body>
</html>