<?php

class Api extends Controller {

	function Api() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('categorymodel');
	}
	
	function user_info() {
		$variables = split('_', $this->uri->segment(4));
		$format = $variables[1];
		$object = substr($this->uri->segment(3), 1);
		
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
		$variables = split('_', $this->uri->segment(4));
		$format = $variables[1];
		$object = substr($this->uri->segment(3), 1);
		
		$category = $this->categorymodel->fetchCategory($object);
		
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
			//show_404('');
		}
		
		$query = $query->row_array();
		
		header('Content-type: '.$query['type']);
		echo $query['content'];
	}
}