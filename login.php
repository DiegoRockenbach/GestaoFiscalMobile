<?php
  $userFORM = $_POST["user"];
  $senhaFORM = $_POST["senha"];
  $verificaLogin = json_decode(file_get_contents("contaCERTA.txt"), true);
  if (($userFORM == $verificaLogin["user"]) and ($senhaFORM == $verificaLogin["senha"])) {
    session_start();
    $_SESSION['user'] = $userFORM;
    $_SESSION['senha'] = $senhaFORM;
    header("location: index.php");
    die;
  }
  else {
    echo "você não sou eu!";
    die;
  }
?>