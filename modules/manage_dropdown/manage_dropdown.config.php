<?php

function manage_dropdown_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];	

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage Dropdown Menu',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-newspaper fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'List of Dropdown Menu',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-list fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_dropdown'
		],
		[
			'name' 	=> 'Add New',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-plus fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_dropdown/addpost'
		]
	];

	return $module;
}

?>