<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

/***************************************************	USERS INTRERFACE	***********************************************/
$route[''] 			= "users_interface/index";
$route['admin'] 	= "users_interface/admin_login";
/***************************************************	ADMIN INTRERFACE	***********************************************/
$route['admin-panel/actions/logoff']	= "admin_interface/admin_logoff";
$route['admin-panel/actions/control']	= "admin_interface/admin_panel";

$route['admin-panel/actions/category']	= "admin_interface/admin_category";
$route['admin-panel/actions/brands']	= "admin_interface/admin_brands";

$route['admin-panel/actions/storage']	= "admin_interface/admin_storage";

$route['admin-panel/actions/baners']	= "admin_interface/admin_baners";

$route['admin-panel/actions/contacts']	= "admin_interface/admin_edit_text";
$route['admin-panel/actions/clients']	= "admin_interface/admin_edit_text";
$route['admin-panel/actions/about']		= "admin_interface/admin_edit_text";

$route['admin-panel/actions/events']			= "admin_interface/admin_events";
$route['admin-panel/actions/events/from/']		= "admin_interface/admin_events";
$route['admin-panel/actions/events/from/:num']	= "admin_interface/admin_events";

?>