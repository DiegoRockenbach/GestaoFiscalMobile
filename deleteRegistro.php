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
    <link rel="stylesheet" href="inc/style.css">    
    <link rel="icon" href="inc/img/favicon.ico">
	</head>
	<body class="fundo">
		<?php
			$idGET = $_GET["id"];
			$dataGET = $_GET["dataGET"];
			$banco = json_decode(file_get_contents("inc/banco.json"));
			$numRegistros = count($banco);
			for($i = 0; $i <= $numRegistros; $i++) {
				if (isset($banco[$i])) {
					if ($banco[$i]->id == $idGET) {
						unset($banco[$i]);
						$banco = array_values($banco);
						file_put_contents("inc/banco.json", json_encode($banco));
						$numRegistros = count($banco);
					}
					else {
						continue;
					}
				}
				else {
					continue;
				}
			}
			header("location: checkRegistros.php?dataGET=$dataGET");
		?>
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