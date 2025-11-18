<?php
session_start();
$_SESSION['intentos'] = 3;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escape Room F1</title>
    <style>
        /* Estilos del body */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;

            /* Imagen de fondo */
            background-image: url('f1logo.jpg'); /* Pon aquí tu imagen */
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

        /* Contenedor central */
        .contenido {
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semi-transparente negro */
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            max-width: 600px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        h2 {
            font-size: 3em;
            margin-bottom: 20px;
            color: #ff0000; /* Rojo F1 */
            text-shadow: 2px 2px 4px #000;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        a {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2em;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(45deg, #ff0000, #ff5500);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        a:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>
    <div class="contenido">
        <h2>Escape Room F1</h2>
        <p>Demuestra que eres un verdadero fan de la Fórmula 1 resolviendo candados basados en datos reales.</p>
        <a href="room1.php">Comenzar</a>
    </div>
</body>
</html>