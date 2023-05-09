<html>
  <?php
    $valorFORM = $_GET["valor"];
    $dataFORM = $_GET["data"];
    $string = "R$ $valorFORM lucrados no dia $dataFORM <br>";
    file_put_contents("banco.txt", json_encode($string),FILE_APPEND);
    echo "Valor inserido!";
  ?>
  <br> <br>
  <a href="index.html">
    <button >Voltar</button>
  </a>
</html>