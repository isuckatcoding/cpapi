<?php

namespace CPAPI;
include 'Include.php';

$api 	  = new API();
$username = $api->console->getInput("Username: ");
$password = $api->console->getInput("Password: ");
$api->login($username, $password);

while(true) {
	$coins    = $api->console->getInput("Coins: ");
	if($coins <= 1000000)
		$api->addCoins($coins);
	else
		die("Please enter an amount less than 1,000,000.");
}

?>
