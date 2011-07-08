<?php
class Contentcontroller extends CI_Controller {
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
		$baseurl = $this->config->item('base_url');
		
		$addondomain = $this->categorymodel->fetchAddonDomain($this->uri->segment(2));
		
		if (($_SERVER['HTTP_HOST'] == substr($addondomain,7)) || (!$addondomain)) {
			$this->output->cache($this->config->item('cache_length'));
			
			$content = $this->contentmodel->fetchContentBySlug($this->uri->segment(2), $this->uri->segment(3));
			if (!$content) {
				show_404('');
			}
			
			$near = $this->contentmodel->fetchContentNear($content);
			
			$links = $this->systemmodel->fetchLinks();
			
			$acmeconfig = $this->systemmodel->fetchConfig();
			if (isset($acmeconfig['sitemessage'])) {
				if ($acmeconfig['sitemessage'] != "") $sitemessage = $acmeconfig['sitemessage'];
				else $sitemessage = false;
			} else $sitemessage = false;
			
			$data = Array(
						'links' => $links,
						'content' => $content,
						'near' => $near,
						'sitemessage' => $sitemessage
					);
			
			$template = $this->categorymodel->fetchCategoryContentTemplate($content['category_id']);
			
			if ($template) $this->load->view($template, $data);
			else $this->load->view($config['templategroup'].'_content_generic', $data);
		} else {
			$header = 'Location: ';
			$header .= $addondomain;
			if (substr($header, -1) != "/") $header .= "/"; 
			header($header);
		}
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
		
		foreach($content as $k=>$v) {
			$b[$k] = $v['date'];
		}
		asort($b);
		foreach($b as $key=>$val) {
			$c[] = $content[$key];
		}
		$content = $c;
		
		$data = Array(
					'links' => $links,
					'category' => $category,
					'content' => $content,
				);
		$this->load->view($config['templategroup'].'_playallpage', $data);
	}
}
