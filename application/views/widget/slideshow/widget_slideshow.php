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

		.swiper-slide::before
		{
			position: absolute;
			width: 100%;
			height: 100%;
			display: block;
			left: 0;
			top: 0;
			content: "";
			z-index: 0 !important;
			background-color: rgba(0, 0, 0, 0.463);
		}

		.swiper-slide::after
		{
			position: absolute;
			width: 100%;
			height: 100%;
			display: block;
			left: 0;
			top: 0;
			content: "";
			background-color: rgba(0, 0, 0, 0.463);
		}

		.swiper-slide .container
		{
			z-index: 1;
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
			$get_vars = json_decode($row_slideshow['vars'], true);

			if ($get_vars['button'][0]['title'] !== '')
			{
				$button1 = '<a href="'.$get_vars['button'][0]['content'].'" class="btn btn-outline-light rounded-pill">'.$get_vars['button'][0]['title'].'</a>';
			}
			else
			{
				$button1 = '';
			}

			if ($get_vars['button'][1]['title'] !== '')
			{
				$button2 = '<a href="'.$get_vars['button'][1]['content'].'" class="btn btn-outline-light rounded-pill ms-3">'.$get_vars['button'][1]['title'].'</a>';
			}
			else
			{
				$button2 = '';
			}

			$left_position_1	= ($get_vars['style']['position'] == 'left') ? 'top-50 start-50 start-lg-35' : '';
			$center_position_1	= ($get_vars['style']['position'] == 'center') ? 'top-50 start-50' : '';
			$right_position_1	= ($get_vars['style']['position'] == 'right') ? 'top-50 start-50 start-lg-65' : '';

			$left_text_1	= ($get_vars['style']['position'] == 'left') ? 'text-start' : '';
			$center_text_1	= ($get_vars['style']['position'] == 'center') ? 'text-center' : '';
			$right_text_1	= ($get_vars['style']['position'] == 'right') ? 'text-end' : '';

			// $left_position_2	=
			// $center_position_2	=
			// $right_position_2	=

			if ($row_layout['display_slideshow'] == 'only_image')
			{
				$output .= '
				<div class="swiper-slide position-relative">
					<img src="'.base_url($row_slideshow['image_web']).'" class="img-fluid d-none d-md-block">
					<img src="'.base_url($row_slideshow['image_mobile']).'" class="img-fluid d-block d-md-none">

					<div class="container position-absolute '.$left_position_1.$center_position_1.$right_position_1.' translate-middle text-white">
						<div class="row">
							<div class="col-md-8 col-9 mx-auto '.$left_text_1.$center_text_1.$right_text_1.'">
								<h2>'.$row_slideshow['title'].'</h2>
								<h4 class="font-weight-light mb-3">'.$row_slideshow['caption'].'</h4>

								'.$button1.$button2.'
							</div>
						</div>
					</div>
				</div>';
			}
			elseif ($row_layout['display_slideshow'] == 'background_image')
			{
				$output .= '
				<div class="swiper-slide">
					<div class="swiper-background-image d-flex align-items-center justify-content-center" style="background-image: url('.base_url($row_slideshow['image_web']).');background-repeat: no-repeat;background-size: auto 800px;background-position: center center;height: 100vh;">
						<div class="container text-white">
							<div class="row">
								<div class="col-md-8 mx-auto text-center">
									<h2>'.$row_slideshow['title'].'</h2>
									<h4 class="font-weight-light mb-3">'.$row_slideshow['caption'].'</h4>

									'.$button1.$button2.'
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
		}

		
		$autoPlay = ($row_layout['autoplay'] == 'active') ? 'autoplay: { delay: '.$row_layout['autoplay_delay'].', disableOnInteraction: false },' : '';
		$slidesPerView = ($row_layout['slide_per_view'] > 1) ? 'slidesPerView: '.$row_layout['slide_per_view'].', spaceBetween: 30,' : '';

		if ($row_layout['slide_per_view'] > 1)
		{
			$effect = '';
		}
		else
		{
			$effect = ($row_layout['effect'] == 'fade') ? 'effect: "fade", fadeEffect:{ crossFade: true },' : '';
		}

		$output .= '
			</div>

			<!-- If we need pagination -->
			<div class="swiper-pagination"></div>

			<!-- If we need navigation buttons -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

		<script>
		const swiper = new Swiper(".swiper", 
		{
			// slidesPerView
			'.$slidesPerView.'

			// Effect
			'.$effect.'

			// autoPlay
			'.$autoPlay.'

			// Optional parameters
			direction: "horizontal",
			loop: true,

			// If we need pagination
			pagination: 
			{
				el: ".swiper-pagination",
				type: "bullets",
				clickable: true
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