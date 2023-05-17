<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Verificar Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="inc/style.css">
    <link rel="icon" href="inc/img/favicon.ico">
  </head>
  <body class="fundo">
    <?php
      $userFORM = $_POST["user"];
      $senhaFORM = $_POST["senha"];
      $verificaLogin = json_decode(file_get_contents("inc/contaCERTA.json"), true);
      if (($userFORM == $verificaLogin["user"]) and ($senhaFORM == $verificaLogin["senha"])) {
        session_start();
        $_SESSION['user'] = $userFORM;
        $_SESSION['senha'] = $senhaFORM;
        header("location: index.php");
        die;
      }
      else {
        echo "<div class='row mx-auto alert alert-danger login_Falha'>Usuário/Senha errado inserido!</div>";
      }
    ?>
    <section>
  	  <container>
  	    <div class="row mx-auto">
			    <a class="btn btn_Voltar" href="formLogin.php">Voltar</a>
  	    </div>
  	  </container>
  	</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>