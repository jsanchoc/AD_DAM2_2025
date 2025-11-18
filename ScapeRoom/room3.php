<?php
session_start();
$mensaje = "";
if(isset($_POST['codigo'])){
    if($_POST['codigo']=="824"){ 
        header("Location: room4.php"); 
        exit; 
    } else {
        $mensaje = "Incorrecto. Inténtalo de nuevo.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitación 3 - Escape Room F1</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;

            /* Imagen de fondo */
            background-image: url('f1logo.jpg'); /* Cambia por tu imagen */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            /* Centrado del contenido */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            color: #fff;
        }

        .contenido {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            max-width: 700px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #ff0000; /* Rojo F1 */
            text-shadow: 2px 2px 4px #000;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        img {
            margin: 20px 0;
            border-radius: 10px;
            max-width: 100%;
        }

        input {
            padding: 10px;
            font-size: 1.1em;
            border-radius: 5px;
            border: none;
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: 1.1em;
            background: linear-gradient(45deg, #ff0000, #ff5500);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        }

        .mensaje {
            margin-top: 15px;
            font-weight: bold;
            color: #ff5555;
        }
    </style>
</head>
<body>
    <div class="contenido">
        <h2>Habitación 3</h2>
        <img src="Pitstop.jpg" alt="Vettel">
        <p>
            <strong>Pista 1 → Dígito 1:</strong> Velocidad máxima permitida en el pit lane en km/h dividido entre 10.<br>
            <strong>Pista 2 → Dígitos 2 y 3:</strong> Número de GP's por temporada actualmente.<br>
        </p>
        <form method="POST">
            <input name="codigo" placeholder="Introduce el código"/>
            <button>Enviar</button>
        </form>
        <?php if($mensaje != ""): ?>
            <div class="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>