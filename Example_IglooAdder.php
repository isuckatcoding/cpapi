<?php

namespace CPAPI;
include 'Include.php';

$api 	  = new API();
$username = $api->console->getInput("Uername: ");
$password = $api->console->getInput("Password: ");
$api->login($username, $password);

while(true) {
	$igloo = $api->console->getInput("Igloo ID: ");
	$api->addIgloo($igloo);
}

?>