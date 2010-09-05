<?php

class User extends Controller {

	function User() {
		parent::Controller();	
	}
	
	function view() {
		$this->load->view('user_view');
	}
}