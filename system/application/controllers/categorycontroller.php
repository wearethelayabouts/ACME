<?php

class Categorycontroller extends Controller {
	function Categorycontroller() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
		$this->load->model('categorymodel');
	}
	
	function view() {
		$category = $this->categorymodel->fetchCategorySlug($this->uri->segment(2));
		
		if (!$category) {
			show_404();
		}
		$childrencategories = $this->categorymodel->fetchChildrenCategories($category['id']);
		$content = $this->contentmodel->fetchContentByCategory($category['id']);
		$config = $this->systemmodel->fetchConfig();
		$userFields = $this->usermodel->fetchUserFields();
		$links = $this->systemmodel->fetchLinks();
		
		if (!is_array($content)) {
			$content = Array();
		}
		
		if ($category['returnAllContent'] == 1) {
			foreach($childrencategories as $cat) {
				$c = $this->contentmodel->fetchContentByCategory($cat['id']);
				$content = array_merge($content, $c);
			}
		}
		
		$data = Array(
					'links' => $links,
					'category' => $category,
					'children' => $childrencategories,
					'content' => $content
				);
		$this->load->view($category['category_template'], $data);
	}
}