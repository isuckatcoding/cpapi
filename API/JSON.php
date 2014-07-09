<?php

namespace CPAPI;

class Json {

	public function data($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		return curl_exec($curl);
	}

	public function get($name) {
		$path 	 	= "http://media1.clubpenguin.com/play/v2/en/web_service/game_configs/" . $name . ".json";
		$content 	= $this->data($path);
		$arrContent = json_decode($content, true);
		return $arrContent;
	}

}