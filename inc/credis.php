<?php

require 'Credis/Client.php';
$redis = new Credis_Client('tcp://redis-16940.c265.us-east-1-2.ec2.cloud.redislabs.com', '16940', null, '', 0, 'DSIeGDlbrscStNxtZ5PuzUQMzWE9TzXe');


/* REDIS TEST
if ($redis->ping()) {
  echo "PONG";
}
*/
?>