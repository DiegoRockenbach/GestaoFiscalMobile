<?php
  $userFORM = $_GET["user"];
  $senhaFORM = $_GET["senha"];
  var_dump($userFORM);
  var_dump($senhaFORM);
  if (($userFORM == "diegorock") and ($senhaFORM == "nataliaband")) {
    // redireciona para index.html
  }
  else {
    echo "você não sou eu!";
    die;
  }
?>