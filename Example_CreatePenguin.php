<?php

namespace CPAPI;
include 'Include.php';

$api 	  = new API();
$username = $api->console->getInput("Username: ");
$password = $api->console->getInput("Password: ");
$email    = $api->console->getInput("Email: ");
$colour   = $api->console->getInput("Colour: ");
$api->createPenguin($username, $password, $email, $colour);

?>