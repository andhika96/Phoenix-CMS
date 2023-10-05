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

function manage_contactus_menu()
{
	$list_menu[] = 
	[
		'name' 	=> 'Manage Contact Us',
		'type' 	=> 'parent',
		'icon' 	=> '<i class="fad fa-phone fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> ''
	];

	$list_menu[] = 
	[
		'name' 	=> 'Manage Contact Us',
		'type' 	=> 'single',
		'icon' 	=> '<i class="fad fa-phone fa-fw me-2"></i>',
		'roles' => '99',
		'path' 	=> 'manage_contactus'
	];

	return $list_menu;
}