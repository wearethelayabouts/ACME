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
		$this->output->cache(10);
		
		$content = $this->contentmodel->fetchContentBySlug($this->uri->segment(2), $this->uri->segment(3));
		if (!$content) {
			show_404('');
		}
		
		$near = $this->contentmodel->fetchContentNear($content);
		
		$config = $this->systemmodel->fetchConfig();
		$links = $this->systemmodel->fetchLinks();
		
		$data = Array(
					'links' => $links,
					'content' => $content,
					'near' => $near
				);
		$this->load->view($config['templategroup'].'_contentpage', $data);
	}
	function downloadzip() {
		$this->output->cache(10);
		
		$category = $this->uri->segment(2);
		$config = $this->systemmodel->fetchConfig();
		$links = $this->systemmodel->fetchLinks();
		
		$data = Array(
					'links' => $links,
					'category' => $category
				);
		$this->load->view($config['templategroup'].'_downloadzip', $data);
	}
	function playall() {
		$this->output->cache(10);
		
		$category = $this->categorymodel->fetchCategorySlug($this->uri->segment(2));
		
		if (!$category) {
			show_404('');
		}
		
		$content = $this->contentmodel->fetchContentByCategory($category['id']);
		
		$config = $this->systemmodel->fetchConfig();
		$links = $this->systemmodel->fetchLinks();
		
		if ($category['oldestFirst']) {
			$content = array_reverse($content);
		}
		
		$data = Array(
					'links' => $links,
					'category' => $category,
					'content' => $content,
				);
		$this->load->view($config['templategroup'].'_playallpage', $data);
	}
}
