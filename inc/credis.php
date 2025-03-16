<?php

require 'Credis/Client.php';

$redisHOST = getenv("REDIS_HOST");
$redisPORT = getenv("REDIS_PORT");

$redis = new Credis_Client($redisHOST, $redisPORT);


/* REDIS TEST
if ($redis->ping()) {
  echo "PONG";
}
*/

?>