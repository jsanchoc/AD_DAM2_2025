<?php
require_once("dbutils.php");
$miConexion = conectarDB();
$mensaje = "";

// ---------------------------------------------------
// ZONA DE CONFIGURACIÓN RÁPIDA (LO QUE CAMBIAS EN EL EXAMEN)
// ---------------------------------------------------
$nombre_tabla_examen = "JUEGOS"; // <--- CAMBIA EL NOMBRE DE LA TABLA AQUÍ
// ---------------------------------------------------


// 1. LÓGICA DE INSERTAR (Si pulsas el botón)
if (isset($_POST['btnInsertar'])) 
{
    // AQUÍ EDITAS LA SQL SEGÚN LOS CAMPOS QUE TE PIDAN
    // Ejemplo: INSERT INTO ALUMNOS (NOMBRE, EDAD) VALUES (:n, :e)
    $sql = "INSERT INTO $nombre_tabla_examen (NOMBRE, DESCRIPCION, CATEGORIA) VALUES (:a, :b, :c)";
    
    // AQUÍ ASOCIAS LOS CAMPOS DEL FORMULARIO
    $parametros = array(
        ':a' => $_POST['campo1'], // campo1 es el name del input
        ':b' => $_POST['campo2'],
        ':c' => $_POST['campo3']
    );

    if(insertarGenerico($miConexion, $sql, $parametros)){
        $mensaje = "¡Insertado OK!";
    }
}

// 2. LÓGICA DE LISTAR (Siempre carga abajo)
$filas = getTodos($miConexion, $nombre_tabla_examen);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <?php if($mensaje) echo "<div class='alert alert-success'>$mensaje</div>"; ?>

    <div class="card p-3 mb-4">
        <h3>Insertar Nuevo</h3>
        <form method="post">
            
            <div class="mb-3">
                <label>Nombre (Campo 1):</label>
                <input type="text" class="form-control" name="campo1">
            </div>

            <div class="mb-3">
                <label>Descripción (Campo 2):</label>
                <input type="text" class="form-control" name="campo2">
            </div>

            <div class="mb-3">
                <label>Categoría (Campo 3):</label>
                <input type="text" class="form-control" name="campo3">
            </div>

            <button type="submit" name="btnInsertar" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>COLUMNA 1</th>
                <th>COLUMNA 2</th>
                <th>COLUMNA 3</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($filas as $fila) { ?>
                <tr>
                    <td><?php echo $fila['NOMBRE'] ?? '---' ?></td>
                    <td><?php echo $fila['DESCRIPCION'] ?? '---' ?></td>
                    <td><?php echo $fila['CATEGORIA'] ?? '---' ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>