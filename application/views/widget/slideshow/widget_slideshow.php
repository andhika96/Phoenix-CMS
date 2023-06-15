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

			if ($row_layout['display_slideshow'] == 'only_image')
			{
				$output .= '
				<div class="swiper-slide position-relative">
					<img src="'.base_url($row_slideshow['image_web']).'" class="img-fluid">

					<div class="container position-absolute top-50 start-50 translate-middle text-white">
						<div class="row">
							<div class="col-md-8 mx-auto text-center">
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
					<div class="d-flex align-items-center justify-content-center" style="background-image: url('.base_url($row_slideshow['image_web']).');background-repeat: no-repeat;background-size: auto 800px;background-position: center center;height: 100vh;">
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

		$effect = ($row_layout['effect'] == 'fade') ? 'effect: "fade", fadeEffect:{ crossFade: true },' : '';
		$autoPlay = ($row_layout['autoplay'] == 'active') ? 'autoplay: { delay: '.$row_layout['autoplay_delay'].', disableOnInteraction: false },' : '';

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