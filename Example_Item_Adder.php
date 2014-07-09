<?php

namespace CPAPI;
include 'Include.php';

$api 	  = new API();
$username = $api->console->getInput("Username: ");
$password = $api->console->getInput("Password: ");
$api->login($username, $password);

while(true) {
	$item = $api->console->getInput("Item ID: ");
	$api->addItem($item);
}

?>
