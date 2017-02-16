<?php

class ratings extends PDOLayer {
	public $comment;
	public $product_id;
	public $star_rating;
	public $user_id;

	public function __construct() {
		PDOLayer::__construct();
	}

	public function alreadyCommented()
	{
		return ($this->where(array('user_id'=>$this->user_id, 'product_id'=>$this->product_id)));
	}

	public function deleteRating()
	{

		$stmt = $this->_connection->prepare("DELETE FROM $this->_className WHERE user_id = ? AND product_id = ?");
        $stmt->execute(array($this->user_id, $this->product_id));
	}
}

?>