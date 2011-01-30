<?php

class Welcome extends Controller {
	function Welcome() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
	}
	
	function index() {
		$config = $this->systemmodel->fetchConfig();
		$this->output->cache($this->config->item('cache_length'));
		
		$userFields = $this->usermodel->fetchUserFields();
		$news = $this->contentmodel->fetchNews($userFields);
		$links = $this->systemmodel->fetchLinks();
		$newcontent = $this->contentmodel->fetchNewContent($this->config->item('frontpage_content_amount'));
		
		$data = Array(
					'news' => $news,
					'links' => $links,
					'content' => $newcontent
				);
		$this->load->view($config['templategroup'].'_frontpage', $data);
	}
}