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
		
		if ($query['published'] != 0) return $query;
		else return false;
	}
	
	function fetchCategoryList($alphasort = true) {
		
		if ($alphasort) $this->db->order_by('name', 'asc');
		
		$query = $this->db->get('categories');
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		
		//print_r($query);
		
		$categories = Array();
		foreach ($query as $category) {
			$categories[$category['id']] = $category['name'];
		}
		
		return $categories;
	}
	
	function fetchCategorySlug($slug) {
		$query = $this->db->get_where('categories', array('slug' => $slug));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		if ($query['published'] != 0) return $query;
		else return false;
	}
	function fetchChildrenCategories($cid) {
		$this->db->order_by('listPriority', 'desc'); 
		$this->db->order_by('name', 'asc'); 
		$query = $this->db->get_where('categories', array('parent_id' => $cid));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		
		$i = 0;
		while ($i < count($query)) {
			if ($query[$i]['published'] == 0) unset($query[$i]);
			else $i++;
		}
		
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
			if ($category['is_hub'] == '1') {
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
	function fetchDefaultThumbnail($cid) {
		$this->db->where('id',$cid);
		$category = $this->db->get('categories');
		$category = $category->row_array();
		if (isset($category['default_content_thumbnail'])) return $category['default_content_thumbnail'];
		else return 0;
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