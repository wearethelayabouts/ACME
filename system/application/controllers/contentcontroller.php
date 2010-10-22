<?php
class Contentcontroller extends Controller {
	function Contentcontroller() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
	}
	
	function view() {
		$config = $this->systemmodel->fetchConfig();
		$userFields = $this->usermodel->fetchUserFields();
		$news = $this->contentmodel->fetchNews($userFields);
		
		$data = Array(
					'news' => $news
				);
		$this->load->view($config['templategroup'].'_contentpage', $data);
	}
}