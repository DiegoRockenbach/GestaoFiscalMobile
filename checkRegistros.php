<?php
  session_start();
  if(isset($_SESSION['user']) and isset($_SESSION['senha'])) {
?>

<!doctype html>
  <head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Página principal</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  	<link rel="stylesheet" href="inc/style.css">
    <link rel="icon" href="inc/img/favicon.ico">
  </head>
  <body class='fundo'>
  	<section>
  	  <container>
  	    <div class="row mx-auto">
		      <form class='formMes' method="post">
      	  	<label for="mes">Qual mês deseja consultar?</label>
			<br>
      	  	<input type="month" id="mes" name="mes" placeholder="a" onchange="form.submit()">
    	    </form>
  	    </div>
  	  </container>
  	</section>
    <div class="row mx-auto">
    	<?php
				if (file_exists("inc/banco.json")) {
					if ((!$_POST) and (!isset($_GET["dataGET"]))) {
					}
					else {
						if (isset($_GET["dataGET"])) {
							$mesForm = $_GET["dataGET"];
							$mesForm = date_create_from_format("d/m/Y", $mesForm, timezone_open("America/Sao_Paulo"));
							$mesForm = date_format($mesForm, "Y-m");
						}
						if (isset($_POST["mes"])) {
							$mesForm = $_POST["mes"];
						}
						$banco = json_decode(file_get_contents("inc/banco.json"));
						$somaValores = 0;
						$checkNenhumRegistro = 0;
						$countBanco = count($banco);
						if ($countBanco <= 0) {
							echo "<div class='row mx-auto col-lg-10'>";
							echo "<div class='alert alert-warning nenhum_Registro'>Nenhum registro para ser checado</div>";
							echo "</div>";
						}
						echo  "<div class='row mx-auto col-lg-10'>";
						echo  "<table class='table tableRegistros table-hover'><thead>";
						echo  "  <tr>";
						echo  "    <th>Valor</th>";
						echo  "    <th>Data</th>";
						echo  "    <th></th>"; //<th> da lixeira
						echo  "  </tr></thead>";
						$mesFormInicio = date_create($mesForm,timezone_open("America/Sao_Paulo"));
						$mesFormFinal = date_create($mesForm,timezone_open("America/Sao_Paulo"));
						date_add($mesFormFinal, date_interval_create_from_date_string('1 month'));
						foreach($banco as $row) {
							$row->data = date_create($row->data, timezone_open("America/Sao_Paulo"));
							if (isset($count)){
								$count = $count + 1;
							}
							else{
								$count = 1;
							}
							if (($row->data >= $mesFormInicio) and ($row->data < $mesFormFinal)){
								$checkNenhumRegistro = 2;
								$row->data = date_format($row->data,"d/m/Y");
								$valorFloat = floatval($row->valor);
								$somaValores = $somaValores + $valorFloat;
								if ($valorFloat < 0) {
									echo "<tr class='table-danger'>";
									echo "<td>" . $row->valor . "</td>";
									echo "<td>" . $row->data . "</td>";
									echo "<td><a href='deleteRegistro.php?id=$row->id&dataGET=$row->data'><img class='lixeiraIMG' src='inc/img/lixeira.png'></a></td>";
									echo "</tr>";
								}
								else {
									echo "<tr class='table-success'>";
									echo "<td>" . $row->valor . "</td>";
									echo "<td>" . $row->data . "</td>";
									echo "<td><a href='deleteRegistro.php?id=$row->id&dataGET=$row->data'><img class='lixeiraIMG' src='inc/img/lixeira.png'></a></td>";
									echo "</tr>";
								}
							}
							else if (($count >= $countBanco) and ($checkNenhumRegistro == 0)){
								echo "<div class='alert alert-warning nenhum_Registro container-fluid'>Nenhum registro para o mês selecionado!</div>";
								$checkNenhumRegistro = 1;
							}
						}
						echo  "</table>";
						if ($checkNenhumRegistro == 2) {
							echo "<div class='alert soma_Mes'> A soma dos valores desse mês é de R$ " . $somaValores . "</div>";
						}
					}
				}
				else {
					echo "<div class='alert alert-warning nenhum_Registro'>Nenhum registro para ser checado</div>";
				}
    	?>
    </div>
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