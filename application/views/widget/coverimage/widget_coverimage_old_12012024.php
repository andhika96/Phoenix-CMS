<?php

class widget_content
{
	protected $db;

	protected $agent;

	public function __construct()
	{
		$Aruna =& get_instance();

		$this->db = $Aruna->db;

		$this->agent = $Aruna->agent;
	}

	public function index($page = '', $rendered_with_vuejs = FALSE)
	{
		if ($this->__is_active($page) == 1)
		{
			$coverimage_output 	= '';
			$coverimage_data 	= $this->__init_coverimage($page);
			$coverimage_layout 	= $this->__init_coverimage_layout($page);

			$coverimage_vars 	= json_decode($coverimage_data['vars'], true);

			if ($coverimage_layout['display_type'] == 'only_image')
			{
				if ($rendered_with_vuejs === TRUE)
				{
					$coverimage_output = '
					<component is="style" type="text/css">
					.ph-cover-only-image .ph-cover-image-filter
					{
						background: '.$coverimage_layout['background_overlay'].';
					}
					</component>';
				}
				elseif ($rendered_with_vuejs === FALSE) 
				{
					$coverimage_output = '
					<style>
					.ph-cover-only-image .ph-cover-image-filter
					{
						background: '.$coverimage_layout['background_overlay'].';
					}
					</style>';
				}

				if ($this->agent->is_mobile())
				{
					$coverimage_output .= '
					<div class="ph-cover-only-image position-relative d-block d-md-none">
						<img src="'.base_url($coverimage_data['image_mobile']).'" class="img-fluid w-100">

						<div class="container position-absolute top-50 start-50 translate-middle text-white" style="z-index: 2">
							<div class="row">
								<div class="col-md-8 col-9 mx-auto text-center">
									<h2>'.$coverimage_layout['content_title'].'</h2>
									<h4 class="font-weight-light">'.$coverimage_layout['content_description'].'</h4>
								</div>
							</div>
						</div>
						
						<div class="ph-cover-image-filter"></div>
					</div>';
				}
				elseif ( ! $this->agent->is_mobile())
				{
					$coverimage_output .= '
					<div class="ph-cover-only-image position-relative d-none d-md-block">
						<img src="'.base_url($coverimage_data['image_web']).'" class="img-fluid w-100">

						<div class="container position-absolute top-50 start-50 translate-middle text-white" style="z-index: 2">
							<div class="row">
								<div class="col-md-8 col-9 mx-auto text-center">
									<h2>'.$coverimage_layout['content_title'].'</h2>
									<h4 class="font-weight-light">'.$coverimage_layout['content_description'].'</h4>
								</div>
							</div>
						</div>

						<div class="ph-cover-image-filter"></div>
					</div>';
				}
			}
			elseif ($coverimage_layout['display_type'] == 'background_image')
			{

			}

			return $coverimage_output;
		}	
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
			if ($row['is_coverimage'] == 1)
			{
				$coverimage_output = 1;
			}
			else
			{
				$coverimage_output = 0;
			}
		}
		else
		{
			$coverimage_output = 0;
		}

		return $coverimage_output;
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
}

?>