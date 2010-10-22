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
		$content = $this->contentmodel->fetchContentBySlug($this->uri->segment(2), $this->uri->segment(3));
		if (!$content) {
			show_404('');
		}
		
		$config = $this->systemmodel->fetchConfig();
		$userFields = $this->usermodel->fetchUserFields();
		$links = $this->systemmodel->fetchLinks();
		
		$data = Array(
					'links' => $links,
					'content' => $content,
				);
		$this->load->view($config['templategroup'].'_contentpage', $data);
	}
}