<?php

class ratings extends PDOLayer {
	public $comment;
	public $product_id;
	public $star_rating;
	public $user_id;

	public function __construct() {
		PDOLayer::__construct();
	}

	public function alredyCommented()
	{
		return ($this->where(array('user_id'=>$this->user_id, 'product_id'=>$this->product_id)));
	}
}

?>