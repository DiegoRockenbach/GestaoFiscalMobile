<?php
  session_start();
  if(isset($_SESSION['user']) and isset($_SESSION['senha'])) {
?>

<!doctype html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Página principal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.ico">
    <link rel="shortcut icon" href="favicon.ico">
  </head>
  <body class="fundo">
    <section>
      <container>
        <div class="row">
          <div class="col-lg-12 col-sm-12 col-xm-12 d-flex align-content-center justify-content-center">
            <a class="a_Index" href="formAddRegistro.php">
              <button class='btn_Index'>Adicionar Registro</button>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="d-flex align-content-center justify-content-center">
            <a class="a_Index" href="checkRegistros.php">
              <button class='btn_Index'>Checar registros</button>
            </a>
          </div>
        </div>
      </container>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>  
</html>

<?php
  }
  else {
    header("location: login.php");
    die;
  }
?>