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
		$page = $this->systemmodel->fetchPage($this->uri->segment(2));
		if (!$page) {
			show_404();
		}
		$config = $this->systemmodel->fetchConfig();
		$links = $this->systemmodel->fetchLinks();
		
		$data = Array(
					'links' => $links,
					'page' => $page['content']
				);
		$this->load->view($config['templategroup'].'_page', $data);
	}
}