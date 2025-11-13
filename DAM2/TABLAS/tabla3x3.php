
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
<div class="container m-5">

</div>
<table class="table table-bordered border-primary">
	<?php
    	$acumulador = 0;
        $acumDiagonal = 0;
        $acumDiagonalInv = 0;
        $tam = 15;
        for ($i=0;$i<$tam;$i++)
        {
        	echo "<tr>";
            for ($j=0;$j<$tam;$j++)
            {
            	$valor = rand(1,9);
                $acumulador+=$valor;
                echo "<td>".$valor."</td>";
                if ($j==$i)
                {
                	$acumDiagonal+=$valor;
                }
                if ($i+$j==($tam-1))
                {
                	$acumDiagonalInv+=$valor;
                }
            }
            echo "</tr>";
       	}   
    ?>
</table>
<?php echo "<h1>".$acumulador."</h1>"?>
<?php echo "<h1> La diagonal ".$acumDiagonal."</h1>"?>
<?php echo "<h1> La diagonal Inv ".$acumDiagonalInv."</h1>"?>
</body>
  </body>
</html>