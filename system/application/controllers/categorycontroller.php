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
		$pagestr = $this->uri->segment(4);
		$page = (int)$pagestr;
		
		if (!$category) {
			show_404();
		}
		$childrencategories = $this->categorymodel->fetchChildrenCategories($category['id']);
		$tree = $this->categorymodel->fetchTree($category['id']);
		$content = $this->contentmodel->fetchContentByCategory($category['id']);
		$config = $this->systemmodel->fetchConfig();
		$userFields = $this->usermodel->fetchUserFields();
		$links = $this->systemmodel->fetchLinks();
		
		if (!is_array($content)) {
			$content = (Array) Array();
		}
		
		if ($category['returnAllContent'] == 1 && is_array($childrencategories)) {
			foreach($childrencategories as $cat) {
				$c = $this->contentmodel->fetchContentByCategory($cat['id']);
				$subc = $this->categorymodel->fetchChildrenCategories($cat['id']);
				if (is_array($c)) {
					$content = array_merge($content, $c);
				}
				if (is_array($subc)) {
					foreach ($subc as $c) {
						$cont = 	$this->contentmodel->fetchContentByCategory($c['id']);
						$content = array_merge($cont, $content);
					}
				}
			}
		}
		
		uasort($content, 'cmp_content');
		
		if ($category['oldestFirst']) {
			$content = array_reverse($content);
		}

		$contentchunks = array_chunk($content,24);
		if (isset($page)) {
			if ($page < 1) $contentchunk = $contentchunks[0];
			else $contentchunk = $contentchunks[$page-1];
		} else $contentchunk = $contentchunks[0];
		$pagesamount = sizeof($contentchunks);
		
		
		$data = Array(
					'links' => $links,
					'category' => $category,
					'children' => $childrencategories,
					'content' => $contentchunk,
					'pagesamount' => $pagesamount,
					'tree' => $tree
				);
		
		$this->load->view($category['category_template'], $data);
	}
}