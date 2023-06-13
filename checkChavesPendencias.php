<?php
  include "inc/paginaRestrita.php";
	include "inc/credis.php";
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
  	<div class="row mx-auto">
  		<?php
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
			?>
  	</div>
		<section>
  		<container>
  		  <div class="row mx-auto">
			    <a class="btn btn_Voltar" href="index.php">Voltar</a>
  		  </div>
  		</container>
  	</section>

    <!-- Script JS para tornar a table row clicável ↓↓ -->
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const rows=document.querySelectorAll("tr[data-href]");
        rows.forEach(row => {
          row.addEventListener("click", () => {
            window.location.href = row.dataset.href;
          });
        });
      });
    </script>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>