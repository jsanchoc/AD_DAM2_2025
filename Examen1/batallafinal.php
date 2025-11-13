<?php
    $number = $_POST['numero'];
    $selection1 = $_POST['seleccion1'];
    $selection2 = $_POST['seleccion2'];
    $chofisNumber = rand(1, 10);

    
    $diferencia = abs($number - $chofisNumber);

    if (($number == $chofisNumber) && ($selection1 == "igual" || $selection2 == "igual")) 
    {
        $resultado = "¡EDB!";
    } 
    elseif ($diferencia == 1 && ($selection1 == "dif1" || $selection2 == "dif1")) 
    {
        $resultado = "¡EDB!";
    } 
    elseif ($diferencia == 2 && ($selection1 == "dif2" || $selection2 == "dif2")) 
    {
        $resultado = "¡EDB!";
    } 
    else 
    {
        $resultado = "OHHH!!";
    }

    
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Batalla Final</title>
  </head>
  <body>
    <h1>CHOFO SACA: <?php echo $chofisNumber?></h1>
    <br>
    <h3><?php echo $resultado?></h3>
    
  </body>





