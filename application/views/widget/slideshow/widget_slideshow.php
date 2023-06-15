<?php

class widget_content
{
	public function index($page)
	{
		$Aruna =& get_instance();

		$res_layout = $Aruna->db->sql_prepare("select * from ml_layout where page = :page and section = :section");
		$bindParam_layout = $Aruna->db->sql_bindParam(['page' => $page, 'section' => 'slideshow'], $res_layout);
		$row_layout = $Aruna->db->sql_fetch_single($bindParam_layout);

		$output .= '
		<style>
		:root 
		{
			--swiper-navigation-color: #fff !important;
			--swiper-navigation-size: 25px !important; 
		}

		.swiper-pagination-bullets.swiper-pagination-horizontal
		{
			bottom: 30px !important;
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

		<div class="swiper">
			<div class="swiper-wrapper">';

		$res_slideshow = $Aruna->db->sql_prepare("select * from ml_slideshow where uri = :uri");
		$bindParam_slideshow = $Aruna->db->sql_bindParam(['uri' => $page], $res_slideshow);
		while ($row_slideshow = $Aruna->db->sql_fetch_single($bindParam_slideshow))
		{
			$output .= '
				<div class="swiper-slide">
					<img src="'.base_url($row_slideshow['image_web']).'" class="img-fluid">
				</div>';
		}

		$output .= '
				<!-- If we need pagination -->
				<div class="swiper-pagination"></div>

				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

		<script>
		const swiper = new Swiper(".swiper", 
		{
			// Effect
			effect: "fade",
			fadeEffect:
			{
				crossFade: true
			},

			// Optional parameters
			direction: "horizontal",
			loop: true,

			// If we need pagination
			pagination: 
			{
				el: ".swiper-pagination",
				type: "bullets",
			},

			// Navigation arrows
			navigation: 
			{
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},
		});
		</script>';

		return $output;
	}
}

?>