<?php
  session_start();
  if(isset($_SESSION['user']) and isset($_SESSION['senha'])) {
?>

<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Adicionar um registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <form method="post">
      <label for="valor">Valor: </label>
      <input type="number" id="valor" name="valor" step="any" required> <br> <br>
      <label for="data">Data: </label>
      <input type="date" id="data" name="data" required> <br> <br> <br>
      <input type="submit" value="submit">
    </form>
    <a href="index.php">
      <button>Voltar</button>
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>

<?php
  }
  else {
    header("location: login.php");
    die;
  }
?>