<?php
class Systemmodel extends Model {
	function Systemmodel() {
		parent::Model();
		$this->load->model('categorymodel');
	}
	
	function fetchConfig() {
		$query = $this->db->get('configuration');
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		$result = Array();
		
		foreach($query as $row) {
			$result[$row['key']] = $row['value'];
		}
		
		return $result;
	}
	
	function fetchLinks() {
		$query = $this->db->get('links');
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		
		foreach ($query as $link) {
			$tlink = $link;
			switch ($link['link_type']) {
				case '1': // Category
					$category = $this->categorymodel->fetchCategory($link['objectid']);
					if (!$category) {
						// Bad link, ignore it.
					} else {
						$tlink['url'] = '/content/'.$category['slug'].'/';
						$pquery[] = $tlink;
					}
					break;
				case '2': // Content
					break;
				case '3': // Comment
					break;
				default: // Everything else
					$pquery[] = $tlink;
					break;
			}
		}
		
		foreach ($pquery as $link) {
			if ($link['major'] == '1') {
				$links['major'][] = $link;
			} else {
				$links['minor'][] = $link;
			}
		}
		
		$links['all'] = $query;
		
		return $links;
	}
}