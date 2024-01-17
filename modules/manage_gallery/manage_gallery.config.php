<?php

function manage_gallery_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage Gallery',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-phone fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'Manage Gallery',
			'type' 	=> 'single',
			'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_gallery'
		]
	];

	return $module;
}

?>