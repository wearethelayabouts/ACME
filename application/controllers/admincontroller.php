<?php
class Admincontroller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->model('usermodel');
		$this->load->model('systemmodel');
		$this->load->model('contentmodel');
		$this->load->model('categorymodel');
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}
	
	function view() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/home', $data);
	}
	
	// CONTENT //
	
	function view_content($page = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		if ($this->uri->segment(3) >= 1) $page = $this->uri->segment(3);
		else $page = 1;
		
		//$this->uri->segment(4)
		
		if ($this->uri->segment(4)) {
			$sortby = strtolower($this->uri->segment(4));
			if (($sortby != "date") && ($sortby != "id") && ($sortby != "name") && ($sortby != "cat")) $sortby = "date";
			if ($this->uri->segment(5)) {
				if ((strtolower($this->uri->segment(5)) == "desc") || (strtolower($this->uri->segment(5)) == "d")) $sortasc = false;
				else if ((strtolower($this->uri->segment(5)) == "asc") || (strtolower($this->uri->segment(5)) == "a")) $sortasc = true;
				else $sortasc = false;
			} else $sortasc = false;
		} else {
			$sortby = "date";
			$sortasc = false;
		}
		
		$content = $this->contentmodel->fetchAllContent($sortby,$sortasc,$page,25);
		$contentcount = $this->contentmodel->countAllContent();
		$pagesamount = ceil($contentcount/25);
		
		foreach ($content as $piece) {
			$category = $this->categorymodel->fetchCategory($piece['category_id']);
			$categorynames[$piece['id']] = $category['name'];
		}
		
		if ($this->uri->segment(4)) {
			if ($this->uri->segment(5)) $urlappend = "/" . $this->uri->segment(4) . "/" . $this->uri->segment(5);
			else $urlappend = "/" . $this->uri->segment(4);
		} else $urlappend = "";
		
		$paginationhtml = $this->systemmodel->paginate($page,$pagesamount,"/toolbox/content/",$urlappend);
		
		$messagecode = $this->input->get('m');
		if ($messagecode == 'editsuccess') {
			$messagetype = 1;
			$message = "Your content has been modified successfully.";
		} else if ($messagecode == 'addsuccess') {
			$messagetype = 1;
			$message = "Your content has been added successfully.";
		} else {
			$messagetype = 0;
			$message = "";
		}
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl,
			'content' => $content,
			'categorynames' => $categorynames,
			'page' => $page,
			'pagesamount' => $pagesamount,
			'paginationhtml' => $paginationhtml,
			'sortby' => $sortby,
			'sortasc' => $sortasc,
			'message' => $message,
			'messagetype' => $messagetype
		);
		
		$this->load->view('admin/content_view', $data);
	}
	
	function edit_content($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
			
		$commit = $this->input->post('commit');
		$valid = false;
		$errors = Array();
		$postdata = Array();
		
		$id = $this->uri->segment(4);
		$editexisting = ($id != 0);
		
		if ($commit) {
			// validate content!
			
			$postdata['name'] = $this->input->post('name');
			$postdata['category_id'] = $this->input->post('category_id');
			$postdata['body'] = $this->input->post('body');
			$postdata['rating'] = $this->input->post('rating');
			$postdata['rating_description'] = $this->input->post('rating_description');
			$postdata['customEmbed'] = $this->input->post('customembed');
			
			$postdata['slug'] = $this->input->post('slug');
			$slugmeta = quotemeta($postdata['slug']);
			if ((ereg(" ", $postdata['slug'])) || (ereg("/", $postdata['slug'])) || ($slugmeta != $postdata['slug'])) $errors['slug'] = "Slugs may not contain spaces or any of the following chracters: / \\ + * ? [ ^ ] ( $ )";
			
			$postdata['year'] = $this->input->post('year');
			if (strlen($postdata['year']) != 0) {
				if (strlen($postdata['year']) != 4) $errors['year'] = "Years must be 4-digit numbers, 1970 or higher.";
				if ($postdata['year'] < 1970) $errors['year'] = "Years must be 4-digit numbers, 1970 or higher.";
			} else $postdata['year'] = date("Y");
			
			$postdata['month'] = $this->input->post('month');
			if (strlen($postdata['month']) != 0) {
				if (strlen($postdata['month']) != 2) $errors['month'] = "Months must be 2-digit numbers, from 01 to 12.";
				if (($postdata['month'] > 12) || ($postdata['month'] < 1)) $errors['month'] = "Months must be 2-digit numbers, from 01 to 12.";
			} else $postdata['month'] = date("m");
			
			$postdata['day'] = $this->input->post('day');
			if (strlen($postdata['day']) != 0) {
				if (strlen($postdata['day']) != 2) $errors['day'] = "Days must be 2-digit numbers, from 01 to 31.";
				if (($postdata['day'] > 31) || ($postdata['day'] < 1)) $errors['day'] = "Days must be 2-digit numbers, from 01 to 31.";
				if (($postdata['day'] >= 31) && ($postdata['month'] == 4)) $errors['day'] = "April only has 30 days!";
				if (($postdata['day'] >= 31) && ($postdata['month'] == 6)) $errors['day'] = "June only has 30 days!";
				if (($postdata['day'] >= 31) && ($postdata['month'] == 9)) $errors['day'] = "September only has 30 days!";
				if (($postdata['day'] >= 31) && ($postdata['month'] == 11)) $errors['day'] = "November only has 30 days!";
				
				$leapyear = date("L", strtotime($year.'-02-22'));
				if (($postdata['day'] >= 29) && ($month == 2) && ($leapyear == 0)) $errors['day'] = "February only has 28 days in ".$year."!";
				if (($postdata['day'] >= 30) && ($month == 2) && ($leapyear == 1)) $errors['day'] = "February only has 29 days in ".$year."!";
			} else $postdata['day'] = date("d");
			
			$postdata['hour'] = $this->input->post('hour');
			if (strlen($postdata['hour']) != 0) {
				if (strlen($postdata['hour']) != 2) $errors['hour'] = "Hours must be 2-digit numbers, from 00 to 23.";
				if (($postdata['hour'] > 23) || ($postdata['hour'] < 0)) $errors['hour'] = "Hours must be 2-digit numbers, from 00 to 23.";
			} else $postdata['hour'] = date("h");
			
			$postdata['minute'] = $this->input->post('minute');
			if (strlen($postdata['minute']) != 0) {
				if (strlen($postdata['minute']) != 2) $errors['minute'] = "Minutes must be 2-digit numbers, from 00 to 59.";
				if (($postdata['minute'] > 59) || ($postdata['minute'] < 0)) $errors['minute'] = "Minutes must be 2-digit numbers, from 00 to 59.";
			} else $postdata['minute'] = date("i");
			
			$valid = (count($errors) <= 0);
			if ($valid) {
				if ($editexisting) $committype = 'editcontent';
				else $committype = 'addcontent';
				
				$content = Array(
					'date' => strtotime($postdata['year']."-".$postdata['month']."-".$postdata['day']." ".$postdata['hour'].":".$postdata['minute'].":00")
				);
				
				foreach ($postdata as $key => $value)
					if (($key != 'year') && ($key != 'month') && ($key != 'day') && ($key != 'hour') && ($key != 'minute'))
						$content[$key] = $value;
				
				$data = Array(
					'type' => $committype,
					'object' => $content
				);
				
				$this->load->view('admin/commit', $data);
			}
		}
		
		if (!$commit || !$valid) {			
			if ($editexisting) {
				$content = $this->contentmodel->fetchContentByID($id);
				$category = $this->categorymodel->fetchCategory($content['category_id']);
			} else {
				$content = Array();
				$category = Array();
				$category['name'] = "";
				$category['id'] = 0;
			}
			if (count($postdata) > 0) foreach ($postdata as $key => $value) $content[$key] = $value;
			
			$allcategories = $this->categorymodel->fetchCategoryList();
			
			$uri_string = $this->uri->uri_string();
			if (substr($uri_string, 0, 1) != "/") $uri_string = "/".$uri_string;		
	
			if (substr($baseurl, -1) == "/") $thispageurl = substr($baseurl, 0, -1).$uri_string;
			else $thispageurl = $baseurl.$uri_string;
			
			$data = Array(
				'sitename' => $sitename,
				'baseurl' => $baseurl,
				'editexisting' => $editexisting,
				'content' => $content,
				'thispageurl' => $thispageurl,
				'category' => $category,
				'allcategories' => $allcategories,
				'errors' => $errors
			);
			
			$this->load->view('admin/content_edit', $data);
		}
	}
	
	// CATEGORIES //
	
	function view_categories($page = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/category_view', $data);
	}
	
	function edit_category($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/category_edit', $data);
	}
	
	function commit_category($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		//do something
	}
	
	// FILES //
	
	function view_files($tags = "", $page = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		// uri segment 3 = page
		// uri segment 4 = sort
		// uri segment 5 = sort type
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		if ($this->uri->segment(3) >= 1) $page = $this->uri->segment(3);
		else $page = 1;
		
		if ($this->uri->segment(4)) {
			$sortby = strtolower($this->uri->segment(4));
			if (($sortby != "id") && ($sortby != "dscr") && ($sortby != "type") && ($sortby != "fname")) $sortby = "id";
			if ($this->uri->segment(5)) {
				if ((strtolower($this->uri->segment(5)) == "desc") || (strtolower($this->uri->segment(5)) == "d")) $sortasc = false;
				else if ((strtolower($this->uri->segment(5)) == "asc") || (strtolower($this->uri->segment(5)) == "a")) $sortasc = true;
				else $sortasc = false;
			} else $sortasc = false;
		} else {
			$sortby = "id";
			$sortasc = false;
		}
		
		if (($sortby != 'type') && ($sortby != 'fname') && ($sortby != 'dscr')) {
			if ($sortasc) $sortorder = 'asc';
			else $sortorder = 'desc';
		} else {
			if ($sortasc) $sortorder = 'desc';
			else $sortorder = 'asc';
		}
		
		if ($sortby == 'dscr') $this->db->order_by('internalDescription', $sortorder);
		else if ($sortby == 'type') $this->db->order_by('type', $sortorder);
		else if ($sortby == 'fname') $this->db->order_by('name', $sortorder);
		else if ($sortby == 'id') $this->db->order_by('id', $sortorder);

		else $this->db->order_by('id', 'desc');
		
		$query = $this->db->get('files');
		$filecount = $query->num_rows();
		$pagesamount = ceil($filecount/25);
		
		if ($query->num_rows() == 0) {
			$files = Array();
		} else {
			$query = $query->result_array();
			$i = ($page-1)*25;
			while ($i < ($page)*25) {
				$file = $query[$i];
				$files[] = $file;
				$i++;
			}
		}
		
		if ($this->uri->segment(4)) {
			if ($this->uri->segment(5)) $urlappend = "/" . $this->uri->segment(4) . "/" . $this->uri->segment(5);
			else $urlappend = "/" . $this->uri->segment(4);
		} else $urlappend = "";
		
		$paginationhtml = $this->systemmodel->paginate($page,$pagesamount,"/toolbox/files/",$urlappend);
		
		$messagecode = $this->input->get('m');
		if ($messagecode == 'editsuccess') {
			$messagetype = 1;
			$message = "Your file has been modified successfully.";
		} else if ($messagecode == 'addsuccess') {
			$messagetype = 1;
			$message = "Your file has been added successfully.";
		} else {
			$messagetype = 0;
			$message = "";
		}
		
		$data = Array(
			'files' => $files,
			'sitename' => $sitename,
			'baseurl' => $baseurl,
			'page' => $page,
			'pagesamount' => $pagesamount,
			'paginationhtml' => $paginationhtml,
			'sortby' => $sortby,
			'sortasc' => $sortasc,
			'message' => $message,
			'messagetype' => $messagetype
		);
		
		$this->load->view('admin/file_view', $data);
	}
	
	function edit_file($id) {
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
			
		$commit = $this->input->post('commit');
		$valid = false;
		$errors = Array();
		$postdata = Array();
		
		$id = $this->uri->segment(4);
		$editexisting = ($id != 0);
		
		if ($commit) {
			// validate content!
			
			$postdata['internal_description'] = $this->input->post('internal_description');
			$postdata['type'] = $this->input->post('type');
			$postdata['name'] = $this->input->post('name');
			$postdata['is_downloadable'] = $this->input->post('is_downloadable');
			$postdata['upload'] = $this->input->post('upload');
			$postdata['id'] = $this->input->post('id');
			$attach = $this->input->post('attachment_type');
			
			$namemeta = quotemeta($postdata['name']);
			if ((ereg("/", $postdata['name'])) || ($namemeta != $postdata['name'])) $errors['name'] = "Filenames may not contain any of the following chracters: / \\ + * ? [ ^ ] ( $ )";
			
			$valid = (count($errors) <= 0);
			if ($valid) {
				if ($editexisting) $committype = 'editfile';
				else $committype = 'addfile';
				
				$is_downloadable = false;
				if ($postdata['is_downloadable'] == "on") $is_downloadable = true;
				
				$file = Array(
					'type' => $postdata['type'],
					'name' => $postdata['name'],
					'is_downloadable' => $is_downloadable,
					'internal_description' => $postdata['internal_description']
				);
				
				if ($editexisting) {
					$this->db->where('id', intval($postdata['id']));
					$this->db->update('files',$file);
				} else {
					$this->db->insert('files',$file);
					$insertid = $this->db->insert_id();
				}
				
				$uploadconfig['upload_path'] = './files/';
				$uploadconfig['allowed_types'] = '*';
				if ($editexisting) $uploadconfig['file_name']  = $postdata['id'].".".$file['type'];
				else $uploadconfig['file_name']  = $insertid.".".$file['type'];
				$uploadconfig['remove_spaces']  = '0';
				$uploadconfig['overwrite']  = 'TRUE';

				$this->load->library('upload', $uploadconfig);

				if (!$this->upload->do_upload()) {
					$error = array('error' => $this->upload->display_errors());
					//$this->load->view('upload_form', $error);
					print_r($error);
					die();
				} else {
					$data = Array(
						'type' => $committype,
						'object' => $file,
						'attachment_type' => $attach
					);
					
					$data['object']['upload_data'] = $this->upload->data();
					
					$this->load->view('admin/commit', $data);
				}
			}
		}
		
		if (!$commit || !$valid) {			
			if ($editexisting) {
				$file = $this->db->get_where('files', array('id' => $id));
				$file = $file->row_array();
			} else {
				$file = Array();
				$file['id'] = "NULL";
			}
			if (count($postdata) > 0) foreach ($postdata as $key => $value) if ($key != 'upload') $file[$key] = $value;
			
			$uri_string = $this->uri->uri_string();
			if (substr($uri_string, 0, 1) != "/") $uri_string = "/".$uri_string;		
	
			if (substr($baseurl, -1) == "/") $thispageurl = substr($baseurl, 0, -1).$uri_string;
			else $thispageurl = $baseurl.$uri_string;
			
			$data = Array(
				'sitename' => $sitename,
				'baseurl' => $baseurl,
				'editexisting' => $editexisting,
				'file' => $file,
				'thispageurl' => $thispageurl,
				'errors' => $errors,
				'editexisting' => $editexisting
			);
			
			$this->load->view('admin/file_edit', $data);
		}
	}
	
	function commit_file($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		//do something
	}
	
	// NEWS //
	
	function view_news($page = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/news_view', $data);
	}
	
	function edit_news($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/news_edit', $data);
	}
	
	function commit_news($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		//do something
	}
	
	// PAGES //
	
	function view_pages($page = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/page_view', $data);
	}
	
	function edit_page($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/page_edit', $data);
	}
	
	function commit_page($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		//do something
	}
	
	// USERS //
	
	function view_users($page = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/user_view', $data);
	}
	
	function edit_user($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/user_edit', $data);
	}
	
	function commit_user($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		//do something
	}
	
	// USER FIELDS //
	
	function view_user_fields($page = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/userfield_view', $data);
	}
	
	function edit_user_field($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/userfield_edit', $data);
	}
	
	function commit_user_field($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		//do something
	}
	
	// AUTHOR ROLES //
	
	function view_author_roles($page = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/authorroles_view', $data);
	}
	
	function edit_author_role($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		$this->load->view('admin/authorroles_edit', $data);
	}
	
	function commit_author_role($id = 0) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$config = $this->systemmodel->fetchConfig();
		
		$sitename = $this->config->item('site_name');
		$baseurl = $this->config->item('base_url');
		
		$data = Array(
			'sitename' => $sitename,
			'baseurl' => $baseurl
		);
		
		//do something
	}
}
