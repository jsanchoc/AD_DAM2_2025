<?php

require_once("dbutils.php");

$miConexion = conectarDB();

//var_export($miConexion);

$vectorFilas = getTodosJuegos($miConexion);
$vectorFilasCategoria = getJuegosPorCategoria($miConexion, "RPG");
var_export($vectorFilasCategoria);

/*
foreach($vectorFilas as $miFila)
{
    echo " el nombre es:".$miFila['NOMBRE']." y lo otro:".$miFila['DESCRIPCION'].$miFila['CATEGORIA']."<br/>";
}*/



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
   <table class="table">
  <thead>
    <tr>
      <th scope="col">NOMBRE</th>
      <th scope="col">DESC+CATE</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($vectorFilas as $miFila) {?>
    <tr>
      <td><?php echo $miFila['NOMBRE']?></td>
      <td><?php echo $miFila['DESCRIPCION'].$miFila['CATEGORIA']?></td>
    </tr>
<?php }?>

  </tbody>
</table> 
</body>
</html>