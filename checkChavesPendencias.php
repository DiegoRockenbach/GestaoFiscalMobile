<?php
  include "inc/paginaRestrita.php";
	include "inc/credis.php";
	
	$resultadosBusca = [];
	$buscaAtiva = false;
	$somaTotal = 0;
	
	if (isset($_POST['buscar'])) {
		$buscaAtiva = true;
		$termoBusca = $_POST['termo'] ?? '';
		$mesInicio = $_POST['mesInicio'] ?? '';
		$mesFim = $_POST['mesFim'] ?? '';
		$valorMin = $_POST['valorMin'] ?? '';
		$valorMax = $_POST['valorMax'] ?? '';
		
		$chavesPendencias = $redis->keys("pendencias:*");
		rsort($chavesPendencias, SORT_REGULAR);
		
		foreach($chavesPendencias as $chave) {
			$mesChave = str_replace("pendencias:", "", $chave);
			
			if (!empty($mesInicio) && $mesChave < str_replace("-", ":", $mesInicio)) {
				continue;
			}
			if (!empty($mesFim) && $mesChave > str_replace("-", ":", $mesFim)) {
				continue;
			}
			
			$banco = $redis->get($chave);
			$banco = json_decode($banco);
			
			if (!empty($banco)) {
				foreach($banco as $pendencia) {
					$match = true;
					
					if (!empty($termoBusca)) {
						$palavras = explode(' ', $termoBusca);
						$credDev = $pendencia->credDev;
						
						foreach ($palavras as $palavra) {
							$palavra = trim($palavra);
							if (!empty($palavra) && stripos($credDev, $palavra) === false) {
								$match = false;
								break;
							}
						}
					}
					
					if ($valorMin !== '' && $pendencia->valor < floatval($valorMin)) {
						$match = false;
					}
					
					if ($valorMax !== '' && $pendencia->valor > floatval($valorMax)) {
						$match = false;
					}
					
					if ($match) {
						$pendencia->mesOrigem = $mesChave;
						$resultadosBusca[] = $pendencia;
						$somaTotal += floatval($pendencia->valor);
					}
				}
			}
		}
		
		usort($resultadosBusca, function($a, $b) {
			$dataA = date_create_from_format("Y-m-d", $a->data);
			$dataB = date_create_from_format("Y-m-d", $b->data);
			if ($dataA == $dataB) {
				return 0;
			}
			return $dataA > $dataB ? -1 : 1;
		});
	}
?>

