<html>
  <head>
    <meta charset="UTF-8">
    <title>Adicionar registro de lucro</title>
  </head>
  <body>
    <form action="addLucro.php" method="get">
      <label for="valor">Valor: </label>
      <input type="number" id="valor" name="valor" step="any" required> <br> <br>
      <label for="data">Data: </label>
      <input type="date" id="data" name="data" required> <br> <br> <br>
      <input type="submit" value="submit">
    </form>
    <a href="index.php">
      <button>Voltar</button>
    </a>
  </body>
</html>