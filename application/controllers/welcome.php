<?php

class Welcome extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}
	
	function index() {
		$config = $this->systemmodel->fetchConfig();
		$cachelength = $this->config->item('cache_length');
		if ($cachelength >= 1) $this->output->cache($cachelength);
		
		$userFields = $this->usermodel->fetchUserFields();
		$news = $this->contentmodel->fetchNews($userFields);
		$links = $this->systemmodel->fetchLinks();
		if ($this->config->item('new_content_near') == true) {
			$newcontent = $this->contentmodel->fetchNewContent($this->config->item('frontpage_content_amount'));
			$content = Array();
			foreach ($newcontent as $piece) {
				$piece['near'] = $this->contentmodel->fetchContentNear($piece);
				$content[] = $piece;
			}
		} else $content = $this->contentmodel->fetchNewContent($this->config->item('frontpage_content_amount'));

		if (isset($config['sitemessage'])) {
			if ($config['sitemessage'] != "") $sitemessage = $config['sitemessage'];
			else $sitemessage = false;
		} else $sitemessage = false;
		
		$data = Array(
					'news' => $news,
					'links' => $links,
					'content' => $content,
					'sitemessage' => $sitemessage
				);
		$this->load->view($config['templategroup'].'_frontpage', $data);
	}
}