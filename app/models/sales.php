<?php

class sales extends PDOLayer {
	public $payment_id;
	public $sale_date;
	public $id;
	public $user_id;
	public $address_id;

	public function __construct() {
		PDOLayer::__construct();
	}
}

?>