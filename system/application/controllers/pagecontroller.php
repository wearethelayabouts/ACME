<?php

class Pagecontroller extends Controller {
	function Pagecontroller() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
		$this->load->model('categorymodel');
	}
	
	function view() {
		$config = $this->systemmodel->fetchConfig();
		$this->output->cache($this->config->item('cache_length'));
		
		$page = $this->systemmodel->fetchPage($this->uri->segment(2));
		if (!$page) {
			show_404();
		}
		$links = $this->systemmodel->fetchLinks();
		
		$acmeconfig = $this->systemmodel->fetchConfig();
		if (isset($acmeconfig['sitemessage'])) {
			if ($acmeconfig['sitemessage'] != "") $sitemessage = $acmeconfig['sitemessage'];
			else $sitemessage = false;
		} else $sitemessage = false;
		
		$data = Array(
					'links' => $links,
					'page' => $page['content'],
					'css' => $page['custom_css'],
					'sitemessage' => $sitemessage
				);
		$this->load->view($config['templategroup'].'_page', $data);
	}
}