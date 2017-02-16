<?php 

class userPage extends Controller {
	public function index ($id) {

		$this->view('users/userpage');
		home::unsetSearch();
	}
}