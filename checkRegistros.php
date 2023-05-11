<html>
  <head>
    <meta charset="UTF-8">
    <title>Página principal</title>
  </head>
  <body>
    <form method="get">
      <label for="mes">Qual mês deseja consultar?</label>
      <input type="month" id="mes" name="mes" onchange="form.submit()">
    </form>
    <div>
    <?php
			if (!$_GET) {
			}
			else {
				$mesForm = $_GET["mes"];
				$banco = json_decode(file_get_contents("banco.json"));
				$countBanco = count($banco);
				echo  "<table>";
				echo  "  <tr>";
				echo  "    <th>Valor</th>";
				echo  "    <th>Data</th>";
				echo  "  </tr>";
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
						$checkNenhumRegistro = 1;
						$checkTable = 1;
						$row->data = date_format($row->data,"d/m/Y");
						echo "<tr>";
						echo "<td>" . $row->valor . "</td>";
						echo "<td>" . "$row->data" . "</td>";
						echo "</tr>";
					}
					else if (($count >= $countBanco) and (empty($checkNenhumRegistro))){
						echo "Nenhum registro para o mês selecionado";
						$checkNenhumRegistro = 1;
						continue;
					}
				}
				echo  "</table>";
			}
    ?>
    </div>
    <br> <br>
    <a href="index.php">
      <button >Voltar</button>
    </a>
  </body>
</html>