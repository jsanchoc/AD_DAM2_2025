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
</body>
</html>