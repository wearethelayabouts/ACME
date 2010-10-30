<?php
class Contentmodel extends Model {
	function Contentmodel() {
		parent::Model();
		$this->load->model('categorymodel');
		$this->load->model('usermodel');
	}
	
	function fetchNews($userfields) {
		$this->db->limit(5);
		$this->load->model('usermodel');
		$this->db->order_by('date', 'desc'); 
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
		$query['body'] = nl2br($query['body']);
		
		if ($query['rating'] == "") {
			$query['rating'] = $query['hub']['rating'];
			$query['rating_description'] = $query['hub']['rating_description'];
		}
		
		$authors = $this->db->get_where('contentauthors', array('contentid' => $query['id']));
		$authors = $authors->result_array();
		$authorroles = $this->db->get('contentroles');
		$authorroles = $authorroles->result_array();
		$userFields = $this->usermodel->fetchUserFields();
		
		foreach ($authorroles as $role) {
			$roles[$role['id']] = $role;
		}
		
		foreach ($authors as $author) {
			$a['role'] = $roles[$author['role']];
			$a['user'] = $this->usermodel->fetchUser($author['user'], $userFields);
			$query['authors'][] = $a;
		}
		
		if ($query['votes_up'] == 0 && $query['votes_down'] == 0 && $query['votes_neutral'] == 0) {
			$query['ratingstars'] = 0;
		} else {
			$query['ratingstars'] = round((((($query['votes_up'] - $query['votes_down']) / ($query['votes_up'] + $query['votes_down'] + $query['votes_neutral'])) * 2) + 3), 0);
		}
		
		$query['file'] = $this->db->get_where('files', array('id' => $query['main_attachment']));
		$query['file'] = $query['file']->row_array();
		
		if (!isset($query['authors'])) {
			$query['authors'] = Array();
		}
		
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
	
	function fetchNewContent() {
		$this->db->limit(5);
		$this->db->order_by('date', 'desc'); 
		$query = $this->db->get('content');
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();		
		
		foreach ($query as $item) {
			$i = $item;
			$i['hub'] = $this->categorymodel->fetchCategoryHub($item['category_id']);
			$items[] = $i;
		}
		
		return $items;
	}
	
	function fetchContentByCategory($cid) {
		$queryr = $this->db->get_where('content', array('category_id' => $cid));
		if ($queryr->num_rows() == 0) {
			return false;
		}
		$queryr = $queryr->result_array();
		
		foreach ($queryr as $bit) {
			$query = $bit;
			$query['hub'] = $this->categorymodel->fetchCategoryHub($query['category_id']);
			$query['tree'] = $this->categorymodel->fetchTree($query['category_id']);
			$query['body'] = nl2br($bit['body']);
			
			if ($query['rating'] == "") {
				$query['rating'] = $query['hub']['rating'];
				$query['rating_description'] = $query['hub']['rating_description'];
			}
			
			$authors = $this->db->get_where('contentauthors', array('contentid' => $query['id']));
			$authors = $authors->result_array();
			$authorroles = $this->db->get('contentroles');
			$authorroles = $authorroles->result_array();
			$userFields = $this->usermodel->fetchUserFields();
				
			foreach ($authorroles as $role) {
				$roles[$role['id']] = $role;
			}
			
			foreach ($authors as $author) {
				$a['role'] = $roles[$author['role']];
				$a['user'] = $this->usermodel->fetchUser($author['user'], $userFields);
				$query['authors'][] = $a;
			}
			
			if ($query['votes_up'] == 0 && $query['votes_down'] == 0 && $query['votes_neutral'] == 0) {
				$query['ratingstars'] = 0;
			} else {
				$query['ratingstars'] = round((((($query['votes_up'] - $query['votes_down']) / ($query['votes_up'] + $query['votes_down'] + $query['votes_neutral'])) * 2) + 3), 0);
			}
			
			$query['file'] = $this->db->get_where('files', array('id' => $query['main_attachment']));
			$query['file'] = $query['file']->row_array();
			
			$bits[] = $query;
		}
		
		return $bits;
	}
}