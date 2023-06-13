<?php
  include "inc/paginaRestrita.php";
	include "inc/credis.php";
	$idGET = $_GET["idGET"];
	$dataGET = $_GET["dataGET"];
  $dataRedis = date_create_from_format("d/m/Y", $dataGET, timezone_open("America/Sao_Paulo"));
  $dataRedis = date_format($dataRedis, "Y:m");
	$rediskeyPendencias = "pendencias:$dataRedis";
	$banco = $redis->get($rediskeyPendencias);
	$banco = json_decode($banco);
	$numRegistros = count($banco);
	for($i = 0; $i <= $numRegistros; $i++) {
		if (isset($banco[$i])) {
			if ($banco[$i]->id == $idGET) {
				unset($banco[$i]);
				$banco = array_values($banco);
				$banco = json_encode($banco);
				$redis->set($rediskeyPendencias, $banco);
				$banco = json_decode($banco);
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
	header("location: checkPendencias.php?dataGET=$dataGET");
?>