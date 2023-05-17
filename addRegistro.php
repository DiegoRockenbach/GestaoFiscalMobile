<?php
  session_start();
  if(isset($_SESSION['user']) and isset($_SESSION['senha'])) {
?>

<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Registro adicionado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">    
    <link rel="icon" href="favicon.ico">
  </head>
  <body class="fundo">
    <?php
      $valorFORM = $_POST["valor"];
      $dataFORM = $_POST["data"];
      $id = "";
      if (file_exists("banco.json")) {
        $banco = json_decode(file_get_contents("banco.json"));
        $id = uniqid($id);
        $valdatID = array(
          "valor" => $valorFORM,
          "data" => $dataFORM,
          "id" => $id,
        );
        array_push($banco, $valdatID);
        file_put_contents("banco.json", json_encode($banco));
      }
      else {
        $banco = array();
        $id = uniqid($id);
        $valdatID = array(
          "valor" => $valorFORM,
          "data" => $dataFORM,
          "id" => $id,
        );
        array_push($banco, $valdatID);
        file_put_contents("banco.json", json_encode($banco));
      }
      echo "<div class='alert alert-success valor_Inserido'>Valor inserido!</div>";
    ?>
    <section>
  	  <container>
        <div class="row mx-auto box_Inline">
			    <a class="btn btn_InserirMaisUm" href="formAddRegistro.php">Inserir mais um registro</a>
			    <a class="btn btn_Voltar" href="index.php">Voltar</a>
  	    </div>
  	  </container>
  	</section>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</html>

<?php
  }
  else {
    header("location: formLogin.php");
    die;
  }
?>