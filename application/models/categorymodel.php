<?php
class Categorymodel extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function fetchCategory($cid, $ignorePublished = false) {
		$query = $this->db->get_where('categories', array('id' => $cid));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		if ($query['published'] != 0 || $ignorePublished !== false) return $query;
		else return false;
	}
	
	function fetchCategoryList($alphasort = true, $fetchData = false) {
		
		if ($alphasort) $this->db->order_by('name', 'asc');
		else $this->db->order_by('id', 'asc');
		
		$query = $this->db->get('categories');
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		
		//print_r($query);
		
		$categories = Array();
		foreach ($query as $category) {
		if (!$fetchData) 
			$categories[$category['id']] = $category['name'];
			
			if ($fetchData)
			$categories[$category['id']] = $category;
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
	
	function fetchAddonDomain($slug) {
		$query = $this->db->get_where('categories', array('slug' => $slug));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		if (($query['published'] != 0) && (substr($query['addon_domain'],0,7) == "http://")) return $query['addon_domain'];
		else return false;
	}
	
	function fetchChildrenCategories($cid) {
		$this->db->order_by('list_priority', 'desc'); 
		$this->db->order_by('date', 'desc');
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
	function fetchCategoryContentTemplate($cid) {
		$template = false;
		
		$query = $this->db->get_where('categories', array('id' => $cid));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		if (strlen($query['content_template']) >= 2) $template = $query['content_template'];
		
		while (!$template) {
			if ($query['parent_id'] > 0) {
				$query = $this->fetchCategory($query['parent_id']);
				if (strlen($query['content_template']) >= 2) $template = $query['content_template'];
			} else break;
		}
		
		return $template;
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
	
	function fetchCategoryShowType($cid) {
		$showonly = $this->db->get_where('categories', array('id' => $cid));
		$showonly = $showonly->row_array();
		return $showonly['only_show'];
	}
	
	function fetchCategoryLatestID($cid) {
		$this->db->select('max(date)');
		$this->db->where('category_id',$cid);
		$query = $this->db->get('content');
		$query = $query->row_array();
		$date = $query['max(date)'];
		$this->db->select('id,date');
		$query = $this->db->get_where('content', array('category_id' => $cid, 'date' => $date));
		$query = $query->row_array();
		return $query['id'];
	}
	
	function fetchCategoryFirstID($cid) {
		$this->db->select('min(date)');
		$this->db->where('category_id',$cid);
		$query = $this->db->get('content');
		$query = $query->row_array();
		$date = $query['min(date)'];
		$this->db->select('id,date');
		$query = $this->db->get_where('content', array('category_id' => $cid, 'date' => $date));
		$query = $query->row_array();
		return $query['id'];
	}
	
}