<?php
  if (file_exists("conta.txt")) {
    unlink("conta.txt");
  }
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
  </head>
  <body>
    <form action="verificarLogin.php" method="get">
      <label for="user">Usuário: </label>
      <input type="text" id="user" name="user" required> <br> <br>
      <label for="senha">Senha: </label>
      <input type="password" id="senha" name="senha" required> <br> <br> <br>
      <input type="submit" value="submit">
    </form>
  </body>
</html>