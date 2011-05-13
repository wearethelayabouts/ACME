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
	
		$this->db->order_by('list_priority', 'desc'); 
		$this->db->order_by('id', 'asc');
		
		$query = $this->db->get('links');
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->result_array();
		
		foreach ($query as $link) {
			$tlink = $link;
			switch ($link['link_type']) {
				case '0': // URL
					$pquery[] = $tlink;
					break;
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
					// Not supported at the moment
					break;
				case '3': // Comment
					// Not supported at the moment
					break;
				default: // Silently ignore the link
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
	
	function fetchPage($slug) {
		$query = $this->db->get_where('pages', array('slug' => $slug));
		if ($query->num_rows() == 0) {
			return false;
		}
		$query = $query->row_array();
		
		return $query;
	}
	
	function paginate($page,$pagesamount,$urlprepend,$urlappend="") {
		$paginationhtml = "";
		if ($pagesamount > 1) {
			$paginationhtml .= "<div class=\"page-select\">";
			if ($page > 1) { 
				$paginationhtml .= "<a href=\"";
				$paginationhtml .= $urlprepend;
				$paginationhtml .= "1";
				$paginationhtml .= $urlappend;
				$paginationhtml .= "\">&laquo;First</a> <a href=\"";
				$paginationhtml .= $urlprepend;
				$paginationhtml .= $page-1;
				$paginationhtml .= $urlappend;
				$paginationhtml .= "\">&lt;Previous</a>";
			} else {
				$paginationhtml .= "&laquo;First &lt;Previous";
			}
			
			$paginationhtml .= " ";
			
			if ($pagesamount <= 5) {
				for ($i=1; $i<=$pagesamount; $i++) {
					if ($i == $page) $paginationhtml .= "<span class=\"currentpage\">";
					else {
						$paginationhtml .= "<a href=\"";
						$paginationhtml .= $urlprepend;
						$paginationhtml .= $i;
						$paginationhtml .= $urlappend;
						$paginationhtml .= "\">";
					}
					$paginationhtml .= $i;
					if ($i == $page) $paginationhtml .= "</span>";
					else $paginationhtml .= "</a>";
					if ($i < $pagesamount) $paginationhtml .= " ";
				}
			} else {
				
				if (($page-2 >= 1) && ($page+2 <= $pagesamount)) {
					$pagemin = $page-2;
					$pagemax = $page+2;
				} else if (($page-1 >= 1) && ($page+3 <= $pagesamount)) {
					$pagemin = $page-1;
					$pagemax = $page+3;
				} else if (($page >= 1) && ($page+4 <= $pagesamount)) {
					$pagemin = $page;
					$pagemax = $page+4;
				} else if (($page-3 >= 1) && ($page+1 <= $pagesamount)) {
					$pagemin = $page-3;
					$pagemax = $page+1;
				} else if (($page-4 >= 1) && ($page <= $pagesamount)) {
					$pagemin = $page-4;
					$pagemax = $page;
				}
			
				if ($pagemin > 1) $paginationhtml .= "&hellip; ";
				
				for ($i=$pagemin; $i<=$pagemax; $i++) {
					if ($i == $page) $paginationhtml .= "<span class=\"currentpage\">";
					else {
						$paginationhtml .= "<a href=\"";
						$paginationhtml .= $urlprepend;
						$paginationhtml .= $i;
						$paginationhtml .= $urlappend;
						$paginationhtml .= "\">";
					}
					$paginationhtml .= $i;
					if ($i == $page) $paginationhtml .= "</span> ";
					else $paginationhtml .= "</a> ";
				}
			
				if ($pagemax < $pagesamount) $paginationhtml .= "&hellip;";
			}

			$paginationhtml .= " ";
			
			if ($page < $pagesamount) { 
				$paginationhtml .= "<a href=\"";
				$paginationhtml .= $urlprepend;
				$paginationhtml .= $page+1;
				$paginationhtml .= $urlappend;
				$paginationhtml .= "\">Next&gt;</a> <a href=\"";
				$paginationhtml .= $urlprepend;
				$paginationhtml .= $pagesamount;
				$paginationhtml .= $urlappend;
				$paginationhtml .= "\">Last&raquo;</a>";
			} else {
				$paginationhtml .= "Next&gt; Last&raquo;";
			}
			
			$paginationhtml .= "</div>";
			
		}
		return $paginationhtml;
	}
}