<?php

class Welcome extends CI_Controller {
	function __construct() {
		parent::__construct();
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
		
		
		$acmeconfig = $this->systemmodel->fetchConfig();
		if (isset($acmeconfig['sitemessage'])) {
			if ($acmeconfig['sitemessage'] != "") $sitemessage = $acmeconfig['sitemessage'];
			else $sitemessage = false;
		} else $sitemessage = false;
		
		$data = Array(
					'news' => $news,
					'links' => $links,
					'content' => $newcontent,
					'sitemessage' => $sitemessage
				);
		$this->load->view($config['templategroup'].'_frontpage', $data);
	}
}