<?php

function news_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true,
		'slideshow' 	=> true,
		'coverimage'	=> true,
		'widget'		=> true
	];

	return $module;
}

?>