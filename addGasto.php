<html>
  <?php
    $valorFORM = $_GET["valor"];
    $dataFORM = $_GET["data"];
    file_put_contents("banco.txt", "R$ $valorFORM gastos no dia $dataFORM <br>",FILE_APPEND);
    echo "Valor inserido!";
  ?>
  <br> <br>
  <a href="index.php">
    <button >Voltar</button>
  </a>
</html>