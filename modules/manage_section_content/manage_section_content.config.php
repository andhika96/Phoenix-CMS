<?php

function manage_section_content_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage Section Content',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-columns fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'Content In Pages',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_section_content/pages'
		],
		[
			'name' 	=> 'Header',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_section_content/header'
		],
		[
			'name' 	=> 'Footer',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-images fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_section_content/footer'
		]
	];

	return $module;
}

?>