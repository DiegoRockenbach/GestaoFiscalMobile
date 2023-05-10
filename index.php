<?php
  session_start();
  $_SESSION = json_decode(file_get_contents("conta.txt"), true);
  if(isset($_SESSION['user']) and isset($_SESSION['senha'])) {
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Página principal</title>
  </head>
  <body>
    <a href="formAddGasto.php">
      <button >Adicionar Gasto</button>
    </a>
    <a href="formAddLucro.php">
      <button >Adicionar Lucro</button>
    </a>
    <a href="checkRegistros.php">
      <button >Checar registros</button>
    </a>
  </body>
</html>

<?php
  }
  else {
    header("location: login.php");
    die;
  }

?>