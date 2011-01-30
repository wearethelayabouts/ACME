<?php

class Newscontroller extends Controller {
	function Newscontroller() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
	}
	
	function view() {
		$this->output->cache(10);
		
		$specificpage = $this->uri->segment(2);
		if (!isset($specificpage)) $specificpage = 0;
		
		$config = $this->systemmodel->fetchConfig();
		$userFields = $this->usermodel->fetchUserFields();
		$news = $this->contentmodel->fetchNews($userFields);
		$links = $this->systemmodel->fetchLinks();
		
		$data = Array(
					'news' => $news,
					'links' => $links,
					'item' => $specificpage
				);
		
		if ($specificpage > 0) $this->load->view($config['templategroup'].'_singlenews', $data);
		else $this->load->view($config['templategroup'].'_news', $data);
	}
}