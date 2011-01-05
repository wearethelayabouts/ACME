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
	function fetchCategorySlug($slug) {
		$query = $this->db->get_where('categories', array('slug' => $slug));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		return $query;
	}
	function fetchChildrenCategories($cid) {
		$this->db->order_by('listPriority', 'desc');
		$this->db->order_by('name', 'asc'); 
		$query = $this->db->get_where('categories', array('parent_id' => $cid));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		
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
	function fetchCategoryHub($cid) {
		$tree = $this->fetchTree($cid);
		
		if (!$tree) {
			return false;
		}
		
		$tree = array_reverse($tree);
		foreach ($tree as $category) {
			if ($category['isHub'] == '1') {
				$hub = $category;
				break;
			}
		}
		if (isset($hub)) {
			return $hub;
		} else {
			return false;
		}
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
			$nData = $this->fetchParentCategory($query['parent_id'], $nData);
		}
		
		return $nData;
	}
}