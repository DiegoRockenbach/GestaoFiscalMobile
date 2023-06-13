<?php
  include "inc/paginaRestrita.php";
	include "inc/credis.php";
	$valorGET = $_GET["valorGET"];									// Valor da pendência
	$dataGET = $_GET["dataGET"];										// Data em que a pendência foi inserida
	date_default_timezone_set('America/Sao_Paulo');
	$currentDate = date('Y-m-d');										// Data do dia atual
	$descGET = $_GET["descGET"];										// Descrição da pendência
	$creddevGET = $_GET["creddevGET"];							// Credor/Devedor da pendência
	$id = "";																				// Id do registro adicionado a partir da pendência quitada
	$idGET = $_GET["idGET"];												// Id da pendência

	// Adicionar pendência ao BD de registros ↓↓
	$dataRedisRegistros = date_create_from_format("Y-m-d", $currentDate);
  $dataRedisRegistros = date_format($dataRedisRegistros, "Y:m");
	$rediskeyRegistros = "registros:$dataRedisRegistros";
	$bancoRegistros = $redis->get($rediskeyRegistros);
	if ($bancoRegistros) {
		$bancoRegistros = json_decode($bancoRegistros);
	}
	else {
		$bancoRegistros = array();
	}
	$id = uniqid($id); // Não confundir com $idGET
	$arrayGET = array(
		"valor" => $valorGET,
		"data" => $currentDate,
		"desc" => "Pendência com $creddevGET inserida em $dataGET com a seguinte descrição: $descGET", 
		"id" => $id,
	);
	array_push($bancoRegistros, $arrayGET);
	$bancoRegistros = json_encode($bancoRegistros);
	$redis->set($rediskeyRegistros, $bancoRegistros);

	// Deletar pendência do BD de pendências ↓↓
	$dataRedisPendencias = date_create_from_format("d/m/Y", $dataGET);
  $dataRedisPendencias = date_format($dataRedisPendencias, "Y:m");
	$rediskeyPendencias = "pendencias:$dataRedisPendencias";
	$bancoPendencias = $redis->get($rediskeyPendencias);
	$bancoPendencias = json_decode($bancoPendencias);
	$numRegistros = count($bancoPendencias);
	for($i = 0; $i <= $numRegistros; $i++) {
		if (isset($bancoPendencias[$i])) {
			if ($bancoPendencias[$i]->id == $idGET) {
				unset($bancoPendencias[$i]);
				$bancoPendencias = array_values($bancoPendencias);
				$bancoPendencias = json_encode($bancoPendencias);
				$redis->set($rediskeyPendencias, $bancoPendencias);
				$bancoPendencias = json_decode($bancoPendencias);
				$numRegistros = count($bancoPendencias);
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