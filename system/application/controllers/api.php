<?php

class Api extends Controller {

	function Api() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('categorymodel');
		$this->load->model('contentmodel');
	}
	
	function user_info() {
		$variables = explode('.', $this->uri->segment(5));
		$format = $variables[1];
		$object = $this->uri->segment(4);
		
		$userFields = $this->usermodel->fetchUserFields();
		$user = $this->usermodel->fetchUser($object, $userFields);
		
		if (!$user) {
			show_404('');
		}
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($user);
				break;
			case 'php':
				header('Content-type: text/plain');
				echo serialize($user);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($user);
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function category_info() {
		$variables = explode('.', $this->uri->segment(5));
		$format = $variables[1];
		$object = $this->uri->segment(4);
		
		$category = $this->categorymodel->fetchCategoryBySlug($object);
		
		if (!$category) {
			show_404('');
		}
		
		$tree = $this->categorymodel->fetchTree($object);
		
		$data = Array('category' => $category, 'tree' => $tree);
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($data);
				break;
			case 'php':
				header('Content-type: text/plain');
				echo serialize($data);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($data);
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function file() {
		$file = $this->uri->segment(4);
		
		$query = $this->db->get_where('files', array('id' => $file));
		
		if ($query->num_rows() == 0) {
			show_404('');
		}
		
		$query = $query->row_array();
		
		header('Content-type: '.$query['type']);
		if ($this->uri->segment(5) == "download") {
			if ($query['name'] != "") {
				header('Content-Disposition: attachment; filename="'.$query['name'].'"');
			} else {
				header('Content-Disposition: attachment');
			}
		}
		header('Content-Length: '.filesize('./files/'.$query['id']));
		readfile('./files/'.$query['id']);
	}
	
	function content_featured() {
		$variables = explode('.', $this->uri->segment(4));
		$format = $variables[1];
		
		$content = $this->contentmodel->fetchFeaturedContent();
		
		if (!$content) {
			show_404('');
		}
		
		$data = Array('content' => $content);
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($data);
				break;
			case 'php':
				header('Content-type: text/plain');
				echo serialize($data);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($data);
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function content_downloadZip() {
		$category = $this->uri->segment(4);
		$category = $this->categorymodel->fetchCategorySlug($category);
		$categorycontent = $this->contentmodel->fetchContentByCategory($category['id']);
		
		if (!is_array($categorycontent)) {
			die();
		}
		
		$temporaryfile = sys_get_temp_dir().'/acmezip'.(time()+rand(11111,99999)).'.zip';
		$zip = new ZipArchive;
		$res = $zip->open($temporaryfile, ZipArchive::CREATE);
		
		foreach ($categorycontent as $content) {
			$f = $this->db->get_where('files', array('id' => $content['main_attachment']));
			$f = $f->row_array();
			if ($f['isDownloadable'] == 1) {
				$zip->addFile('./files/'.$f['id'], $f['name']);
			}
			$f = Array();
		}
		
		$zip->close();
		
		header('Content-Type: application/zip');
		header('Content-Length: '.filesize($temporaryfile));
		header('Content-Disposition: attachment; filename="'.$category['name'].'.zip"');
		readfile($temporaryfile);
		
		unlink($temporaryfile);
	}
}