<?php
    $number =$_POST['numero'];
    $selection =$_POST['seleccion'];
    $chofisNumber = rand(1,3);

    if($number == $chofisNumber && $selection == "igual")
    {
        $resultado = "Perfecto, Continuas";
        $continueButton = true;
        $goBackButton = false;
    }
    elseif($number > $chofisNumber && $selection == "mayor")
    {
        $resultado = "Perfecto, Continuas";
        $continueButton = true;
        $goBackButton = false;
    }
    elseif($number < $chofisNumber && $selection == "menor")
    {
        $resultado = "Perfecto, Continuas";
        $continueButton = true;
        $goBackButton = false;
    }
    else
    {
        $resultado = "MUERTO";
        $continueButton = false;
        $goBackButton = true;
    }

    
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Batalla1</title>
  </head>
  <body>
    <h1>CHOFI SACA: <?php echo $chofisNumber?></h1>
    <br>
    <h3><?php echo $resultado?></h3>
    <br>
    <div>
        <form action="chofo.php" method="post">
        <?php 
            if ($continueButton) {
                echo '<button type="submit">Continue</button>';
            } else {
                echo '<button type="submit" disabled>Continue</button>';
            }
        ?>
        </form>
        <form action="chofi.php" method="post">
        <?php 
            if ($goBackButton) {
                echo '<button type="submit">Go Back</button>';
            } else {
                echo '<button type="submit" disabled>Go Back</button>';
            }
        ?>
        </form>
    </div>
    
  </body>





