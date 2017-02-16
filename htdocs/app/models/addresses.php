<?php

class addresses extends PDOLayer {
	public $city;
	public $country;
	public $postal_code;
	public $state;
	public $street;
	public $id;
	public $user_id;

	public function __construct() {
		PDOLayer::__construct();
	}
}

?>