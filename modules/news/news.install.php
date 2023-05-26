<?php

/*
 * Available config
 * 
 * Slideshow, Cover Image, Widget, and Carousel
 * 
 * You can set 1 to activate and set 0 to deactivate
 * For active_slideshow and active_coverimage you can only choose one and cannot active at the same time
 *
 * @return array	
 */

function news_install()
{
	$config =
	[
		'active_slideshow'	=> 0,
		'active_coverimage'	=> 1,
		'active_widget'		=> 1
	];

	return $config;
}

?>