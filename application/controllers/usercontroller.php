<?php

class Usercontroller extends CI_Controller {
	function __construct() {
		parent::__construct();
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
		
		$acmeconfig = $this->systemmodel->fetchConfig();
		if (isset($acmeconfig['sitemessage'])) {
			if ($acmeconfig['sitemessage'] != "") $sitemessage = $acmeconfig['sitemessage'];
			else $sitemessage = false;
		} else $sitemessage = false;
		
		$data = Array(
			'user' => (Array) $user,
			'sitemessage' => $sitemessage
		);
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