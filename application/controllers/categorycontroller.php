<?php
class Categorycontroller extends CI_Controller {
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
		$baseurl = $this->config->item('base_url');
		$basehost = parse_url($baseurl);
		$basehost = str_replace('www.', '', $basehost['host']);
		$addondomain = $this->categorymodel->fetchAddonDomain($this->uri->segment(2));
		$cachelength = $this->config->item('cache_length');
		if (($cachelength >= 1) && ($addondomain == false)) $this->output->cache($cachelength);
		
		if ($basehost != $_SERVER['HTTP_HOST'] or 'www.'.$basehost != $_SERVER['HTTP_HOST']) {
			if (($_SERVER['HTTP_HOST'] !== substr($addondomain,7)) && $addondomain !== false) {
				header('Location: '.$addondomain);
				die();
			}
		} 
	
		$category = $this->categorymodel->fetchCategorySlug($this->uri->segment(2));
		
		$sort = $this->uri->segment(3);
		if ($sort == "sortasc") {
			$sortasc = true;
			$manualsort = true;
		} else if ($sort == "sortdesc") {
			$sortasc = false;
			$manualsort = true;
		} else if ($category['oldest_first']) {
			$sortasc = true;
			$manualsort = false;
		} else {
			$sortasc = false;
			$manualsort = false;
		}
		
		$pagestr = $this->uri->segment(4);
		$page = (int)$pagestr;
		
		if (!$category) {
			show_404();
		}
		$childrencategories = $this->categorymodel->fetchChildrenCategories($category['id']);
		$tree = $this->categorymodel->fetchTree($category['id']);
		$content = $this->contentmodel->fetchContentRowsByCategory($category['id'],0,0);
		$userFields = $this->usermodel->fetchUserFields();
		$hub = $this->categorymodel->fetchCategoryHub($category['id']);
		
		if (!is_array($content)) {
			$content = (Array) Array();
		}
		
		if ($category['return_all_content'] == 1 && is_array($childrencategories)) {
			foreach($childrencategories as $cat) {
				$c = $this->contentmodel->fetchContentRowsByCategory($cat['id']);
				$subc = $this->categorymodel->fetchChildrenCategories($cat['id']);
				if (is_array($c)) {
					$content = array_merge($content, $c);
				}
				if (is_array($subc)) {
					foreach ($subc as $c) {
						$cont = $this->contentmodel->fetchContentRowsByCategory($c['id']);
						if (!is_array($cont)) {
							$cont = (Array) Array();
						}
						$content = array_merge($cont, $content);
					}
				}
			}
		}
		
		uasort($content, 'cmp_content');
		
		if ($sortasc) {
			$content = array_reverse($content);
		}

		if ($this->config->item('paginate') == true) {
			if (count($content) > 0) {
				$contentchunks = array_chunk($content,24);
				if (isset($page)) {
					if ($page < 1) $page = 1;
					$contentchunk = $contentchunks[$page-1];
				} else $contentchunk = $contentchunks[0];
				$pagesamount = sizeof($contentchunks);
			} else { 
				$contentchunk = 0;
				$pagesamount = 0;
			}
			$contentchunk = $this->contentmodel->processContentRows($contentchunk, true);
		} else $contentchunk = $this->contentmodel->processContentRows($content, true);
		
		
		$acmeconfig = $this->systemmodel->fetchConfig();
		if (isset($acmeconfig['sitemessage'])) {
			if ($acmeconfig['sitemessage'] != "") $sitemessage = $acmeconfig['sitemessage'];
			else $sitemessage = false;
		} else $sitemessage = false;
		
		$data = Array(
					'category' => $category,
					'children' => $childrencategories,
					'content' => $contentchunk,
					'page' => $page,
					'pagesamount' => $pagesamount,
					'tree' => $tree,
					'hub' => $hub,
					'sortasc' => $sortasc,
					'manualsort' => $manualsort,
					'sitemessage' => $sitemessage,
					'baseurl' => $baseurl
				);
		
		if (strlen($category['category_template']) >= 2) $this->load->view($category['category_template'], $data);
		else $this->load->view($config['templategroup']."_category_generic", $data);
	}
}
