<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

/***************************************************	USERS INTRERFACE	***********************************************/
$route[''] 			= "users_interface/index";

/***************************************************	ADMIN INTRERFACE	***********************************************/
$route['admin-panel/actions/logoff']	= "admin_interface/admin_logoff";
$route['admin-panel/actions/control']	= "admin_interface/admin_panel";
?>