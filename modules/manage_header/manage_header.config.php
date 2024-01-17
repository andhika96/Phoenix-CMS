<?php

function manage_header_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];	

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage Header Menu',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-newspaper fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'List of Header Menu',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-list fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_header'
		]
	];

	return $module;
}

?>