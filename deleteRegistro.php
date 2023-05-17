<?php
  session_start();
  if(isset($_SESSION['user']) and isset($_SESSION['senha'])) {
?>

<html>
	<head>
		<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Registro deletado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">    
    <link rel="icon" href="favicon.ico">
	</head>
	<body class="fundo">
		<?php
			$idGET = $_GET["id"];
			$banco = json_decode(file_get_contents("banco.json"));
			$numRegistros = count($banco);
			for($i = 0; $i <= $numRegistros; $i++) {
				if (isset($banco[$i])) {
					if ($banco[$i]->id == $idGET) {
						unset($banco[$i]);
						$banco = array_values($banco);
						file_put_contents("banco.json", json_encode($banco));
						$numRegistros = count($banco);
					}
					else {
						continue;
					}
				}
				else {
					continue;
				}
				//echo '$BANCO:';
				//var_dump($banco);
				//echo "<br><br><br> i:";
				//var_dump($i);
				//echo "<br><br><br> BANCO[2]:";
				//var_dump($banco[2]);
				//echo "<br><br><br> BANCO[i]:";
				//var_dump($banco[$i]);
				//echo "<br><br><br> IdGET:";
				//var_dump($idGET);
				//echo "<br><br><br>";
			}

			echo "<div class='alert registro_Del'>Registro deletado com sucesso!</div>"
		?>
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