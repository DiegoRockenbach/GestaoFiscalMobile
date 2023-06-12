<?php
  include "inc/paginaRestrita.php";
?>

<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Registro adicionado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="inc/style.css">    
    <link rel="icon" href="inc/img/favicon.ico">
    <link rel="manifest" href="manifest.json">
  </head>
  <body class="fundo">
    <?php
      $valorFORM = $_POST["valor"];
      $dataFORM = $_POST["data"];
      $descFORM = $_POST["desc"];
      $id = "";
      include "inc\credis.php";
      if ($dataFORM == "") {
        $dataFORM = date_create($timezone = "America/Sao_Paulo");
        $dataFORM = date_format($dataFORM, "Y-m-d");        
      }
      $dataRedis = date_create_from_format("Y-m-d", $dataFORM, timezone_open("America/Sao_Paulo"));
      $dataRedis = date_format($dataRedis, "Y:m");
      $rediskeyRegistros = "registros:$dataRedis";
      $banco = $redis->get($rediskeyRegistros);
      if ($banco) {
        $banco = json_decode($banco);  
      }
      else {
        $banco = array();
      }
      $id = uniqid($id);
      $arrayFORM = array(
        "valor" => $valorFORM,
        "data" => $dataFORM,
        "desc" => $descFORM,
        "id" => $id,
      );
      array_push($banco, $arrayFORM);
      $banco = json_encode($banco);
      $redis->set($rediskeyRegistros, $banco);
    ?>
    <div class='alert alert-success valor_Inserido'>Registro inserido!</div>
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