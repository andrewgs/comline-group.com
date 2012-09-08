<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

/***************************************************	USERS INTRERFACE	***********************************************/
$route[''] 			= "users_interface/index";
$route['about'] 	= "users_interface/about";
$route['clients'] 	= "users_interface/clients";
$route['brands'] 	= "users_interface/brands";
$route['contacts'] 	= "users_interface/contacts";

$route['catalog/category/:any']	= "users_interface/catalog";
$route['catalog/brands/:any']	= "users_interface/catalog";
$route['catalog'] 				= "users_interface/catalog";
$route['catalog/load-products'] = "users_interface/catalog_load";
$route['catalog/come-back/:num-:num-:num'] = "users_interface/catalog";

$route['admin'] 	= "users_interface/admin_login";

$route['events']			= "users_interface/events";
$route['events/from']		= "users_interface/events";
$route['events/from/:num']	= "users_interface/events";

$route['news']				= "users_interface/news";
$route['news/from']			= "users_interface/news";
$route['news/from/:num']	= "users_interface/news";

$route['product/:num-:num-:num/:any'] = "users_interface/product";

$route['news/viewimage/:num']		= "users_interface/viewimage";
$route['stock/viewimage/:num']		= "users_interface/viewimage";
$route['brands/viewimage/:num']		= "users_interface/viewimage";
$route['productimage/viewimage/:num']		= "users_interface/viewimage";

$route['events/:any'] 	= "users_interface/view_events";
$route['news/:any'] 	= "users_interface/view_news";

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

$route['admin-panel/actions/events']		= "admin_interface/control_events";
$route['admin-panel/actions/events/from']	= "admin_interface/control_events";
$route['admin-panel/actions/events/from/:num']= "admin_interface/control_events";

$route['admin-panel/actions/events/add']	= "admin_interface/control_add_events";
$route['admin-panel/actions/events/edit/:any']= "admin_interface/control_edit_events";
$route['admin-panel/actions/events/delete/eventsid/:num']= "admin_interface/control_delete_events";

$route['admin-panel/actions/category']			= "admin_interface/control_category";
$route['admin-panel/actions/category/add']		= "admin_interface/control_add_category";
$route['admin-panel/actions/category/edit/:any']= "admin_interface/control_edit_category";
$route['admin-panel/actions/category/delete/categoryid/:num']= "admin_interface/control_delete_category";

$route['admin-panel/actions/storage']			= "admin_interface/control_storage";
$route['admin-panel/actions/storage/add']		= "admin_interface/control_add_storage";
$route['admin-panel/actions/storage/edit/storageid/:num']= "admin_interface/control_edit_storage";
$route['admin-panel/actions/storage/delete/storageid/:num']= "admin_interface/control_delete_storage";

$route['admin-panel/actions/brands']			= "admin_interface/control_brands";
$route['admin-panel/actions/brands/add']		= "admin_interface/control_add_brand";
$route['admin-panel/actions/brands/edit/:any']	= "admin_interface/control_edit_brand";
$route['admin-panel/actions/brands/delete/brandsid/:num']= "admin_interface/control_delete_brand";

$route['admin-panel/actions/colors']			= "admin_interface/control_colors";
$route['admin-panel/actions/color/add']			= "admin_interface/control_add_color";
$route['admin-panel/actions/colors/delete/colorid/:num']= "admin_interface/control_delete_colors";

$route['admin-panel/actions/products']			= "admin_interface/control_products";
$route['admin-panel/actions/products/from']		= "admin_interface/control_products";
$route['admin-panel/actions/products/from/:num']= "admin_interface/control_products";

$route['admin-panel/actions/products/add']		= "admin_interface/control_add_product";
$route['admin-panel/actions/products/delete/productid/:num']= "admin_interface/control_delete_product";
$route['admin-panel/actions/products/edit/:num']	= "admin_interface/control_edit_product";
$route['admin-panel/actions/products/productid/:num/colors']= "admin_interface/control_product_colors";
$route['admin-panel/actions/products/productid/:num/sizes']	= "admin_interface/control_product_sizes";

$route['admin-panel/actions/products/productid/:num/images']= "admin_interface/control_product_images";
$route['admin-panel/actions/products/productid/:num/images/add']= "admin_interface/control_product_images_add";
$route['admin-panel/actions/products/image-delete/imagesid/:num']= "admin_interface/control_product_images_delete";
?>