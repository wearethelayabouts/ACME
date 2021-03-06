<?php
class Api extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('categorymodel');
		$this->load->model('contentmodel');
		$this->load->model('systemmodel');
		$this->load->model('playmodel');
	}
	
	function user_info() {
		$variables = explode('.', $this->uri->segment(5));
		$format = $variables[1];
		$object = $this->uri->segment(4);
		
		$userFields = $this->usermodel->fetchUserFields();
		$user = $this->usermodel->fetchUser($object, $userFields);
		
		if (!$user) {
			show_404('');
		}
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($user);
				break;
			case 'sphp':
				header('Content-type: text/plain');
				echo serialize($user);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($user);
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function category_info() {
		$variables = explode('.', $this->uri->segment(5));
		$format = $variables[1];
		$object = $this->uri->segment(4);
		
		$category = $this->categorymodel->fetchCategorySlug($object);
		
		if (!$category) {
			show_404('');
		}
		
		$tree = $this->categorymodel->fetchTree($object);
		
		$data = Array('category' => $category, 'tree' => $tree);
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($data);
				break;
			case 'sphp':
				header('Content-type: text/plain');
				echo serialize($data);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($data);
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function category_subcategories() {
		$variables = explode('.', $this->uri->segment(5));
		$format = $variables[1];
		$object = $this->uri->segment(4);
		
		$category = $this->categorymodel->fetchCategorySlug($object);
		
		if (!$category) {
			show_404('');
		}
		
		$children = $this->categorymodel->fetchChildrenCategories($category['id']);
		
		if (!$children) {
			$children = Array();
		}
		
		$data = Array('children' => $children);
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($data);
				break;
			case 'sphp':
				header('Content-type: text/plain');
				echo serialize($data);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($data);
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function category_content() {
		$variables = explode('.', $this->uri->segment(5));
		$format = $variables[1];
		
		$category = $this->categorymodel->fetchCategorySlug($this->uri->segment(4));
		
		if (!$category) {
			show_404('');
		}
		$childrencategories = $this->categorymodel->fetchChildrenCategories($category['id']);
		$content = $this->contentmodel->fetchContentByCategory($category['id']);
		$config = $this->systemmodel->fetchConfig();
		
		if (!is_array($content)) {
			$content = (Array) Array();
		}
		
		if ($category['return_all_content'] == 1 && is_array($childrencategories)) {
			foreach($childrencategories as $cat) {
				$c = $this->contentmodel->fetchContentByCategory($cat['id']);
				$subc = $this->categorymodel->fetchChildrenCategories($cat['id']);
				if (is_array($c)) {
					$content = array_merge($content, $c);
				}
				if (is_array($subc)) {
					foreach ($subc as $c) {
						$cont = $this->contentmodel->fetchContentByCategory($c['id']);
						$content = array_merge($cont, $content);
					}
				}
			}
		}
		
		uasort($content, 'cmp_content');
		
		if ($category['oldest_first']) {
			$content = array_reverse($content);
		}
		
		$data = Array('category' => $category, 'content' => $content);
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($data);
				break;
			case 'sphp':
				header('Content-type: text/plain');
				echo serialize($data);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($data);
				break;
			case 'rss':
				header('Content-type: application/rss+xml');
				echo '<'.'?'.'xml version="1.0" encoding="UTF-8" '.'?'.">\n";
				echo '<rss version="2.0">'."\n";
				echo "<channel>\n";
				echo "\t<title>".$category['name']."</title>\n";
				echo "\t<link>".$this->config->item('base_url')."content/".$category['slug']."/</link>\n";
				echo "\n";
				foreach ($content as $piece) {
					echo "\t<item>\n";
					echo "\t\t<title>".$piece['name']."</title>\n";
					echo "\t\t<description>";
					if ($piece['customEmbed'] == "") {
						switch ($piece['file']['type']) {
							case 'png':
							case 'gif':
							case 'jpg':
								echo '<img class="comic" src="'.$this->config->item('base_url').'api/1/file/'.$piece['main_attachment'].'" alt="'.$piece['name'].'" 
/><br />';
								break;
							default:
								break;
						}
					}
					echo $piece['body']."</description>\n";
					echo "\t\t<link>".$this->config->item('base_url')."content/".$category['slug']."/".$piece['slug']."/</link>\n";
					echo "\t\t<guid>".$piece['hub']['id']."-".$piece['hub_slug']."/".$piece['id']."-".$piece['slug']."</guid>\n";
					echo "\t\t<pubDate>".date('D, d M Y H:i:s +0000 ', $piece['date'])."</pubDate>\n";
					echo "\t</item>\n";
				}
				echo "</channel>\n";
				echo "</rss>";
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function all_content() {
		$variables = explode('.', $this->uri->segment(4));
		$format = $variables[1];
		
		$content = $this->contentmodel->fetchNewContent(25);
		$config = $this->systemmodel->fetchConfig();
		
		if (!is_array($content)) {
			$content = (Array) Array();
		}
		
		uasort($content, 'cmp_content');
		
		$data = Array('content' => $content);
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($data);
				break;
			case 'sphp':
				header('Content-type: text/plain');
				echo serialize($data);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($data);
				break;
			case 'rss':
				header('Content-type: application/rss+xml');
				echo '<'.'?'.'xml version="1.0" encoding="UTF-8" '.'?'.">\n";
				echo '<rss version="2.0">'."\n";
				echo "<channel>\n";
				echo "\t<title>".$this->config->item('site_name')." &bull; Latest Content </title>\n";
				echo "\t<link>".$this->config->item('base_url')."</link>\n";
				echo "\n";
				foreach ($content as $piece) {
					echo "\t<item>\n";
					echo "\t\t<title>".$piece['name']."</title>\n";
					echo "\t\t<description>";
					if ($piece['customEmbed'] == "") {
						switch ($piece['file']['type']) {
							case 'png':
							case 'gif':
							case 'jpg':
								echo '<img class="comic" src="'.$this->config->item('base_url').'api/1/file/'.$piece['main_attachment'].'" alt="'.$piece['name'].'" 
/><br />';
								break;
							default:
								break;
						}
					}
					echo $piece['body']."</description>\n";
					echo "\t\t<link>".$this->config->item('base_url')."content/".$piece['hub_slug']."/".$piece['slug']."/</link>\n";
					echo "\t\t<guid>".$piece['hub']['id']."-".$piece['hub_slug']."/".$piece['id']."-".$piece['slug']."</guid>\n";
					echo "\t\t<pubDate>".date('D, d M Y H:i:s +0000 ', $piece['date'])."</pubDate>\n";
					echo "\t</item>\n";
				}
				echo "</channel>\n";
				echo "</rss>";
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function file() {
		$file = $this->uri->segment(4);
		
		$query = $this->db->get_where('files', array('id' => $file));
		
		if ($query->num_rows() == 0) {
			show_404('');
		}
		
		$query = $query->row_array();
		
		if (file_exists('files/'.$query['id'].'.'.$query['type'])) {
			if ($this->uri->segment(5) == "download") {
				header('Location: /files/'.$query['id'].'.'.$query['type'].'?dl=1');
				die();
			} else {
				header('Location: /files/'.$query['id'].'.'.$query['type']);
				die();
			}
		} else {
			show_404('');
		}
	}
	
	function content_featured() {
		$variables = explode('.', $this->uri->segment(4));
		$format = $variables[1];
		
		$content = $this->contentmodel->fetchFeaturedContent();
		
		if (!$content) {
			show_404('');
		}
		
		$data = Array('content' => $content);
		
		switch ($format) {
			case 'json':
				header('Content-type: application/json');
				echo json_encode($data);
				break;
			case 'sphp':
				header('Content-type: text/plain');
				echo serialize($data);
				break;
			case 'xml':
				header('Content-type: text/xml');
				echo $this->acmedata->toXML($data);
				break;
			default:
				show_404('');
				break;
		}
	}
	
	function content_downloadZip() {
		$category = $this->uri->segment(4);
		$category = $this->categorymodel->fetchCategorySlug($category);
		
		if (file_exists('./files/archives/zip/'.$category['id'].'.zip'))
			header('Location: /files/archives/zip/'.$category['id'].'.zip');
		else
			show_404('/api/1/content/xx/download.zip');
		
		echo "aa";
	}
}
