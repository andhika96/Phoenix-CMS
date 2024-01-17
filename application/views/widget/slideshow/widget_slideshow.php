<?php

class Aruna_Widget_SlideShow
{
	protected $db;

	protected $agent;

	public function __construct()
	{
		$Aruna =& get_instance();

		$this->db = $Aruna->db;

		$this->agent = $Aruna->agent;
	}

	public function show($page = '', $rendered_with_vuejs = FALSE)
	{
		if ($this->__is_active($page) == 1)
		{
			$slideshow_output 	= '';
			$slideshow_data 	= $this->__init_slideshow($page);
			$slideshow_layout 	= $this->__init_slideshow_layout($page);

			$slideshow_output .= '
			<style>
			:root 
			{
				--swiper-navigation-color: #fff !important;
				--swiper-navigation-size: 25px !important; 
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

			$i = 0;
			foreach ($slideshow_data as $key => $value) 
			{
				$slideshow_vars = json_decode($value['vars'], true);

				$button_0 = ($slideshow_vars['button'][0]['content'] !== '') ? '<a href="'.$slideshow_vars['button'][0]['content'].'" class="btn btn-outline-light rounded-pill">'.$slideshow_vars['button'][0]['title'].'</a>' : '';
				$button_1 = ($slideshow_vars['button'][1]['content'] !== '') ? '<a href="'.$slideshow_vars['button'][1]['content'].'" class="btn btn-outline-light rounded-pill">'.$slideshow_vars['button'][1]['title'].'</a>' : '';

				if ($rendered_with_vuejs === TRUE)
				{
					$slideshow_output .= '
					<component is="style" type="text/css">
					.swiper-slide-'.$i.'::before
					{
						position: absolute;
						width: 100%;
						height: 100%;
						display: block;
						left: 0;
						top: 0;
						content: "";
						z-index: 0 !important;
						background-color: '.$slideshow_vars['style']['background_overlay'].';
					}

					.swiper-slide-'.$i.'::after
					{
						position: absolute;
						width: 100%;
						height: 100%;
						display: block;
						left: 0;
						top: 0;
						content: "";
						background-color: '.$slideshow_vars['style']['background_overlay'].';
					}
					</component>';
				}
				elseif ($rendered_with_vuejs === FALSE) 
				{
					$slideshow_output .= '
					<style>
					.swiper-slide-'.$i.'::before
					{
						position: absolute;
						width: 100%;
						height: 100%;
						display: block;
						left: 0;
						top: 0;
						content: "";
						z-index: 0 !important;
						background-color: '.$slideshow_vars['style']['background_overlay'].';
					}

					.swiper-slide-'.$i.'::after
					{
						position: absolute;
						width: 100%;
						height: 100%;
						display: block;
						left: 0;
						top: 0;
						content: "";
						background-color: '.$slideshow_vars['style']['background_overlay'].';
					}
					</style>';
				}

				if ( ! $this->agent->is_mobile())
				{
					if ($slideshow_layout['display_type'] == 'only_image')
					{
						if (file_exists($value['image_web']))
						{
							$slideshow_output .= '
							<div class="swiper-slide swiper-slide-'.$i.' ph-slideshow position-relative">
								<img src="'.base_url($value['image_web']).'" class="img-fluid">

								<div class="container-fluid ph-container-fluid-slideshow position-absolute '.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['parent-class-top-bottom'].' '.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['parent-class-start-end'].' '.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['parent-class-translate-middle'].' text-white" style="z-index: 2">
									<div class="position-relative">
										<div class="'.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['class-position'].' '.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['class-top-bottom'].' '.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['class-start-end'].' '.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['class-translate-middle'].' w-100">
											<div class="row">
												<div class="col-5 '.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['class-margin'].' '.$this->__init_position_content_desktop($slideshow_vars['style']['position_desktop'])['class-text'].'">
													<h2>'.$value['title'].'</h2>
													<h4 class="font-weight-light mb-3">'.$value['caption'].'</h4>

													<div class="ph-slideshow-button-area">												
														'.$button_0.$button_1.'
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>';
						}
						else
						{
							$slideshow_output .= '
							<div class="swiper-slide swiper-slide-'.$i.' ph-slideshow position-relative">
								<div class="position-absolute top-50 start-50 translate-middle text-center text-white h4">
									Image Not Found!
								</div>
							</div>';
						}
					}
				}
				elseif ($this->agent->is_mobile())
				{
					if ($slideshow_layout['display_type'] == 'only_image')
					{
						if (file_exists($value['image_mobile']))
						{
							$slideshow_output .= '
							<div class="swiper-slide swiper-slide-'.$i.' ph-slideshow position-relative">
								<img src="'.base_url($value['image_mobile']).'" class="img-fluid">

								<div class="container-fluid ph-container-fluid-slideshow position-absolute '.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['parent-class-top-bottom'].' '.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['parent-class-start-end'].' '.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['parent-class-translate-middle'].' text-white" style="z-index: 2">
									<div class="position-relative">
										<div class="'.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['class-position'].' '.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['class-top-bottom'].' '.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['class-start-end'].' '.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['class-translate-middle'].' w-100">
											<div class="row">
												<div class="col '.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['class-margin'].' '.$this->__init_position_content_mobile($slideshow_vars['style']['position_mobile'])['class-text'].'">
													<h2>'.$value['title'].'</h2>
													<h4 class="font-weight-light mb-3">'.$value['caption'].'</h4>

													<div class="ph-slideshow-button-area">												
														'.$button_0.$button_1.'
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>';
						}
						else
						{
							$slideshow_output .= '
							<div class="swiper-slide swiper-slide-'.$i.' ph-slideshow position-relative">
								<div class="position-absolute top-50 start-50 translate-middle text-center text-white h4">
									Image Not Found!
								</div>
							</div>';
						}
					}
				}

				$i++;
			}
	
			$autoPlay 		= ($slideshow_layout['autoplay_activate'] == 'active') ? 'autoplay: { delay: '.$slideshow_layout['autoplay_duration'].', disableOnInteraction: false },' : '';
			$adaptiveHeight	= ($slideshow_layout['is_adaptive_height'] == 1) ? 'autoHeight: true,' : 'autoHeight: false,';
			$effect 		= ($slideshow_layout['slide_per_view'] > 1) ? '' : (($slideshow_layout['effect'] == 'fade') ? 'effect: "fade", fadeEffect:{ crossFade: true },' : '');
			$slidesPerView 	= ($slideshow_layout['slide_per_view'] > 1) ? 'slidesPerView: '.$slideshow_layout['slide_per_view'].', spaceBetween: 30, loop: false,' : 'slidesPerView: '.$slideshow_layout['slide_per_view'].', loop: true,';

			$slideshow_output .= '
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
				'.$autoPlay.'
				'.$adaptiveHeight.'
				'.$effect.'
				'.$slidesPerView.'
				direction: "horizontal",
				pagination: 
				{
					el: ".swiper-pagination",
					type: "bullets",
					clickable: true
				},
				navigation: 
				{
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
			});
			</script>';

			return $slideshow_output;
		}
	}

