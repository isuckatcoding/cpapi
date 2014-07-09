<?php

namespace CPAPI;
include 'Include.php';

$api 	  = new API();
$username = $api->console->getInput("Username: ");
$password = $api->console->getInput("Password: ");
$api->login($username, $password);

while(true) {
	$furn   = $api->console->getInput("Furniture ID: ");
	$amount = $api->console->getInput("Amount: ");
	$api->addFurniture($furn, $amount);
}

?>