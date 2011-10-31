<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "welcome";
$route['scaffolding_trigger'] = "";

// API Version 1 routes
$route['api/1/user/:num/info.:any'] = "api/user_info";

$route['api/1/category/:any/info.:any'] = "api/category_info";
$route['api/1/category/:any/content.:any'] = "api/category_content";

$route['api/1/content/all.:any'] = "api/all_content";

$route['api/1/content/featured.:any'] = "api/content_featured";
$route['api/1/content/:any/download.zip'] = "api/content_downloadZip";

$route['api/1/file/:num'] = "api/file";
$route['api/1/file/:num/download'] = "api/file";

// Regular routes
$route['user/:num'] = "usercontroller/view";
$route['user/forum'] = "usercontroller/forumprofile";

$route['content/:any/sortasc'] = "categorycontroller/view";
$route['content/:any/sortdesc'] = "categorycontroller/view";
$route['content/:any/download.zip'] = "contentcontroller/downloadzip";
$route['content/:any/playall'] = "contentcontroller/playall";
$route['content/:any/page/:num'] = "categorycontroller/view";
$route['content/:any/sortasc/:num'] = "categorycontroller/view";
$route['content/:any/sortdesc/:num'] = "categorycontroller/view";
$route['content/:any/:any'] = "contentcontroller/view";
$route['content/:any'] = "categorycontroller/view";

$route['news/:any'] = "newscontroller/single";
$route['news'] = "newscontroller/view";

$route['page/:any'] = "pagecontroller/view";// Admin routes

// Admin routes
$route['toolbox/content/add'] = "admincontroller/edit_content";
$route['toolbox/content/edit/:any'] = "admincontroller/edit_content";
$route['toolbox/content'] = "admincontroller/view_content";
$route['toolbox/content/:any'] = "admincontroller/view_content";

$route['toolbox/categories/add'] = "admincontroller/edit_category";
$route['toolbox/categories/edit/:any'] = "admincontroller/edit_category";
$route['toolbox/categories/commit/:any'] = "admincontroller/commit_category";
$route['toolbox/categories'] = "admincontroller/view_categories";
$route['toolbox/categories/:any'] = "admincontroller/view_categories";

$route['toolbox/files/upload'] = "admincontroller/upload_file";
$route['toolbox/files/add'] = "admincontroller/edit_file";
$route['toolbox/files/edit/:any'] = "admincontroller/edit_file";
$route['toolbox/files'] = "admincontroller/view_files";
$route['toolbox/files/:any'] = "admincontroller/view_files";

$route['toolbox/news/add'] = "admincontroller/edit_news";
$route['toolbox/news/edit/:any'] = "admincontroller/edit_news";
$route['toolbox/news'] = "admincontroller/view_news";
$route['toolbox/news/:any'] = "admincontroller/view_news";

$route['toolbox/pages/add'] = "admincontroller/edit_page";
$route['toolbox/pages/edit/:any'] = "admincontroller/edit_page";
$route['toolbox/pages'] = "admincontroller/view_pages";
$route['toolbox/pages/:any'] = "admincontroller/view_pages";

$route['toolbox/users/add'] = "admincontroller/edit_user";
$route['toolbox/users/edit/:any'] = "admincontroller/edit_user";
$route['toolbox/users'] = "admincontroller/view_users";
$route['toolbox/users/:any'] = "admincontroller/view_users";

$route['toolbox/user_fields/add'] = "admincontroller/edit_user_field";
$route['toolbox/user_fields/edit/:any'] = "admincontroller/edit_user_field";
$route['toolbox/user_fields'] = "admincontroller/view_user_fields";
$route['toolbox/user_fields/:any'] = "admincontroller/view_user_fields";

$route['toolbox/popup/users/select/:num'] = "admincontroller/popup_user_select";

$route['toolbox/popup/files/select'] = "admincontroller/popup_file_select";
$route['toolbox/popup/files/select/:any'] = "admincontroller/popup_file_select";

$route['toolbox/:any'] = "admincontroller/view";
$route['toolbox'] = "admincontroller/view";

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */
