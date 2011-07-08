<?php
class Usermodel extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function fetchUserFields() {
		$query = $this->db->get('userfields');
		$query = $query->result_array();
		
		foreach ($query as $field) {
			$fields[$field['id']] = $field;
		}
		
		return $fields;
	}
	
	function fetchUser($uid, $fieldMap) {
		$query = $this->db->get_where('userdata', array('user_id' => $uid));
		
		if ($query->num_rows() == 0) {
			return false;
		}
		
		$query = $query->result_array();
		
		$fields['id'] = $uid;
		
		foreach ($query as $field) {
			$fields[(string)$fieldMap[$field['field_id']]['slug']] = $field['data'];
		}
		
		return $fields;
	}
}