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

	add_title_widget('Portofolio', ['for_widget' => 'portofolio']);
	add_caption_widget('find the latest news from us', ['for_widget' => 'portofolio']);

	add_title_widget('News', ['for_widget' => 'news']);
	add_caption_widget('find the latest news from us', ['for_widget' => 'news']);

	add_title_widget('Event', ['for_widget' => 'event']);
	add_caption_widget('find the latest event from us', ['for_widget' => 'event']);

	section_content('
	<style>
	:root 
	{
		--swiper-navigation-color: #fff !important;
		--swiper-navigation-size: 25px !important; 
	}

	.swiper-pagination-bullet
	{
		border-radius: 0 !important;
		width: 23px !important;
		height: 3px !important;
		background-color: rgba(255, 255, 255, 1) !important;
	}

	.swiper-pagination-bullet .swiper-pagination-bullet-active
	{
		background-color: #fff !important;
	}

	.swiper-button-next
	{
		right: 25px !important;
	}

	.swiper-button-prev
	{
		left: 25px !important;
	}
	</style>

	<div>
		<!-- Slider main container -->
		<div class="swiper">
			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">');

	$res_slideshow = $db->sql_prepare("select * from ml_slideshow where uri = :uri");
	$bindParam_slideshow = $db->sql_bindParam(['uri' => 'home'], $res_slideshow);
	while ($row_slideshow = $db->sql_fetch_single($bindParam_slideshow))
	{
		section_content('
				<div class="swiper-slide">
					<img src="'.base_url($row_slideshow['image_web']).'" class="img-fluid">
				</div>');
	}

	section_content('
			</div>

			<!-- If we need pagination -->
			<div class="swiper-pagination"></div>

			<!-- If we need navigation buttons -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
	</div>

	'.add_slideshow('home').'

	<div class="container my-5">
		<div>
			'.add_widget('portofolio', 'grid_box').'
		</div>

		<div>
			'.add_widget('news', 'grid').'
		</div>

		<div>
			'.add_widget('event', 'grid_box').'
		</div>
	</div>');

?>