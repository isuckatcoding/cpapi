<?php

namespace CPAPI;
use Extra;

class API {

	private $api = 'FD 9B407F96-418B-4E0B-93DB-3AD33CC7D72E:205EF7823B24EE5277E318E061E5557F4648F1BF4CCFB457';
	private $authToken;
	private $username;
	public $console;

	public function __construct() { 
		$this->console = new Extra\Console(); 
	}

	public function getData(Array $args) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		if(isset($args['url']))
			curl_setopt($curl, CURLOPT_URL, $args['url']);
		if(isset($args['httpheader']))
			curl_setopt($curl, CURLOPT_HTTPHEADER, $args['httpheader']);
		if(isset($args['post']))
			curl_setopt($curl, CURLOPT_POST, $args['post']);
		if(isset($args['customrequest']))
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $args['customrequest']);
		if(isset($args['postfields']))
			curl_setopt($curl, CURLOPT_POSTFIELDS, $args['postfields']);
		$data = curl_exec($curl);
		return $data;
		curl_close($curl);
	}

	public function login($username, $password) {
		$url     = "https://api.disney.com/clubpenguin/mobile/v2/authToken?appId=CPMCAPP&appVersion=1.4&language=en";
		$headers = array('Authorization: Basic ' . base64_encode($username . ":" . $password) . "," . $this->api);
		$data    		= $this->getData(array("url" => $url, "httpheader" => $headers));
		$arrData 		= json_decode($data, true);
		$this->username = $username;
		if(empty($arrData['errorResponse'])) {
			$this->authToken = $arrData['authToken'];
			$this->username  = $username;
			$this->console->fine("Logged in with " . $username);
		}
		else
			die($arrData['errorResponse']['message']);
	}

	public function addCoins($coins) {
		$url      = "https://api.disney.com/clubpenguin/mobile/v2/coins?appId=CPMCAPP";
		$strAuth  = base64_encode($this->authToken . ":" . "(null)") . "," . $this->api;
		$strCoins = utf8_encode('{"$inc":{"coins":' . $coins . '}}');
		$headers  = array(
			"X-Request-Token: d6cf891a9600f44cc645466a401e26a6845fada1a2a3e902d5584530263b9aaa63324732294fbe4eafdce1860416592b85e32131c480bba34a9727bd08f25d27",
			"Content-Type: application/json",
			"X-Request-Timestamp: 1404333122",
			"Connection: keep-alive",
			"Accept: */*",
			"Accept-Language: en-us",
			"User-Agent: Club%20Penguin/1.4.12376 CFNetwork/672.1.13 Darwin/14.0.0 Paros/3.2.13",
			"Authorization: Basic " . $strAuth
		);
		$data 	 = $this->getData(array("url" => $url, "customrequest" => "PUT", "postfields" => $strCoins, "httpheader" => $headers));
		$arrData = json_decode($data, true);
		if(empty($arrData['errorResponse']))
			$this->console->fine("Added {$coins} to {$this->username}");
		else
			die($arrData['errorResponse']['message']);
	}

	public function addItem($item) {
		$url     = "https://api.disney.com/clubpenguin/mobile/v2/purchase?catalogId=500435792&itemType=paper_item&itemId=" . $item;
		$data    = $this->getData(array("url" => $url, "post" => true, "postfields" => "{}", "httpheader" => array('Authorization: Basic ' . base64_encode($this->authToken . ":") . "," . $this->api)));
		$arrData = json_decode($data, true);
		if(empty($arrData['errorResponse']))
			$this->console->fine("Successfully added item {$item} to {$this->username}");
		else
			die($arrData['errorReponse']['message']);
	}

	public function addIgloo($id) {
		$url  	 = "https://api.disney.com/clubpenguin/mobile/v2/purchase?catalogId=400846864&itemType=igloo&itemId=" . $id;
		$data 	 = $this->getData(array("url" => $url, "post" => true, "postfields" => "{}", "httpheader" => array("Authorization: Basic " . base64_encode($this->authToken . ":") . "," . $this->api)));
		$arrData = json_decode($data, true);
		if(empty($arrData['errorResponse']))
			$this->console->fine("Addded igloo {$id} to {$this->username}");
		else
			die($arrData['errorResponse']['message']);
	}

	public function addIglooLocation($id) {
		$url  	 = "https://api.disney.com/clubpenguin/mobile/v2/purchase?catalogId=400846864&itemType=igloo&itemId=" . $id;
		$data 	 = $this->getData(array("url" => $url, "post" => true, "postfields" => "{}", "httpheader" => array("Authorization: Basic " . base64_encode($this->authToken . ":") . "," . $this->api)));
		$arrData = json_decode($data, true);
		if(empty($arrData['errorResponse']))
			$this->console->fine("Added igloo location {$id} to {$this->username}");
		else
			die($arrData['errorResponse']['message']);
	}

	public function addFloor($id) {
		$url  	 = "https://api.disney.com/clubpenguin/mobile/v2/purchase?catalogId=400846864&itemType=igloo_floor&itemId=" . $id;
		$data 	 = $this->getData(array("url" => $url, "post" => true, "postfields" => "{}", "httpheader" => array("Authorization: Basic " . base64_encode($this->authToken . ":") . "," . $this->api)));
		$arrData = json_decode($data, true);
		if(empty($arrData['errorResponse']))
			$this->console->fine("Added floor {$id} to {$this->username}");
		else
			die($arrData['errorResponse']['message']);
	}

	public function addFurniture($id, $amount = 1) {
		$count = 0;
		$url = "https://api.disney.com/clubpenguin/mobile/v2/purchase?catalogId=500435792&itemType=furniture_item&itemId=" . $id;
		for($i = 0; $i < $amount; $i++) {
			$count++;
			$data    = $this->getData(array("url" => $url, "post" => true, "postfields" => "{}", "httpheader" => array("Authorization: Basic " . base64_encode($this->authToken . ":") . "," . $this->api)));
			$arrData = json_decode($data, true);
			if(empty($arrData['errorResponse']))
				$this->console->fine("Added 1 furniture item of ID {$id}. Total: {$count}");
			else
				die($arrData['errorResponse']['message']);
		}
	}

	public function addPuffleItem($id) {
		$url  	 = "http://api.disney.com/clubpenguin/mobile/v2/purchase?catalogId=500435792&itemType=puffle_item&itemId=" . $id;
		$data 	 = $this->getData(array("url" => $url, "post" => true, "postfields" => "{}", "httpheader" => array("Authorization: Basic " . base64_encode($this->authToken . ":") . "," . $this->api)));
		$arrData = json_decode($data, true);
		if(empty($arrData['errorResponse']))
			$this->console->fine("Added puffle item {$id} to {$this->username}");
		else
			die($arrData['errorResponse']['message']);
	}

	public function createPenguin($username, $password, $email, $colour = 4) {
		$url     = "https://api.disney.com/clubpenguin/mobile/v2/account?appVersion=1.4.1";
		$headers = array(
			'X-Request-Token: d6cf891a9600f44cc645466a401e26a6845fada1a2a3e902d5584530263b9aaa63324732294fbe4eafdce1860416592b85e32131c480bba34a9727bd08f25d27',
			'Content-Type: application/json',
			'X-Request-Timestamp: 1404333122',
			'Connection: keep-alive',
			'Accept: */*',
			'Accept-Language: en-us',
			'User-Agent: Club%20Penguin/1.4.12376 CFNetwork/672.1.13 Darwin/14.0.0 Paros/3.2.13',
			'Authorization: ' . $this->api
		);
		$strCreate = utf8_encode('{"password":"' . $password . '","username":"' . $username . '","language":1,"email":"' . $email . '","color":"' . $colour . '","daysAsMember":16}');
		$data = $this->getData(array("url" => $url, "customrequest" => "PUT", "postfields" => $strCreate, "httpheader" => $headers));
		$arrData = json_decode($data, true);
		if(empty($arrData['errorResponse']))
			$this->console->fine("Created account {$username} with password {$password} and email {$email}");
		else
			die($arrData['errorResponse']['message']);
	}

}

?>