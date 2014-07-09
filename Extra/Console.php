<?php

namespace Extra;

class Console {

	public function __call($method_name, $args) {
		$method_name = strtoupper($method_name);
		$message     = $args[0];
		$output      = "[" . $method_name . "] > " . $message . chr(10);
		echo $output;
	}

	public function getInput($msg) {
		echo "[INPUT] > " . $msg;
		return trim(fgets(STDIN));
	}

}

?>