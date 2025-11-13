<?php
//var_export(value: $_POST);
$r = 0;
switch ($_POST["op"]) {
    case "+":
        $r = $_POST["n1"] + $_POST["n2"];
        break;
    case "-":
        $r = $_POST["n1"] - $_POST["n2"];
        break;
    case "*":
        $r = $_POST["n1"] * $_POST["n2"];
        break;
    case "/":
        $r = $_POST["n1"] / $_POST["n2"];
        break;
    default:
        $r = 0;
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
</head>
<body>
    <form action="calc.php" method="post">
        n1: <input type="text" name="n1" id="n1"><br>
        n2: <input type="text" name="n2" id="n2"><br>
        <input type="submit" value="+">
        <input type="submit" value="-">
        <input type="submit" value="*">
        <input type="submit" value="/">
        R: <input type="text" value="<?php echo $r; ?>" name="r" id="r" ><br>
    </form>
</body>
</html>