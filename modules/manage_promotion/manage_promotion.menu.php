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

defined('MODULEPATH') OR exit('No direct script access allowed');

/*
 * Availabe type menu:
 * 
 * single, parent, and child
 * 
 * If you want to change name you should add new parameter
 *
 * 'new_name' => 'New Name'
 *
 * Example:
 *
 * 'name' => 'Old Name',
 * 'new_name' => 'New Name'
 *
*/

function manage_promotion_menu()
{
	$list_menu[] = 
	[
		'name' 	=> 'Manage Promotion',
		'type' 	=> 'parent',
		'icon' 	=> '<i class="fad fa-newspaper fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> ''
	];

	$list_menu[] = 
	[
		'name' 	=> 'List of Promotion',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-list fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_promotion'
	];

	$list_menu[] = 
	[
		'name' 	=> 'Add New',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-plus fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_promotion/addpost'
	];

	$list_menu[] = 
	[
		'name' 	=> 'Promotion Categories',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-folder fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_promotion/category'
	];

	$list_menu[] = 
	[
		'name' 	=> 'Layout',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_promotion/layout'
	];

	return $list_menu;
}