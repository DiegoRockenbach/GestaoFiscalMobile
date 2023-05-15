<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.ico">
    <link rel="shortcut icon" href="favicon.ico">
  </head>
  <body class="fundo">
    <section>
      <container>
        <div class="row mx-auto box_Login">
          <form class="formLogin" action="login.php" method="post">
            <label for="user">Usuário: </label>
            <input type="text" id="user" name="user" required>
            <label for="senha">Senha: </label>
            <input type="password" id="senha" name="senha" required>
            <input class="btn btn_Submit" type="submit" name="submit" value="submit">
          </form>
        </div>
      </container>
    </section>
  </body>
</html>