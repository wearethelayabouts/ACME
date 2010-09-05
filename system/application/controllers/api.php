<?php

class Api extends Controller {

	function Api() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
	}
	
	function user_fetch() {
		$variables = split('_', $this->uri->segment(4));
		$format = $variables[1];
		$uid = $variables[0];
		
		$userFields = $this->acmedata->fetchUserFields();
		$user = $this->acmedata->fetchUser($uid, $userFields);
		
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
}