<?php
class Contentmodel extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->model('categorymodel');
		$this->load->model('usermodel');
	}
	
	function fetchNews($userfields) {
		$this->db->limit(5);
		$this->load->model('usermodel');
		$this->db->order_by('date', 'desc'); 
		$query = $this->db->get_where('news', array('published' => 1));
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
	
	function fetchSingleNews($id,$userfields) {
		$this->db->limit(5);
		$this->load->model('usermodel');
		$this->db->order_by('date', 'desc'); 
		$query = $this->db->get_where('news', array('id' => $id, 'published' => 1));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		$user = $this->usermodel->fetchUser($query['poster_id'], $userfields);
		$result = Array('entry' => $query, 'poster' => $user);
		
		return $result;
	}
	
	function fetchContentBySlug($hubslug, $slug) {
		$query = $this->db->get_where('content', array('hub_slug' => $hubslug, 'slug' => $slug, 'date <' => time(), 'published !=' => 0));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		$query = $this->processContentRow($query);
		
		return $query;
	}
	
	function fetchContentByID($id) {
		$query = $this->db->get_where('content', array('id' => $id));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		$query = $this->processContentRow($query);
		
		return $query;
	}
	
	function fetchFeaturedContent() {
		$this->db->order_by('date', 'desc');
		$query = $this->db->get_where('content', array('featured_status' => '1', 'date <' => time(), 'published !=' => 0));
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
				'featured_name' => $content['featured_name']
			);
		}			
		
		return $data;
	}
	
	function fetchNewContent($limit,$filterlist=array()) {
		$this->db->order_by('date', 'desc');
	
		$filterlist['date <'] = time();
		
		$query = $this->db->get_where('content', $filterlist);

		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		
		$i = 0;
		$i2 = 0;
		while ($i2 < min($limit,count($query))) {
			if (($query[$i]['category_id'] > 0) && ($query[$i]['published'] != 0)) {
				$showtype = $this->categorymodel->fetchCategoryShowType($query[$i]['category_id']);
				if (($showtype == 0) || (($showtype == 1) && ($this->categorymodel->fetchCategoryFirstID($query[$i]['category_id']) == $query[$i]['id'])) || (($showtype == 2) && ($this->categorymodel->fetchCategoryLatestID($query[$i]['category_id']) == $query[$i]['id']))) {
					$i2++;
					$item = $query[$i];
					$item = $this->processContentRow($item, false);
					$items[] = $item;
				}
			}
			if ($i2 >= $limit) break;
			$i++;
		}
		
		return $items;
	}
	
	function countAllContent() {
		$query = $this->db->get('content');
		return $query->num_rows();
	}
	
	function fetchAllContent($sortby='date', $sortasc=false, $page=1, $pagesize=20) {
		if (($sortby != 'name') && ($sortby != 'cat')) {
			if ($sortasc) $sortorder = 'asc';
			else $sortorder = 'desc';
		} else {
			if ($sortasc) $sortorder = 'desc';
			else $sortorder = 'asc';
		}
		
		if ($sortby == 'date') $this->db->order_by('date', $sortorder);
		else if ($sortby == 'cat') $this->db->order_by('hub_slug', $sortorder);
		else if ($sortby == 'name') $this->db->order_by('name', $sortorder);
		else if ($sortby == 'id') $this->db->order_by('id', $sortorder);
		
		else $this->db->order_by('date', 'desc');
		
		$query = $this->db->get('content');

		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		$i = ($page-1)*$pagesize;
		while ($i < ($page)*$pagesize) {
			$item = $query[$i];
			$item = $this->processContentRow($item, false);	
			$items[] = $item;
			$i++;
		}
		
		return $items;
	}
	
	function fetchContentRowsByCategory($cid, $limit = 0, $showonly = -2) {
		if ($showonly == -2) $showonly = $this->categorymodel->fetchCategoryShowType($cid);
		
		if ($showonly == 0) {
			if ($limit != 0) $this->db->limit($limit[1], $limit[0]);
		} else $this->db->limit(1);
		
		if ($showonly == 1) $this->db->order_by('date', 'asc'); 
		else $this->db->order_by('date', 'desc');
		$queryr = $this->db->get_where('content', array('category_id' => $cid, 'date <' => time(), 'published !=' => 0));
		if ($queryr->num_rows() == 0) {
			return false;
		}
		$queryr = $queryr->result_array();
		
		return $queryr;
	}
	
	function processContentRows($queryr, $fetchBareMinimum = false) {
		if (!$this->config->item('optimize_category_listing')) $fetchBareMinimum = false;
		
		foreach ($queryr as $bit) {
			$bits[] = $this->processContentRow($bit, $fetchBareMinimum);
		}
		
		return $bits;
	}
	
	function processContentRow($queryr, $fetchBareMinimum = false) {
		$query = $queryr;
		$query['hub'] = $this->categorymodel->fetchCategoryHub($query['category_id']);
		if (!$fetchBareMinimum) $query['tree'] = $this->categorymodel->fetchTree($query['category_id']);
		$query['body'] = nl2br($query['body']);
		
		if ($query['rating'] == "" && !$fetchBareMinimum) {
			$query['rating'] = $query['hub']['rating'];
			$query['rating_description'] = $query['hub']['rating_description'];
		}
	
		if ($query['content_thumbnail'] < 1) {
			$query['content_thumbnail'] = $this->categorymodel->fetchDefaultThumbnail($query['category_id']);
		}
		
		$authors = $this->db->get_where('contentauthors', array('contentid' => $query['id']));
		$authors = $authors->result_array();
		
		if (!$fetchBareMinimum) {	
			$userFields = $this->usermodel->fetchUserFields();
			
			foreach ($authors as $author) {
				$a['role'] = $author['rolename'];
				$a['user'] = $this->usermodel->fetchUser($author['user'], $userFields);
				$a['show_icon'] = $author['show_icon'];
				$query['authors'][] = $a;
			}
		}
	
		if (!isset($query['authors'])) {
			$query['authors'] = Array();
		}
		
		if ($query['votes_up'] == 0 && $query['votes_down'] == 0 && $query['votes_neutral'] == 0) {
			$query['ratingstars'] = 0;
		} else {
			$query['ratingstars'] = round((((($query['votes_up'] - $query['votes_down']) / ($query['votes_up'] + $query['votes_down'] + $query['votes_neutral'])) * 2) + 3), 0);
		}
		
		if (!$fetchBareMinimum) $query['file'] = $this->db->get_where('files', array('id' => $query['main_attachment']));
		if (!$fetchBareMinimum) $query['file'] = $query['file']->row_array();
		
		return $query;
	}
		
	function fetchContentByCategory($cid, $limit = 0, $showonly = -2) {
		if ($showonly == -2) $showonly = $this->categorymodel->fetchCategoryShowType($cid);
		
		if ($showonly == 0) {
			if ($limit != 0) $this->db->limit($limit[1], $limit[0]);
		} else $this->db->limit(1);
		
		if ($showonly == 1) $this->db->order_by('date', 'asc'); 
		else $this->db->order_by('date', 'desc');
		$queryr = $this->db->get_where('content', array('category_id' => $cid, 'date <' => time(), 'published !=' => 0));
		if ($queryr->num_rows() == 0) {
			return false;
		}
		$queryr = $queryr->result_array();
		
		$process = $this->processContentRows($queryr);
		
		return $process;
	}
	function fetchContentNear($content) {
	
		$this->db->order_by('date', 'desc');
		$before = $this->db->get_where('content', array('date <' => min(time(),$content['date']), 'hub_slug' => $content['hub_slug']), 1);
		$before = $before->row_array();
		
		if (isset($before['published'])) if ($before['published'] != 1) while ($before['published'] != 1) {
			$this->db->order_by('date', 'desc');
			$beforeagain = $this->db->get_where('content', array('date <' => min(time(),$before['date']), 'hub_slug' => $content['hub_slug']), 1);
			$before = $beforeagain->row_array();
			if (!isset($before['published'])) break;
			if (!isset($before['date'])) break;
		}
		
		$this->db->order_by('date', 'asc');
		$after = $this->db->get_where('content', array('date >' => $content['date'], 'date <' => time(), 'published !=' => 0, 'hub_slug' => $content['hub_slug']), 1);
		$after = $after->row_array();
		
		if (isset($after['published'])) if ($after['published'] != 1) while ($after['published'] != 1) {			
			$this->db->order_by('date', 'desc');
			$afteragain = $this->db->get_where('content', array('date >' => $after['date'], 'date <' => time(), 'published !=' => 0, 'hub_slug' => $content['hub_slug']), 1);
			$after = $afteragain->row_array();
			if (!isset($after['published'])) break;
			if (!isset($after['date'])) break;
		}
		
		$this->db->where('hub_slug',$content['hub_slug']);
		$this->db->select_min('date');
		$firsttimestamp = $this->db->get_where('content', array('date <' => time()));
		$firsttimestamp = $firsttimestamp->row_array();
		
		$this->db->where('hub_slug',$content['hub_slug']);
		$this->db->select_max('date');
		$latesttimestamp = $this->db->get_where('content', array('date <' => time()));
		$latesttimestamp = $latesttimestamp->row_array();
		
		$first = $this->db->get_where('content', array('date' => $firsttimestamp['date'], 'hub_slug' => $content['hub_slug']), 1);
		$first = $first->row_array();
		$latest = $this->db->get_where('content', array('date' => $latesttimestamp['date'], 'hub_slug' => $content['hub_slug']), 1);
		$latest = $latest->row_array();
		
		$dct = 0;
		
		if ($first['content_thumbnail'] < 1) {
			if ($dct == 0) $dct = $this->categorymodel->fetchDefaultThumbnail($first['category_id']);
			$first['content_thumbnail'] = $dct;
		}
		if (isset($before['content_thumbnail'])) if ($before['content_thumbnail'] < 1) {
			if ($dct == 0) $dct = $this->categorymodel->fetchDefaultThumbnail($before['category_id']);
			$before['content_thumbnail'] = $dct;
		}
		if (isset($after['content_thumbnail'])) if ($after['content_thumbnail'] < 1) {
			if ($dct == 0) $dct = $this->categorymodel->fetchDefaultThumbnail($after['category_id']);
			$after['content_thumbnail'] = $dct;
		}
		if ($latest['content_thumbnail'] < 1) {
			if ($dct == 0) $dct = $this->categorymodel->fetchDefaultThumbnail($latest['category_id']);
			$latest['content_thumbnail'] = $dct;
		}
		
		return Array('after' => $after, 'before' => $before, 'first' => $first, 'latest' => $latest);
	}
}
