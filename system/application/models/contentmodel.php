<?php
class Contentmodel extends Model {
	function Contentmodel() {
		parent::Model();
		$this->load->model('categorymodel');
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
	
	function fetchContentBySlug($hubslug, $slug) {
		$query = $this->db->get_where('content', array('hub_slug' => $hubslug, 'slug' => $slug));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		$query['hub'] = $this->categorymodel->fetchCategoryHub($query['category_id']);
		$query['tree'] = $this->categorymodel->fetchTree($query['category_id']);
		
		return $query;
	}
	
	function fetchFeaturedContent() {
		$query = $this->db->get_where('content', array('featured_status' => '1'));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		
		foreach ($query as $content) {
			$data[] = Array(
						'slug' => $content['slug'],
						'featured_image' => $content['featured_image'],
						'hub_slug' => $content['hub_slug'],
						'name' => $content['name'],
						'featured_prefix' => $content['featured_prefix']
						);
		}			
		
		return $data;
	}
}