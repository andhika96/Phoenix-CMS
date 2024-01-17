<?php

function manage_news_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];	

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage News',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-newspaper fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'List of News',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-list fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_news'
		],
		[
			'name' 	=> 'Add New',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-plus fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_news/addpost'
		],
		[
			'name' 	=> 'News Categories',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-folder fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_news/category'
		],
		[
			'name' 	=> 'Layout',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_news/layout'
		]
	];

	return $module;
}

?>