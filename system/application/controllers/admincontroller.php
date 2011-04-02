<?php
class Admincontroller extends Controller {
	function Admincontroller() {
		parent::Controller();
		$this->load->database();
		$this->load->library('ACMEData');
		$this->load->library('ACMEAuth');
		$this->load->model('usermodel'); //for loading of user permissions; not implemented yet
	}
	
	function view() {
		$config = $this->systemmodel->fetchConfig();
		$sitename = $this->config->item('site_name');
		
		$data = Array(
			'sitename' => $sitename
		);
		
		$this->load->view('admin/home', $data);
	}
	
	// CONTENT //
	
	function view_content($page = 0) {
		$data = Array();
		$this->load->view('admin/content_view', $data);
	}
	
	function edit_content($id = 0) {
		$data = Array();
		$this->load->view('admin/content_edit', $data);
	}
	
	function commit_content($id = 0) {
		//do something
	}
	
	// CATEGORIES //
	
	function view_categories($page = 0) {
		$data = Array();
		$this->load->view('admin/category_view', $data);
	}
	
	function edit_category($id = 0) {
		$data = Array();
		$this->load->view('admin/category_edit', $data);
	}
	
	function commit_category($id = 0) {
		//do something
	}
	
	// FILES //
	
	function view_files($tags = "", $page = 0) {
		$data = Array();
		$this->load->view('admin/file_edit', $data);
	}
	
	function addnew_file($amount = 1) {
		$data = Array();
		$this->load->view('admin/file_add', $data);
	}
	
	function edit_file($id) {
		$data = Array();
		$this->load->view('admin/file_edit', $data);
	}
	
	function commit_file($id = 0) {
		//do something
	}
	
	// NEWS //
	
	function view_news($page = 0) {
		$data = Array();
		$this->load->view('admin/news_view', $data);
	}
	
	function edit_news($id = 0) {
		$data = Array();
		$this->load->view('admin/news_edit', $data);
	}
	
	function commit_news($id = 0) {
		//do something
	}
	
	// PAGES //
	
	function view_pages($page = 0) {
		$data = Array();
		$this->load->view('admin/page_view', $data);
	}
	
	function edit_page($id = 0) {
		$data = Array();
		$this->load->view('admin/page_edit', $data);
	}
	
	function commit_page($id = 0) {
		//do something
	}
	
	// USERS //
	
	function view_users($page = 0) {
		$data = Array();
		$this->load->view('admin/user_view', $data);
	}
	
	function edit_user($id = 0) {
		$data = Array();
		$this->load->view('admin/user_edit', $data);
	}
	
	function commit_user($id = 0) {
		//do something
	}
	
	// USER FIELDS //
	
	function view_user_fields($page = 0) {
		$data = Array();
		$this->load->view('admin/userfield_view', $data);
	}
	
	function edit_user_field($id = 0) {
		$data = Array();
		$this->load->view('admin/userfield_edit', $data);
	}
	
	function commit_user_field($id = 0) {
		//do something
	}
	
	// AUTHOR ROLES //
	
	function view_author_roles($page = 0) {
		$data = Array();
		$this->load->view('admin/authorroles_view', $data);
	}
	
	function edit_author_role($id = 0) {
		$data = Array();
		$this->load->view('admin/authorroles_edit', $data);
	}
	
	function commit_author_role($id = 0) {
		//do something
	}
}
