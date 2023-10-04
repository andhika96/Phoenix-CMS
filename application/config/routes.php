<?php

	/*
	 *	Aruna Development Project
	 *	IS NOT FREE SOFTWARE
	 *	Codename: Aruna Personal Site
	 *	Source: Based on Sosiaku Social Networking Software
	 *	Website: https://www.sosiaku.gq
	 *	Website: https://www.aruna-dev.id
	 *	Created and developed by Andhika Adhitia N
	 */

	defined('BASEPATH') OR exit('No direct script access allowed');

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
	|	https://codeigniter.com/user_guide/general/routing.html
	|
	| -------------------------------------------------------------------------
	| RESERVED ROUTES
	| -------------------------------------------------------------------------
	|
	| There are three reserved routes:
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

	$route = array();

	$route['news/index'] 			= 'news/index';
	$route['news/list_view'] 		= 'news/list_view';
	$route['news/grid_view'] 		= 'news/grid_view';
	$route['news/getListPosts'] 	= 'news/getListPosts';
	$route['news/(:any)'] 			= 'news/detail/$1';

	$route['event/index'] 			= 'event/index';
	$route['event/list_view'] 		= 'event/list_view';
	$route['event/grid_view'] 		= 'event/grid_view';
	$route['event/getListPosts'] 	= 'event/getListPosts';
	$route['event/(:any)'] 			= 'event/detail/$1';

	$route['promotion/index'] 			= 'promotion/index';
	$route['promotion/list_view'] 		= 'promotion/list_view';
	$route['promotion/grid_view'] 		= 'promotion/grid_view';
	$route['promotion/getListPosts'] 	= 'promotion/getListPosts';
	$route['promotion/(:any)'] 			= 'promotion/detail/$1';

	$route['portofolio/index'] 			= 'portofolio/index';
	$route['portofolio/list_view'] 		= 'portofolio/list_view';
	$route['portofolio/grid_view'] 		= 'portofolio/grid_view';
	$route['portofolio/getListPosts'] 	= 'portofolio/getListPosts';
	$route['portofolio/getDetail'] 		= 'portofolio/getDetail';
	$route['portofolio/(:any)'] 		= 'portofolio/detail/$1';

	$route['api']['GET'] = 'news/index';

?>