	protected function __is_active($page)
	{
		$res = $this->db->sql_prepare("select * from ml_modules where name = :page and type in ('core', 'page')");
		$bindParam = $this->db->sql_bindParam(['page' => $page], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['name'] = isset($row['name']) ? $row['name'] : NULL;

		if ($row['name'])
		{
			$output = ($row['is_slideshow'] == 1) ? 1 : 0;
		}
		else
		{
			$output = 0;
		}

		return $output;
	}

	protected function __init_slideshow($uri)
	{
		$res = $this->db->sql_prepare("select * from ml_slideshow where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		
		if ($this->db->sql_counts($bindParam))
		{
			$row = $this->db->sql_fetch($bindParam);
		}
		else
		{
			$row = [];
		}

		return $row;
	}

	protected function __init_slideshow_layout($uri)
	{
		$res = $this->db->sql_prepare("select * from ml_layout_slideshow where uri = :uri");
		$bindParam = $this->db->sql_bindParam(['uri' => $uri], $res);
		
		if ($this->db->sql_counts($bindParam))
		{
			$row = $this->db->sql_fetch_single($bindParam);
		}
		else
		{
			$row = [];
		}

		return $row;
	}

	protected function __init_position_content_desktop($position)
	{
		if ($position == 'left-top-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-0';
			$output['parent-class-start-end'] 			= 'start-0';
			$output['parent-class-translate-middle'] 	= '';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-start'; 
		}
		elseif ($position == 'left-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-start'; 
		}
		elseif ($position == 'left-bottom-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'bottom-0';
			$output['parent-class-start-end'] 			= 'start-0';
			$output['parent-class-translate-middle'] 	= '';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-start'; 
		}
		elseif ($position == 'left-w-text-center-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-center'; 
		}
		elseif ($position == 'left-w-text-right-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-end'; 
		}
		elseif ($position == 'center-top-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-0';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle-x';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-50';
			$output['class-translate-middle'] 			= 'translate-middle';

			$output['class-margin'] 					= 'mx-auto';
			$output['class-text']						= 'text-center'; 
		}
		elseif ($position == 'center-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-50';
			$output['class-translate-middle'] 			= 'translate-middle';

			$output['class-margin'] 					= 'mx-auto';
			$output['class-text']						= 'text-center'; 
		}
		elseif ($position == 'center-bottom-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'bottom-0';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle-x';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-50';
			$output['class-translate-middle'] 			= 'translate-middle';

			$output['class-margin'] 					= 'mx-auto';
			$output['class-text']						= 'text-center'; 
		}
		elseif ($position == 'right-top-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-0';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle-x';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-end'; 
		}
		elseif ($position == 'right-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-end'; 
		}
		elseif ($position == 'right-bottom-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'bottom-0';
			$output['parent-class-start-end'] 			= 'end-0';
			$output['parent-class-translate-middle'] 	= '';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-end'; 
		}
		elseif ($position == 'right-w-text-left-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-start'; 
		}
		elseif ($position == 'right-w-text-center-desktop')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-center'; 
		}

		return $output;
	}

	protected function __init_position_content_mobile($position)
	{
		if ($position == 'left-top-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-0';
			$output['parent-class-start-end'] 			= 'start-0';
			$output['parent-class-translate-middle'] 	= '';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-start'; 
		}
		elseif ($position == 'left-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-start'; 
		}
		elseif ($position == 'left-bottom-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'bottom-0';
			$output['parent-class-start-end'] 			= 'start-0';
			$output['parent-class-translate-middle'] 	= '';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-start'; 
		}
		elseif ($position == 'left-w-text-center-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-center'; 
		}
		elseif ($position == 'left-w-text-right-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'me-auto';
			$output['class-text']						= 'text-end'; 
		}
		elseif ($position == 'center-top-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-0';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle-x';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-50';
			$output['class-translate-middle'] 			= 'translate-middle';

			$output['class-margin'] 					= 'mx-auto';
			$output['class-text']						= 'text-center'; 
		}
		elseif ($position == 'center-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-50';
			$output['class-translate-middle'] 			= 'translate-middle';

			$output['class-margin'] 					= 'mx-auto';
			$output['class-text']						= 'text-center'; 
		}
		elseif ($position == 'center-bottom-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'bottom-0';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle-x';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'start-50';
			$output['class-translate-middle'] 			= 'translate-middle';

			$output['class-margin'] 					= 'mx-auto';
			$output['class-text']						= 'text-center'; 
		}
		elseif ($position == 'right-top-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-0';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle-x';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-end'; 
		}
		elseif ($position == 'right-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-end'; 
		}
		elseif ($position == 'right-bottom-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'bottom-0';
			$output['parent-class-start-end'] 			= 'end-0';
			$output['parent-class-translate-middle'] 	= '';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-end'; 
		}
		elseif ($position == 'right-w-text-left-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-start'; 
		}
		elseif ($position == 'right-w-text-center-mobile')
		{
			$output['parent-class-position'] 			= 'position-absolute';
			$output['parent-class-top-bottom'] 			= 'top-50';
			$output['parent-class-start-end'] 			= 'start-50';
			$output['parent-class-translate-middle'] 	= 'translate-middle';

			$output['class-position'] 					= 'position-absolute';
			$output['class-top-bottom'] 				= 'top-50';
			$output['class-start-end'] 					= 'end-0';
			$output['class-translate-middle'] 			= 'translate-middle-y';

			$output['class-margin'] 					= 'ms-auto';
			$output['class-text']						= 'text-center'; 
		}

		return $output;
	}
}

?>