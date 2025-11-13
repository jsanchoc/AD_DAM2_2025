<?php
//var_export($_POST);
$resultado="Comienza el juego";
$countar = isset($_POST['countar']) ? $_POST['countar'] : 0;
if (count($_POST)==0) // es la primera vez
{
    $num_objetivo = rand(1,10);
}
else // no es la primera vez
{
    $num_objetivo = $_POST['objetivo'];
    if ($_POST['numero']==$num_objetivo)
    {
        $resultado = "Enhorabuena de la buena";
    }
    else if  ($_POST['numero']<$num_objetivo)
    {
        $resultado = "El objetivo es MAYOR";
        $countar += 1;
    }
    else
    {
        $resultado = "El objetivo es MENOR";
        $countar += 1;
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Adivina</title>
  </head>
  <body>
<form action="adivina.php" method="post">
    <input type="hidden" name="objetivo" value="<?php echo $num_objetivo?>">
    <div class="container">
        <div class="alert alert-success">
            <strong><?php echo $resultado?></strong>
        <div class="mb-3">
            <label class="form-label">Número</label>
            <input type="number" class="form-control" name="numero">
        </div>
        <button type="submit" class="btn btn-primary">Adivina</button>
    </div>
<div class="d-flex justify-content-start align-items-right mb-3">
    <label class="me-2">Contador Intentos:</label>
    <input class="form-control w-auto" value="<?php echo $countar ?>" readonly>
</div>
</form>

  </body>
</html>