<?php
  include "inc/paginaRestrita.php";
	include "inc/credis.php";
	if (!empty($_POST["mes"])) {
		$mesFORM = $_POST["mes"];
		$mesFORM = date_create_from_format("Y-m", $mesFORM, timezone_open("America/Sao_Paulo"));
		$dataRedis = date_format($mesFORM, "Y:m");
		$rediskeyPendencias = "pendencias:$dataRedis";
	}
	else if (!empty($_GET["dataGET"])) {
		$mesFORM = $_GET["dataGET"];
		$mesFORM = date_create_from_format("d/m/Y", $mesFORM, timezone_open("America/Sao_Paulo"));
		$dataRedis = date_format($mesFORM, "Y:m");
		$rediskeyPendencias = "pendencias:$dataRedis";
	}
	else if (!empty($_GET["rediskeyGET"])) {
		$rediskeyPendencias = $_GET["rediskeyGET"];
		$mesFORM = str_replace(
			"pendencias:",
			"",
			$rediskeyPendencias,
		);
		$mesFORM = date_create_from_format("Y:m", $mesFORM, timezone_open("America/Sao_Paulo"));
	}
	else if (empty($mesFORM)) {
		$mesFORM = date_create($timezone = "America/Sao_Paulo");
		$dataRedis = date_format($mesFORM, "Y:m");
		$rediskeyPendencias = "pendencias:$dataRedis";
	}
?>

<!doctype html>
  <head>
  	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  	<title>Checar pendências</title>
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
				if (!$redis->exists($rediskeyPendencias)) {
					echo "<div class='row mx-auto col-lg-10'>";
					echo "<div class='alert alert-warning nenhum_Registro'>Nenhum registro para o mês selecionado!</div>";
					echo "</div>";
					echo "<div class='row mx-auto'>";
					echo "<a class='btn btn_Voltar' href='index.php'>Voltar</a>";
					echo "</div>";
					die;
				}
				$banco = $redis->get($rediskeyPendencias);
				$banco = json_decode($banco);
				$somaValores = 0;
				$countBanco = count($banco);
				if ($countBanco <= 0) {
					echo "<div class='row mx-auto col-lg-10'>";
					echo "<div class='alert alert-warning nenhum_Registro'>Nenhum registro para o mês selecionado!</div>";
					echo "</div>";
					echo "<div class='row mx-auto'>";
					echo "<a class='btn btn_Voltar' href='index.php'>Voltar</a>";
					echo "</div>";
					die;
				}
				echo "<div class='row mx-auto col-lg-10'>";
				echo "<table class='table tableRegistros table-hover'><thead>";
				echo "<tr>";
				echo "<th>Credor/devedor e valor</th>";
				echo "<th>Data</th>";
				echo "<th>Descrição</th>";
				echo "<th></th>"; //<th> da lixeira
				echo "<th></th>"; //<th> do quitado
				echo "</tr></thead>";
				$mesFORMInicio = date_format($mesFORM, "Y-m-1");
				$mesFORMInicio = date_create_from_format("Y-m-d", $mesFORMInicio, timezone_open("America/Sao_Paulo"));
				$mesFORMFinal = clone $mesFORMInicio;
				date_add($mesFORMFinal, date_interval_create_from_date_string('1 month'));
				foreach($banco as $row) {
					$row->data = date_create($row->data, timezone_open("America/Sao_Paulo"));
					if (isset($count)){
						$count = $count + 1;
					}
					else{
						$count = 1;
					}
					if (($row->data >= $mesFORMInicio) and ($row->data < $mesFORMFinal)){
						$row->data = date_format($row->data,"d/m/Y");
						$valorFloat = floatval($row->valor);
						$somaValores = $somaValores + $valorFloat;
						if ($valorFloat < 0) {
							echo "<tr class='table-danger'>";
							echo "<td>Eu estou devendo R$ " . number_format($row->valor*-1, 2, ",", "") . " para <strong>$row->creddev</strong></td>";
							echo "<td>" . $row->data . "</td>";
							echo "<td>" . $row->desc . "</td>";
							echo "<td><a href='deletePendencia.php?idGET=$row->id&dataGET=$row->data'><img class='lixeiraIMG' src='inc/img/lixeira.png'></a></td>";
							echo "<td><a href='quitarPendencia.php?idGET=$row->id&dataGET=$row->data&valorGET=$row->valor&descGET=$row->desc&creddevGET=$row->creddev'><img class='quitarIMG' src='inc/img/quitar.png'></a></td>";
							echo "</tr>";
						}
						else {
							echo "<tr class='table-success'>";
							echo "<td><strong>$row->creddev</strong> está me devendo <strong>R$ " . number_format($row->valor, 2, ",", "") . "</strong></td>";
							echo "<td>" . $row->data . "</td>";
							echo "<td>" . $row->desc . "</td>";
							echo "<td><a href='deletePendencia.php?idGET=$row->id&dataGET=$row->data'><img class='lixeiraIMG' src='inc/img/lixeira.png'></a></td>";
							echo "<td><a href='quitarPendencia.php?idGET=$row->id&dataGET=$row->data&valorGET=$row->valor&descGET=$row->desc&creddevGET=$row->creddev'><img class='quitarIMG' src='inc/img/quitar.png'></a></td>";
							echo "</tr>";
						}
					}
					if (!isset($valorTotal)) {
						$valorTotal = $row->valor;
					}
					else {
						$valorTotal = $valorTotal + $row->valor;
					}
				}
				echo "</table>";
			?>
  	</div>
		<section>
  		<container>
  		  <div class="row mx-auto box_inline">
					<a class="btn btn_checkChaves" href="checkChavesPendencias.php">Checar chaves registradas</a>
					<a class="btn btn_Voltar" href="index.php">Voltar</a>
  		  </div>
  		</container>
  	</section>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>