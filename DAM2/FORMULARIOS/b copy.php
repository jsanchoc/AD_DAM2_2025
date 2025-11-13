<?php
//    var_export( $_POST);

    $num1 =$_POST['numero'] + 1;
    $char1 =$_POST['frase'] . 'Hola Mundo';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br/>
    <input type="text" value="<?php echo $num1?>"/>
    <br/>
    <input type="text" value="<?php echo $char1?>"/>
    <form action="c copy.php" method="post">
  <div class="mb-3">
    <label class="form-label">Number</label>
    <input type="number" class="form-control" name="numero">
  </div>
  <div class="mb-3">
    <label class="form-label">Character</label>
    <input type="text" class="form-control" name="frase">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>