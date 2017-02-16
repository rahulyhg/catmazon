<?php

class sale_details extends PDOLayer {
	public $discount;
	public $price;
	public $product_id;
	public $quantity;
	public $id;
	public $sale_id;

	public function __construct() {
		PDOLayer::__construct();
	}
}

?>