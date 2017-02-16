<?php

class order extends Controller {
	public function index () {

		$this->view('users/checkout');
		home::unsetSearch();
	}
}