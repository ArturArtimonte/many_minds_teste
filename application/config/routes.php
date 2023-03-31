<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['register'] = 'auth/register';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

$route['accounts'] = 'accounts';
$route['create_colab'] = 'accounts/create_collaborator_page';
$route['create_collaborator'] = 'accounts/create_collaborator';
$route['create_collaborator_no_user'] = 'accounts/create_collaborator_no_user';
$route['alter_collaborator'] = 'accounts/alter_collaborator';
$route['update_collaborator'] = 'accounts/update_collaborator';
$route['get_user'] = 'accounts/get_users';


$route['orders'] = 'orders';
$route['create_order'] = 'orders/create_order';
$route['create_order_db'] = 'orders/create_order_db';
$route['update_order'] = 'orders/update_order';
$route['update_order_db'] = 'orders/update_order_db';
$route['add_item_to_session'] = 'orders/add_item_to_session';
$route['remove_item/(:any)'] = 'orders/remove_item/$1';
$route['remove_item_from_update/(:any)'] = 'orders/remove_item_from_update/$1';
$route['order_confirmation/(:num)'] = 'orders/order_confirmation/$1';
$route['set_order_id'] = 'orders/set_order_id';
$route['set_status_session'] = 'orders/set_status_session';

$route['products'] = 'products';
$route['create_products'] = 'products/create_products';
$route['products/create_product_in_db'] = 'products/create_product_in_db';
$route['products/edit'] = 'products/edit_product';
$route['products/update_product'] = 'products/update_product';


$route['registration_sucess'] = 'auth/registration_sucess';
$route['homepage'] = 'home/index';