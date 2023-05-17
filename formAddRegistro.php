<?php
  session_start();
  if(isset($_SESSION['user']) and isset($_SESSION['senha'])) {
?>

<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Adicionar um registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="inc/style.css">    
    <link rel="icon" href="inc/img/favicon.ico">
  </head>
  <body class="fundo">
    <section>
  	  <container>
  	    <div class="row mx-auto">
          <form class="formValdat" action="addRegistro.php" method="post">
            <label for="valor">Valor: </label> <br>
            <input type="number" id="valor" name="valor" step="any" required> <br>
            <label for="data">Data: </label> <br>
            <input type="date" id="data" name="data" required>
            <input class="btn btn_Submit" type="submit" name="submit" value="Enviar">
          </form>
  	    </div>
  	  </container>
  	</section>
	  <section>
  	  <container>
  	    <div class="row mx-auto">
			    <a class="btn btn_Voltar" href="index.php">Voltar</a>
  	    </div>
  	  </container>
  	</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>

<?php
  }
  else {
    header("location: formLogin.php");
    die;
  }
?>