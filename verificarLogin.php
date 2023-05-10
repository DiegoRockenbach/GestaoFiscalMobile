<?php
  $userFORM = $_GET["user"];
  $senhaFORM = $_GET["senha"];
  $verificaLogin = json_decode(file_get_contents("contaCERTA.txt"), true);
  if (($userFORM == $verificaLogin["user"]) and ($senhaFORM == $verificaLogin["senha"])) {
    $_SESSION['user'] = $userFORM;
    $_SESSION['senha'] = $senhaFORM;
    file_put_contents("conta.txt",json_encode($_SESSION));
    header("location: index.php");
    die;
  }
  else {
    echo "você não sou eu!";
    die;
  }
?>