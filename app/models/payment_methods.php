<?php

class payment_methods extends PDOLayer {
	public $card_number;
	public $card_type;
	public $id;
	public $user_id;

	public function __construct() {
		PDOLayer::__construct();
	}
}

?>