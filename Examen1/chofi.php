<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>Chofi</title>
  </head>
  <body>
    <form action="batalla1.php" method="post">
    <div class="mb-3" style="padding-top: 10px; padding-left: 10px;">
        <input type="number" class="form-control" name="numero" style="width: 300px; height: 50px;">
        <br>
        <button type="submit">PRESS</button>
        <br>
        <label for="seleccion">Select</label>
        <select name="seleccion" id="seleccion">
        <option value="menor">Jugador menor</option>
        <option value="mayor">Jugador mayor</option>
        <option value="igual">igual</option>
        </select>
    </div>

  </body>