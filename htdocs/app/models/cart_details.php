<?php

class cart_details extends PDOLayer {
	public $user_id;
	public $quantity;
	public $product_id;
	public $id;

	public function __construct() {
		PDOLayer::__construct();
	}
}

?>