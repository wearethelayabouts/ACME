<?php
class Contentmodel extends Model {
	function Contentmodel() {
		parent::Model();
	}
	
	function fetchNews($userfields) {
		$this->load->model('usermodel');
		$query = $this->db->get('news');
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		$result = Array();
		
		foreach($query as $row) {
			$user = $this->usermodel->fetchUser($row['poster_id'], $userfields);
			$result[] = Array('entry' => $row, 'poster' => $user);
		}
		
		return $result;
	}	
}