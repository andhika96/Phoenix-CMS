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

function manage_section_content_menu()
{
	$list_menu[] = 
	[
		'name' 	=> 'Manage Section Content',
		'type' 	=> 'parent',
		'icon' 	=> '<i class="fad fa-columns fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> ''
	];

	$list_menu[] = 
	[
		'name' 	=> 'Content In Pages',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_section_content/pages'
	];

	$list_menu[] = 
	[
		'name' 	=> 'Header',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_section_content/header'
	];

	$list_menu[] = 
	[
		'name' 	=> 'Footer',
		'type' 	=> 'child',
		'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_section_content/footer'
	];

	return $list_menu;
}