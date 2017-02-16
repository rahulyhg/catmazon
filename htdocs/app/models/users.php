<?php

class Users extends PDOLayer {
	public $email;
	public $password_hash;
	public $first_name;
	public $last_name;
	public $birth_date;
	public $main_phone;
	public $sec_phone;
	public $is_admin;
	public $id;
	public function __construct() {
		PDOLayer::__construct();
	}

	public function checkEmail ($email){
		$arr['email'] = $email;
		if ( count($this->where($arr)) == 0){ 
			return true;
		} else { //display an alert if the user tries to create an account with an email already in our database
			$message = "There is already an account with this email!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			return false;
		}
	}
}

?>