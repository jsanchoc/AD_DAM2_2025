<?php
//    var_export( $_POST);

    $num1 =$_POST['numero1']+1; 
    $num2 =$_POST['numero2']+1; 
    $num3 =$_POST['numero3']-1;
    $num4 =$num1 + $num2 + $num3;
  //  echo " El número 1 es ".$num1;
  //  echo " El número 2 es ".$num2;
    $estilo= "";
    if($num4>15){
        $estilo="greenyellow";
    }

    $imagen= "";
    $random=rand(1,3);
    if($random==1){
        $imagen="HomerBirra.jpg";
    }elseif($random==2){
        $imagen="HomerDonut.webp";
    }elseif($random== 3){
        $imagen="https://i.pinimg.com/originals/3a/2a/7f/3a2a7f058bcb5293d7fd6205bfa406cc.png";
    }

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
    <input type="text" value="<?php echo $num2?>"/>
    <br/>
    <input type="text" value="<?php echo $num3?>"/>
    <br/>
    <input type="text" style="background-color: $estilo;" value="<?php echo $num4?>"/>
    <br/>
    <image src="<?php echo $imagen;?>" style="width:333px" height="333px"/>
</body>
</html>