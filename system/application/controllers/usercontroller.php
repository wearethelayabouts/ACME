<?php

class Usercontroller extends Controller {

	function Usercontroller() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
	}
	
	function view() {
		$config = $this->systemmodel->fetchConfig();
		$this->output->cache($this->config->item('cache_length'));
		
		$object = substr($this->uri->segment(1), 1);
		$userFields = $this->usermodel->fetchUserFields();
		$user = $this->usermodel->fetchUser($object, $userFields);
		
		if (!$user) {
			//show_404('');
		}
		
		$data = Array('user' => (Array) $user);
		$this->load->view($config['templategroup'].'_user_view', $data);
	}
	
	function forumprofile() {
		$config = $this->systemmodel->fetchConfig();
		$object = $this->uri->segment(2);
		$userFields = $this->usermodel->fetchUserFields();
		$user = $this->usermodel->fetchUser($object, $userFields);
		$url = $this->config->item('forum_url') . "/" . $this->config->item('forum_profile_link_pre') . $user['id'] . $this->config->item('forum_profile_link_post');
		header('Location: ' . $url);
	}
}