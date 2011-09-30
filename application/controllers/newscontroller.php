<?php

class Newscontroller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
	}
	
	function view() {
		$config = $this->systemmodel->fetchConfig();
		$cachelength = $this->config->item('cache_length');
		if ($cachelength >= 1) $this->output->cache($cachelength);
		
		$userFields = $this->usermodel->fetchUserFields();
		$news = $this->contentmodel->fetchNews($userFields);
		
		$links = $this->systemmodel->fetchLinks();
		
		$acmeconfig = $this->systemmodel->fetchConfig();
		if (isset($acmeconfig['sitemessage'])) {
			if ($acmeconfig['sitemessage'] != "") $sitemessage = $acmeconfig['sitemessage'];
			else $sitemessage = false;
		} else $sitemessage = false;
		
		$data = Array(
					'news' => $news,
					'links' => $links,
					'sitemessage' => $sitemessage
				);
		
		$this->load->view($config['templategroup'].'_news', $data);
	}
	
	function single() {
		$config = $this->systemmodel->fetchConfig();
		$this->output->cache($this->config->item('cache_length'));
		
		$news_id = $this->uri->segment(2);
		
		$userFields = $this->usermodel->fetchUserFields();
		
		$news = $this->contentmodel->fetchSingleNews($news_id,$userFields);
		
		if (!$news) {
			show_404('');
		}
		
		$links = $this->systemmodel->fetchLinks();
		
		$acmeconfig = $this->systemmodel->fetchConfig();
		if (isset($acmeconfig['sitemessage'])) {
			if ($acmeconfig['sitemessage'] != "") $sitemessage = $acmeconfig['sitemessage'];
			else $sitemessage = false;
		} else $sitemessage = false;
		
		$data = Array(
					'news' => $news,
					'links' => $links,
					'sitemessage' => $sitemessage
				);
		
		$this->load->view($config['templategroup'].'_singlenews', $data);
	}
}