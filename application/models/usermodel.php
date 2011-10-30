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
	
	function fetchUserField($id) {
	    $query = $this->db->get_where('userfields', array('id' => $id));
	    $query = $query->result_array();
	    
	    return $query[0];
	}

    function fetchUsers($fieldMap, $fieldData = 0) {
    	$query = $this->db->get('userdata');
    	
    	if ($query->num_rows() == 0) {
    		return false;
    	}
    	
    	$query = $query->result_array();
    	
    	foreach ($query as $field) {
    	    if ($fieldData == 1) {
    		    $fields[$field['user_id']][(string)$fieldMap[$field['field_id']]['slug']] = Array(
        		                'data' => $field['data'],
        		                'metadata' => $fieldMap[$field['field_id']['slug']]
        		            );
        	} else {
        	    $fields[$field['user_id']][(string)$fieldMap[$field['field_id']]['slug']] = $field['data'];
        	}
    	}
    	
    	ksort($fields);
    	
    	return $fields;
    }
	
	function fetchUser($uid, $fieldMap, $fieldData = 0, $fillBlanks = 0) {
		$query = $this->db->get_where('userdata', array('user_id' => $uid));
		
		if ($query->num_rows() == 0) {
			return false;
		}
		
		$query = $query->result_array();
		
		foreach ($query as $field) {
			if ($fieldData == 1) {
			    $fields[(string)$fieldMap[$field['field_id']]['slug']] = Array(
				                'data' => $field['data'],
				                'metadata' => $fieldMap[$field['field_id']['slug']]
				            );
			} else {
			    $fields[(string)$fieldMap[$field['field_id']]['slug']] = $field['data'];
			}
		}
		
		if ($fillBlanks == 1) {
		    foreach ($fieldMap as $field) {
		        if (isset($fields[$field['slug']])) {
		            if ($fieldData == 1) {
		                 $data['fields'][$field['slug']] = Array(
		                                'data' => $fields[$field['slug']]['data'],
		                                'metadata' => $field
		                            );
		            } else {
		                $data['fields'][$field['slug']] = $fields[$field['slug']];
		            }
		        } else {
		            if ($fieldData == 1) {
		                 $data['fields'][$field['slug']] = Array(
		                                'data' => "",
		                                'metadata' => $field
		                            );
		            } else {
		                $data['fields'][$field['slug']] = "";
		            }
		        }
		    }
		} else {
		    $data['fields'] = $fields;
		}
		
		$data['id'] = $uid;
		
		return $data;
	}
}