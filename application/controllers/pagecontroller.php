<?php

class Pagecontroller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
		$this->load->model('categorymodel');
		$this->load->model('playmodel');
	}
	
	function view() {
		$this->playmodel->loadAuth();
		$config = $this->systemmodel->fetchConfig();
		$cachelength = $this->config->item('cache_length');
		if ($cachelength >= 1) $this->output->cache($cachelength);
		
		$page = $this->systemmodel->fetchPage($this->uri->segment(2));
		if (!$page) {
			show_404();
		}
		
		$acmeconfig = $this->systemmodel->fetchConfig();
		if (isset($acmeconfig['sitemessage'])) {
			if ($acmeconfig['sitemessage'] != "") $sitemessage = $acmeconfig['sitemessage'];
			else $sitemessage = false;
		} else $sitemessage = false;
		
		$data = Array(
					'page' => $page['content'],
					'css' => $page['custom_css'],
					'title' => $page['title'],
					'sitemessage' => $sitemessage
				);
		$this->load->view($config['templategroup'].'_page', $data);
	}
}