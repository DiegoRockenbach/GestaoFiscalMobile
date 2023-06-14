<?php
  include "inc/paginaRestrita.php";
	include "inc/credis.php";
	if (!empty($_POST["mes"])) {
		$mesFORM = $_POST["mes"];
		$mesFORM = date_create_from_format("Y-m", $mesFORM, timezone_open("America/Sao_Paulo"));
		$dataRedis = date_format($mesFORM, "Y:m");
		$rediskeyRegistros = "registros:$dataRedis";
	}
	else if (!empty($_GET["dataGET"])) {
		$mesFORM = $_GET["dataGET"];
		$mesFORM = date_create_from_format("d/m/Y", $mesFORM, timezone_open("America/Sao_Paulo"));
		$dataRedis = date_format($mesFORM, "Y:m");
		$rediskeyRegistros = "registros:$dataRedis";
	}
	else if (!empty($_GET["rediskeyGET"])) {
		$rediskeyRegistros = $_GET["rediskeyGET"];
		$mesFORM = str_replace(
			"registros:",
			"",
			$rediskeyRegistros,
		);
		$mesFORM = date_create_from_format("Y:m", $mesFORM, timezone_open("America/Sao_Paulo"));
	}
	else if (empty($mesFORM)) {
		$mesFORM = date_create($timezone = "America/Sao_Paulo");
		$dataRedis = date_format($mesFORM, "Y:m");
		$rediskeyRegistros = "registros:$dataRedis";
	}
?>

<!doctype html>
  <head>
    <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  	<title>Checar registros</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  	<link rel="stylesheet" href="inc/style.css">
    <link rel="icon" href="inc/img/favicon.ico">
		<link rel="manifest" href="manifest.json">
  </head>
  <body class='fundo'>
  	<section>
  	  <container>
  	    <div class="row mx-auto">
		      <form class='formMes' method="post">
      	  	<label for="mes">Qual mês deseja consultar?</label>
						<br>
      	  	<input type="month" id="mes" name="mes" value="<?php echo date_format($mesFORM, "Y-m"); ?>" onchange="form.submit()">
    	    </form>
  	    </div>
  	  </container>
  	</section>
    <div class="row mx-auto">
    	<?php
				if (!$redis->exists($rediskeyRegistros)) {
					echo "<div class='row mx-auto col-lg-10'>";
					echo "<div class='alert alert-warning nenhum_Registro'>Nenhum registro para o mês selecionado!</div>"; 
					echo "</div>";
					echo "<div class='row mx-auto'>";
					echo "<a class='btn btn_checkChaves' href='checkChavesRegistros.php'>Checar chaves registradas</a>";
					echo "<a class='btn btn_Voltar' href='index.php'>Voltar</a>";
					echo "</div>";
					die;
				}
				$banco = $redis->get($rediskeyRegistros);
				$banco = json_decode($banco);
				usort($banco, function($a, $b) {
					$dataA = date_create_from_format("Y-m-d", $a->data);
					$dataB = date_create_from_format("Y-m-d", $b->data);
					if ($dataA == $dataB) {
						return 0;
					}
					return $dataA > $dataB ? -1 : 1;
				});
				$somaValores = 0;
				$countBanco = count($banco);
				if ($countBanco <= 0) {
					echo "<div class='row mx-auto col-lg-10'>";
					echo "<div class='alert alert-warning nenhum_Registro'>Nenhum registro para o mês selecionado!</div>";
					echo "</div>";
					echo "<div class='row mx-auto'>";
					echo "<a class='btn btn_checkChaves' href='checkChavesRegistros.php'>Checar chaves registradas</a>";
					echo "<a class='btn btn_Voltar' href='index.php'>Voltar</a>";
					echo "</div>";
					die;
				}
				echo "<div class='row mx-auto col-lg-10'>";
				echo "<table class='table tableRegistros table-hover'><thead>";
				echo "<tr>";
				echo "<th>Valor</th>";
				echo "<th>Data</th>";
				echo "<th>Descrição</th>";
				echo "<th></th>"; //<th> da lixeira
				echo "</tr></thead>";
				foreach($banco as $row) {
					if (isset($count)){
						$count = $count + 1;
					}
					else{
						$count = 1;
					}
					$row->data = date_create_from_format("Y-m-d", $row->data, timezone_open("America/Sao_Paulo"));
					$row->data = date_format($row->data,"d/m/Y");
					$valorFloat = floatval($row->valor);
					$somaValores = $somaValores + $valorFloat;
					if ($valorFloat < 0) {
						echo "<tr class='table-danger'>";
						echo "<td>R$ " . number_format($row->valor, 2, ",", "") . "</td>";
						echo "<td>" . $row->data . "</td>";
						echo "<td>" . $row->desc . "</td>";
						echo "<td><a href='deleteRegistro.php?idGET=$row->id&dataGET=$row->data'><img class='lixeiraIMG' src='inc/img/lixeira.png'></a></td>";
						echo "</tr>";
					}
					else {
						echo "<tr class='table-success'>";
						echo "<td>R$ " . number_format($row->valor, 2, ",", "") . "</td>";
						echo "<td>" . $row->data . "</td>";
						echo "<td>" . $row->desc . "</td>";
						echo "<td><a href='deleteRegistro.php?idGET=$row->id&dataGET=$row->data'><img class='lixeiraIMG' src='inc/img/lixeira.png'></a></td>";
						echo "</tr>";
					}
				}
				if (empty($valorTotal)) {
					$valorTotal = $row->valor;
				}
				else {
					$valorTotal = $valorTotal + $row->valor;
				}
				echo "</table>";
				echo "<div class='alert soma_Mes'>A soma dos valores <strong>desse mês</strong> é de R$ " . number_format($somaValores, 2, ",", "") . "</div>";
    	?>
    </div>
	  <section>
  	  <container>
  	    <div class="row mx-auto">
					<a class="btn btn_checkChaves" href="checkChavesRegistros.php">Checar chaves registradas</a>
			    <a class="btn btn_Voltar" href="index.php">Voltar</a>
  	    </div>
  	  </container>
  	</section>
	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>