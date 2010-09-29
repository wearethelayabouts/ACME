<?php

class User extends Controller {

	function User() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
	}
	
	function view() {
		$object = substr($this->uri->segment(1), 1);
		$userFields = $this->usermodel->fetchUserFields();
		$user = $this->usermodel->fetchUser($object, $userFields);
		
		if (!$user) {
			show_404('');
		}
		
		$data = Array('user' => (Array) $user);
		$this->load->view('brighthorizon_user_view', $data);
	}
}