<?php

class Aruna_Widget_CoverImage
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
			$coverimage_output 	= '';
			$coverimage_data 	= $this->__init_coverimage($page);
			$coverimage_layout 	= $this->__init_coverimage_layout($page);

			$coverimage_vars 	= json_decode($coverimage_data['vars'], true);

			if ($rendered_with_vuejs === TRUE)
			{
				$coverimage_output = '
				<component is="style" type="text/css">
				.ph-cover-only-image .ph-cover-image-filter
				{
					top: 0;
					width: 100%;
					height: 100%;
					position: absolute;
					background: '.$coverimage_vars['style']['background_overlay'].';
				}

				.ph-cover-background-image .ph-cover-image-filter:before 
				{
					background: '.$coverimage_vars['style']['background_overlay'].';
				}
				</component>';
			}
			elseif ($rendered_with_vuejs === FALSE) 
			{
				$coverimage_output = '
				<style>
				.ph-cover-only-image .ph-cover-image-filter
				{
					top: 0;
					width: 100%;
					height: 100%;
					position: absolute;
					background: '.$coverimage_vars['style']['background_overlay'].';
				}

				.ph-cover-background-image .ph-cover-image-filter:before 
				{
					background: '.$coverimage_vars['style']['background_overlay'].';
				}
				</style>';
			}

			$button_0 = ($coverimage_vars['button'][0]['content'] !== '') ? '<a href="'.$coverimage_vars['button'][0]['content'].'" class="btn btn-outline-light rounded-pill">'.$coverimage_vars['button'][0]['title'].'</a>' : '';
			$button_1 = ($coverimage_vars['button'][1]['content'] !== '') ? '<a href="'.$coverimage_vars['button'][1]['content'].'" class="btn btn-outline-light rounded-pill">'.$coverimage_vars['button'][1]['title'].'</a>' : '';

			if ( ! $this->agent->is_mobile())
			{
				if ($coverimage_layout['display_type'] == 'only_image')
				{
					if (file_exists($coverimage_data['image_web']))
					{
						$coverimage_output .= '
						<div class="ph-cover-only-image position-relative d-none d-md-block">
							<img src="'.base_url($coverimage_data['image_web']).'" class="img-fluid w-100">

							<div class="container-fluid ph-container-fluid-coverimage position-absolute '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-top-bottom'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-start-end'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-translate-middle'].' text-white" style="z-index: 2">
								<div class="position-relative">
									<div class="'.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-position'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-top-bottom'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-start-end'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-translate-middle'].' w-100">
										<div class="row">
											<div class="col-7 '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-margin'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-text'].'">
												<h2>'.$coverimage_data['title'].'</h2>
												<h4 class="font-weight-light mb-3">'.$coverimage_data['caption'].'</h4>

												<div class="ph-coverimage-button-area">												
													'.$button_0.$button_1.'
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="ph-cover-image-filter"></div>
						</div>';
					}
					else
					{
						$coverimage_output .= '
						<div class="ph-cover-only-image position-relative d-none d-md-block">
							<div class="position-absolute top-50 start-50 translate-middle text-center text-white h4">
								Image Not Found!
							</div>
						</div>';
					}
				}
				elseif ($coverimage_layout['display_type'] == 'background_image')
				{
					if (file_exists($coverimage_data['image_web']))
					{
						if ($coverimage_layout['is_parallax'] == 0)
						{
							$coverimage_output .= '
							<div class="ph-cover-background-image d-none d-md-block">
								<div class="ph-background ph-cover-image-filter ph-size-'.$coverimage_layout['image_size_desktop'].'" style="background-image: url('.base_url($coverimage_data['image_web']).')" alt="Background Image">

									<div class="container-fluid ph-container-fluid-coverimage position-absolute '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-top-bottom'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-start-end'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-translate-middle'].' text-white" style="z-index: 2">
										<div class="position-relative">
											<div class="'.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-position'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-top-bottom'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-start-end'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-translate-middle'].' w-100">
												<div class="row">
													<div class="col-5 '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-margin'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-text'].'">
														<h2>'.$coverimage_data['title'].'</h2>
														<h4 class="font-weight-light mb-3">'.$coverimage_data['caption'].'</h4>

														<div class="ph-coverimage-button-area">												
															'.$button_0.$button_1.'
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>';
						}
						elseif ($coverimage_layout['is_parallax'] == 1)
						{
							$coverimage_output .= '
							<div class="ph-cover-background-image d-none d-md-block">
								<div class="ph-background ph-cover-image-filter ph-size-'.$coverimage_layout['image_size_desktop'].'" parallax-window" data-parallax="scroll" data-image-src="'.base_url($coverimage_data['image_web']).'" alt="Background Image">

									<div class="container-fluid ph-container-fluid-coverimage position-absolute '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-top-bottom'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-start-end'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['parent-class-translate-middle'].' text-white" style="z-index: 2">
										<div class="position-relative">
											<div class="'.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-position'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-top-bottom'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-start-end'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-translate-middle'].' w-100">
												<div class="row">
													<div class="col-5 '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-margin'].' '.$this->__init_position_content_desktop($coverimage_vars['style']['position_desktop'])['class-text'].'">
														<h2>'.$coverimage_data['title'].'</h2>
														<h4 class="font-weight-light mb-3">'.$coverimage_data['caption'].'</h4>

														<div class="ph-coverimage-button-area">												
															'.$button_0.$button_1.'
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>';
						}
					}
					else
					{
						$coverimage_output .= '
						<div class="ph-cover-only-image position-relative d-none d-md-block">
							<div class="position-absolute top-50 start-50 translate-middle text-center text-white h4">
								Image Not Found!
							</div>
						</div>';
					}
				}
			}
			elseif ($this->agent->is_mobile())
			{
				if ($coverimage_layout['display_type'] == 'only_image')
				{
					if (file_exists($coverimage_data['image_mobile']))
					{
						$coverimage_output .= '
						<div class="ph-cover-only-image position-relative d-block d-md-none">
							<img src="'.base_url($coverimage_data['image_mobile']).'" class="img-fluid w-100">

							<div class="container-fluid ph-container-fluid-coverimage position-absolute '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-top-bottom'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-start-end'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-translate-middle'].' text-white" style="z-index: 2">
								<div class="position-relative">
									<div class="'.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-position'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-top-bottom'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-start-end'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-translate-middle'].' w-100">
										<div class="row">
											<div class="col '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-margin'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-text'].'">
												<h2>'.$coverimage_data['title'].'</h2>
												<h4 class="font-weight-light">'.$coverimage_data['caption'].'</h4>

												<div class="ph-coverimage-button-area">												
													'.$button_0.$button_1.'
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="ph-cover-image-filter"></div>
						</div>';
					}
					else
					{
						$coverimage_output .= '
						<div class="ph-cover-only-image position-relative d-block d-md-none">
							<div class="position-absolute top-50 start-50 translate-middle text-center text-white h4">
								Image Not Found!
							</div>
						</div>';
					}
				}
				elseif ($coverimage_layout['display_type'] == 'background_image')
				{
					if (file_exists($coverimage_data['image_mobile']))
					{
						if ($coverimage_layout['is_parallax'] == 0)
						{
							$coverimage_output .= '
							<div class="ph-cover-background-image d-block d-md-none">
								<div class="ph-background ph-cover-image-filter ph-size-'.$coverimage_layout['image_size_mobile'].'" style="background-image: url('.base_url($coverimage_data['image_mobile']).')" alt="Background Image">

									<div class="container-fluid ph-container-fluid-coverimage position-absolute '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-top-bottom'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-start-end'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-translate-middle'].' text-white" style="z-index: 2">
										<div class="position-relative">
											<div class="'.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-position'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-top-bottom'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-start-end'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-translate-middle'].' w-100">
												<div class="row">
													<div class="col '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-margin'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-text'].'">
														<h2>'.$coverimage_data['title'].'</h2>
														<h4 class="font-weight-light">'.$coverimage_data['caption'].'</h4>

														<div class="ph-coverimage-button-area">												
															'.$button_0.$button_1.'
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>';
						}
						elseif ($coverimage_layout['is_parallax'] == 1)
						{
							$coverimage_output .= '
							<div class="ph-cover-background-image d-block d-md-none">
								<div class="ph-background ph-cover-image-filter ph-size-'.$coverimage_layout['image_size_mobile'].'" parallax-window" data-parallax="scroll" data-image-src="'.base_url($coverimage_data['image_mobile']).'" alt="Background Image">

									<div class="container-fluid ph-container-fluid-coverimage position-absolute '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-top-bottom'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-start-end'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['parent-class-translate-middle'].' text-white" style="z-index: 2">
										<div class="position-relative">
											<div class="'.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-position'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-top-bottom'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-start-end'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-translate-middle'].' w-100">
												<div class="row">
													<div class="col '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-margin'].' '.$this->__init_position_content_mobile($coverimage_vars['style']['position_mobile'])['class-text'].'">
														<h2>'.$coverimage_data['title'].'</h2>
														<h4 class="font-weight-light">'.$coverimage_data['caption'].'</h4>

														<div class="ph-coverimage-button-area">												
															'.$button_0.$button_1.'
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>';
						}
					}
					else
					{
						$coverimage_output .= '
						<div class="ph-cover-only-image position-relative d-block d-md-none">
							<div class="position-absolute top-50 start-50 translate-middle text-center text-white h4">
								Image Not Found!
							</div>
						</div>';
					}
				}
			}
		}

		return $coverimage_output;
	}

	protected function __is_active($page)
	{
		$res = $this->db->sql_prepare("select * from ml_modules where name = :page and type = :type");
		$bindParam = $this->db->sql_bindParam(['page' => $page, 'type' => 'page'], $res);
		$row = $this->db->sql_fetch_single($bindParam);

		// Prevent from Automatic conversion of false to array is deprecated
		$row = ($row !== FALSE) ? $row : [];

		$row['name'] = isset($row['name']) ? $row['name'] : NULL;

		if ($row['name'])
		{
			$output = ($row['is_coverimage'] == 1) ? 1 : 0;
		}
		else
		{
			$output = 0;
		}

		return $output;
	}

	protected function __init_coverimage($uri)
	{
		$res = $this->db->sql_prepare("select * from ml_coverimage where uri = :uri");
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

	protected function __init_coverimage_layout($uri)
	{
		$res = $this->db->sql_prepare("select * from ml_layout_coverimage where uri = :uri");
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