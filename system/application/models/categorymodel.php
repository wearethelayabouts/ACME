<?php
class Categorymodel extends Model {
	function Categorymodel() {
		parent::Model();
	}
	
	function fetchCategory($cid) {
		$query = $this->db->get_where('categories', array('id' => $cid));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		return $query;
	}
	function fetchTree($cid) {
		$query = $this->db->get_where('categories', array('id' => $cid));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		$data['cat-'.$query['id']] = $query;
		
		if ($query['parent_id'] != 0) {
			$data = $this->fetchParentCategory($query['parent_id'], $data);
		}
		
		return array_reverse($data);
	}
	private function fetchParentCategory($cid, $data) {
		$query = $this->db->get_where('categories', array('id' => $cid));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		$nData = $data;
		$nData['cat-'.$query['id']] = $query;
		
		if ($query['parent_id'] != 0) {
			$data = $this->fetchParentCategory($query['parent_id'], $data);
		}
		
		return $nData;
	}
}