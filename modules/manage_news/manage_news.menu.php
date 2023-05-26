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

function manage_news_menu()
{
	$list_menu[] = 
	[
		'name' 	=> 'Manage News',
		'type' 	=> 'parent',
		'icon' 	=> '<i class="fad fa-newspaper fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> ''
	];

	$list_menu[] = 
	[
		'name' 	=> 'List of News',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-list fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_news'
	];

	$list_menu[] = 
	[
		'name' 	=> 'Add New',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-plus fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_news/addpost'
	];

	$list_menu[] = 
	[
		'name' 	=> 'News Categories',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-folder fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_news/category'
	];

	$list_menu[] = 
	[
		'name' 	=> 'Layout',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_news/layout'
	];

	return $list_menu;
}