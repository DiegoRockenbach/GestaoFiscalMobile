<html>
  <?php
    $valorFORM = $_POST["valor"];
    $dataFORM = $_POST["data"];
    $valdat = array(
      "valor" => $valorFORM,
      "data" => $dataFORM,
    );
    if (file_exists("banco.json")) {
      $banco = json_decode(file_get_contents("banco.json"));
      array_push($banco, $valdat);
      file_put_contents("banco.json", json_encode($banco));
    }
    else {
      $banco = array();
      array_push($banco, $valdat);
      file_put_contents("banco.json", json_encode($banco));
    }
    echo "Valor inserido!";
  ?>
  <br> <br>
  <a href="index.php">
    <button>Voltar</button>
  </a>
  <a href="formAddRegistro.php">
    <button>Inserir mais um registro</button>
  </a>
</html>