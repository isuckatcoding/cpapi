<?php

function include_files($folder) {
	foreach(glob($folder . "/*.php") as $file) {
		include_once $file;
	}
}

include_files("API");
include_files("Extra");

?>