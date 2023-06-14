<?php
  include "inc/paginaRestrita.php";
?>

<!doctype html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Página principal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="inc/style.css">
    <link rel="icon" href="inc/img/favicon.ico">
    <link rel="manifest" href="manifest.json">
  </head>
  <body class="fundo">
    <section class="sectionIndex row-mx-auto">
      <div class="indexRegistro col-lg-5 col-md-5 col-sm-12">
        <a class="btn btn_Index btn_RegCima row-mx-auto" href="formAddRegistro.php">Adicionar Registro</a>
        <br>
        <a class="btn btn_Index btn_RegBaixo row-mx-auto" href="checkRegistros.php">Checar Registros</a>
      </div>
      <div class="linhaSeparadora row-mx-auto"></div>
      <div class="indexPendencia col-lg-5 col-md-5 col-sm-12">
        <a class="btn btn_Index btn_PenCima row-mx-auto" href="formAddPendencia.php">Adicionar Pendência</a>
        <br>
        <a class="btn btn_Index btn_PenBaixo row-mx-auto" href="checkPendencias.php">Checar Pendências</a>
      </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>  
</html>