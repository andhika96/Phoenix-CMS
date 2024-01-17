<?php

function manage_appearance_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];	

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage Appearance',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-palette fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'Logo',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_appearance/logo'
		],
		[
			'name' 	=> 'Slideshow',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_appearance/slideshow'
		],
		[
			'name' 	=> 'Cover Image',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_appearance/coverimage'
		],
		[
			'name' 	=> 'Page Style',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_appearance/pagestyle'
		],
		[
			'name' 	=> 'Layout',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_appearance/layout'
		]
	];

	return $module;
}

?>