<!doctype html>
  <head>
  	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  	<title>Checar chaves de pendências</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  	<link rel="stylesheet" href="inc/style.css">
  	<link rel="icon" href="inc/img/favicon.ico">
		<link rel="manifest" href="manifest.json">
  </head>
  <body class='fundo'>
		<div class="searchBar">
			<form method="post" id="mainSearchForm" class="searchBarForm">
				<div class="searchInputGroup">
					<input type="text" name="termo" id="searchInput" placeholder="Buscar em todas as pendências..." value="<?php echo htmlspecialchars($_POST['termo'] ?? ''); ?>" autocomplete="off">
					<button type="button" id="filterBtn" class="filterButton" title="Filtros">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
							<path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
						</svg>
					</button>
				</div>
				<input type="hidden" name="buscar" value="1">
			</form>
		</div>
		
		<div id="filterModal" class="modal">
			<div class="modalContent">
				<div class="modalHeader">
					<h3>Filtros de Busca</h3>
				</div>
				<div class="modalBody">
					<div class="filterGroup">
						<label for="mesInicio">Do mês</label>
						<input type="month" id="mesInicio" name="mesInicio" form="mainSearchForm" value="<?php echo htmlspecialchars($_POST['mesInicio'] ?? ''); ?>">
					</div>
					<div class="filterGroup">
						<label for="mesFim">Até o mês</label>
						<input type="month" id="mesFim" name="mesFim" form="mainSearchForm" value="<?php echo htmlspecialchars($_POST['mesFim'] ?? ''); ?>">
					</div>
					<div class="filterGroup">
						<label for="valorMin">Valor mínimo (R$):</label>
						<input type="number" id="valorMin" name="valorMin" step="any" form="mainSearchForm" value="<?php echo htmlspecialchars($_POST['valorMin'] ?? ''); ?>">
					</div>
					<div class="filterGroup">
						<label for="valorMax">Valor máximo (R$):</label>
						<input type="number" id="valorMax" name="valorMax" step="any" form="mainSearchForm" value="<?php echo htmlspecialchars($_POST['valorMax'] ?? ''); ?>">
					</div>
					<div class="modalActions">
						<button type="submit" form="mainSearchForm" class="applyFilters">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.5em;">
								<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
							</svg>
							Pesquisar
						</button>
						<button type="button" class="clearFiltersBtn" onclick="clearFilters()" title="Limpar filtros">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
								<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
								<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>
		

		
  	<div class="row mx-auto">
  		<?php
			if ($buscaAtiva) {
				// Exibir resultados da busca
				if (empty($resultadosBusca)) {
					echo "<div class='row mx-auto col-lg-10'>";
					echo "<div class='alert alert-warning nenhum_Registro'>Nenhuma pendência encontrada com os critérios especificados.</div>";
					echo "</div>";
				} else {
					echo "<div class='row mx-auto col-lg-10'>";
					echo "<div class='alert searchResultInfo'>";
					echo "Encontradas <strong>" . count($resultadosBusca) . "</strong> pendência(s)";
					echo "</div>";
					echo "<table class='table tableRegistros table-hover'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>Envolvido e valor</th>";
					echo "<th>Data</th>";
					echo "<th>Descrição</th>";
					echo "<th>Mês</th>";
					echo "<th></th>";
					echo "<th></th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					foreach($resultadosBusca as $row) {
						$dataFormatada = date_create_from_format("Y-m-d", $row->data, timezone_open("America/Sao_Paulo"));
						$dataFormatada = date_format($dataFormatada, "d/m/Y");
						$mesFormatado = str_replace(":", "/", $row->mesOrigem);
						$valorFloat = floatval($row->valor);
						$rowClass = $valorFloat < 0 ? 'table-danger' : 'table-success';
						
						echo "<tr class='$rowClass'>";
						if ($valorFloat < 0) {
							echo "<td>Eu estou devendo R$ " . number_format($valorFloat * -1, 2, ",", "") . " para <strong>$row->creddev</strong></td>";
						} else {
							echo "<td><strong>$row->creddev</strong> está me devendo <strong>R$ " . number_format($valorFloat, 2, ",", "") . "</strong></td>";
						}
						echo "<td>" . $dataFormatada . "</td>";
						echo "<td>" . htmlspecialchars($row->desc) . "</td>";
						echo "<td>" . $mesFormatado . "</td>";
						echo "<td><a href='deletePendencia.php?idGET=$row->id&dataGET=$dataFormatada'><img class='lixeiraIMG' src='inc/img/lixeira.png'></a></td>";
						echo "<td><a href='quitarPendencia.php?idGET=$row->id&dataGET=$dataFormatada&valorGET=$row->valor&descGET=$row->desc&creddevGET=$row->creddev'><img class='quitarIMG' src='inc/img/quitar.png'></a></td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
					echo "<div class='alert soma_Mes'>";
					echo "Total dos valores encontrados: R$ " . number_format($somaTotal, 2, ",", "") . "";
					echo "</div>";
					echo "</div>";
				}
			} else {
				// Exibir lista de chaves normalmente
				$chavesPendencias = $redis->keys("pendencias:*");
				foreach($chavesPendencias as $row) {
					if (strlen($redis->get($row)) <= 5) {
						$redis->del($row);
						continue;
					}
				}
				$chavesPendencias = $redis->keys("pendencias:*");
				if (empty($chavesPendencias)) {
					echo "<div class='row mx-auto col-lg-10'>";
					echo "<div class='alert alert-warning nenhum_Registro'>Nenhuma chave redis encontrada!</div>";
					echo "</div>";
					echo "<div class='row mx-auto'>";
					echo "<a class='btn btn_Voltar' href='index.php'>Voltar</a>";
					echo "</div>";
					die;
				}
				rsort($chavesPendencias, SORT_REGULAR);
				echo "<div class='row mx-auto col-lg-10'>";
				echo "<table class='table tableChaves table-hover'>";
				echo "<tr>";
				echo "<th>Chaves de Pendências</th>";
				echo "</tr></thead>";
				foreach($chavesPendencias as $row) {
					$row = str_replace(
						"pendencias:",
						"",
						$row,
					);
					echo "<tr data-href='checkPendencias.php?rediskeyGET=pendencias:$row'>";
					echo "<td>$row</td>";
					echo "</tr>";
				}
				echo "</table>";
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

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const rows=document.querySelectorAll("tr[data-href]");
        rows.forEach(row => {
          row.addEventListener("click", () => {
            window.location.href = row.dataset.href;
          });
        });
      });
			
			const modal = document.getElementById('filterModal');
			const filterBtn = document.getElementById('filterBtn');
			const searchInput = document.getElementById('searchInput');
			const mainSearchForm = document.getElementById('mainSearchForm');
			
			let searchTimeout;
			let lastSearchValue = searchInput.value;
			
			if (searchInput.value.trim().length > 0) {
				searchInput.focus();
				const length = searchInput.value.length;
				searchInput.setSelectionRange(length, length);
			}
			
			searchInput.addEventListener('input', () => {
				clearTimeout(searchTimeout);
				searchTimeout = setTimeout(() => {
					const currentValue = searchInput.value.trim();
					if (currentValue.length > 0 || (lastSearchValue.length > 0 && currentValue.length === 0)) {
						mainSearchForm.submit();
					}
					lastSearchValue = currentValue;
				}, 500);
			});
			
			filterBtn.addEventListener('click', () => {
				modal.style.display = 'block';
			});
			
			let mouseDownTarget = null;
			
			window.addEventListener('mousedown', (e) => {
				mouseDownTarget = e.target;
			});
			
			window.addEventListener('click', (e) => {
				if (e.target === modal && mouseDownTarget === modal) {
					modal.style.display = 'none';
				}
				mouseDownTarget = null;
			});
			
			window.clearFilters = function() {
				document.getElementById('mesInicio').value = '';
				document.getElementById('mesFim').value = '';
				document.getElementById('valorMin').value = '';
				document.getElementById('valorMax').value = '';
			};
    </script>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>