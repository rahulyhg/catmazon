<?php

class categories extends PDOLayer {
	public $id;
	public $category_name;

	public function __construct() {
		PDOLayer::__construct();
	}

}

?>