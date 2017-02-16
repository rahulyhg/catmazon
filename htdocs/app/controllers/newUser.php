<?php

class newUser extends Controller {

	public function index (){
		if (!isset($_SESSION['activeUser'])) {
			$this->view('home/newUser');
		} else {
			$this->view('home/oops');
		}
		home::unsetSearch();
	}
	
	public function createUser () {
		if (isset($_POST['signUpSubmit'])){
			//create instances of users and addresses models
			$users = $this->model('users');
			$address = $this->model('addresses');
			if( isset($_POST['signUpSubmit'])) {
	            
				//checks if email already exists in the db
				($users->checkEmail($_POST['email'])) ? $users->email = $_POST['email'] : $this->view('home/newUser');
	            $email = $_POST['email'];
	            $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$users->password_hash = $pass_hash;
				$users->first_name = $_POST['first_name'];
				$users->last_name = $_POST['last_name'];
				$users->birth_date = $_POST['birth_date'];
				$users->main_phone = $_POST['main_phone'];
				$users->sec_phone = ($_POST['sec_phone']) ? $_POST['sec_phone'] : null;
				$users->is_admin = 0;

				$users->insert();
	            
	            $arr['email'] = $email;

				$findUser = $users->where($arr);
				$id = $findUser[0]->id;

				$address->city = $_POST['city'];
				$address->country = $_POST['country'];
				$address->postal_code = $_POST['postal_code'];
				$address->state = $_POST['state'];
				$address->street = $_POST['street'];
				$address->user_id = $id;

				$address->insert();

				$_SESSION['activeUser'] = $id;
				$_SESSION['activeUserFName'] = $_POST['first_name'];
			}	

		}
		$this->view('home/index');

	}
}
?>