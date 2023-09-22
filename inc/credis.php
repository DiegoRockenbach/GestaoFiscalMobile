<?php

require 'Credis/Client.php';

$clienteCredis = json_decode(file_get_contents("inc/clienteCredis.json"), true);

$redis = new Credis_Client($clienteCredis["param1"], $clienteCredis["param2"], $clienteCredis["param3"], $clienteCredis["param4"], $clienteCredis["param5"], $clienteCredis["param6"]);


/* REDIS TEST
if ($redis->ping()) {
  echo "PONG";
}
*/

?>