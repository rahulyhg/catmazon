<?php

class order extends Controller {
	public function index () {

		$this->view('users/orders');
		home::unsetSearch();
	}
}