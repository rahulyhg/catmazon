<?php

class payment_methods extends PDOLayer {
	public $card_number;
	public $card_type;
	public $id;
	public $user_id;

	public function __construct() {
		PDOLayer::__construct();
	}

	public function checkCardNumber ($card, $id){
		$arr = array('card_number'=>$card,'user_id'=>$id);
		if ( count($this->where($arr)) == 0){ 
			return true;
		} else { //display an alert if the user tries to create an account with an email already in our database
			$message = "You already have this card registered!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			return false;
		}
	}
}

?>