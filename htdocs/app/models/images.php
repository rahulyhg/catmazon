<?php 
class images extends PDOLayer {
	public $image;
	public $id;
	public $product_id;
	public $name;

	public function __construct() {
		PDOLayer::__construct();
	}

	public function upload(){
		$this->insert();
	}
}

?>