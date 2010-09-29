<?php
class Usermodel extends Model {
	function Usermodel() {
		parent::Model();
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
		
		foreach ($query as $field) {
			$fields[(string)$fieldMap[$field['field_id']]['slug']] = $field['data'];
		}
		
		return $fields;
	}
}