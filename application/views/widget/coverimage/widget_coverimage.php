<?php

class widget_content
{
	public function index($page)
	{
		$Aruna =& get_instance();

		// Get data layout cover image
		$res_layout = $Aruna->db->sql_prepare("select * from ml_layout where page = :page and section = :section");
		$bindParam_layout = $Aruna->db->sql_bindParam(['page' => $page, 'section' => 'coverimage'], $res_layout);
		$row_layout = $Aruna->db->sql_fetch_single($bindParam_layout);

		// Prevent from Automatic conversion of false to array is deprecated
		$row_layout = ($row_layout !== FALSE) ? $row_layout : [];

		// Get image cover
		$res_image = $Aruna->db->sql_prepare("select * from ml_coverimage where uri = :uri");
		$bindParam_image = $Aruna->db->sql_bindParam(['uri' => $page], $res_image);
		$row_image = $Aruna->db->sql_fetch_single($bindParam_image);

		// Prevent from Automatic conversion of false to array is deprecated
		$row_image = ($row_image !== FALSE) ? $row_image : [];

		$output = '';
		$row_image['image_web'] ?? '';
		$row_image['image_mobile'] ?? '';
		$row_layout['background_overlay'] ?? '';

		if (isset($row_layout['is_parallax']) && $row_layout['is_parallax'] == 0)
		{
			$output = '
			<style>
			.ph-cover-image .ph-cover-image-filter:before 
			{
				background: '.$row_layout['background_overlay'].';
			}
			</style>';

			if (isset($row_image['image_web']) && file_exists($row_image['image_web']))
			{
				$output .= '
				<div class="ph-cover-image d-none d-md-block">
					<div class="ph-background ph-cover-image-filter ph-size-'.$row_layout['size_type'].'" style="background-image: url('.base_url($row_image['image_web']).')" alt="Background Image">
						<div class="container">
							<div class="row">
								<div class="col-md-8 mx-auto text-center">
									<h2>'.$row_layout['content_title'].'</h2>
									<h4 class="font-weight-light">'.$row_layout['content_description'].'</h4>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}

			if (isset($row_image['image_mobile']) && file_exists($row_image['image_mobile']))
			{
				$output .= '
				<div class="ph-cover-image d-block d-md-none">
					<div class="ph-background ph-cover-image-filter ph-size-'.$row_layout['size_type'].'" style="background-image: url('.base_url($row_image['image_mobile']).'" alt="Background Image">
						<div class="container">
							<div class="row">
								<div class="col-md-8 mx-auto text-center">
									<h2>'.$row_layout['content_title'].'</h2>
									<h4 class="font-weight-light">'.$row_layout['content_description'].'</h4>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
		}
		elseif (isset($row_layout['is_parallax']) && $row_layout['is_parallax'] == 1)
		{
			$output = '
			<style>
			.ph-cover-image .ph-cover-image-filter:before 
			{
				background: '.$row_layout['background_overlay'].';
			}
			</style>';
			
			if (isset($row_image['image_web']) && file_exists($row_image['image_web']))
			{
				$output .= '
				<div class="d-none d-md-block">
					<div class="ph-cover-image">
						<div class="ph-background ph-cover-image-filter ph-size-'.$row_layout['size_type'].' parallax-window" data-parallax="scroll" data-image-src="'.base_url($row_image['image_web']).'" alt="Background Image">
							<div class="container">
								<div class="row">
									<div class="col-md-8 mx-auto text-center">
										<h2>'.$row_layout['content_title'].'</h2>
										<h4 class="font-weight-light">'.$row_layout['content_description'].'</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}

			if (isset($row_image['image_mobile']) && file_exists($row_image['image_mobile']))
			{
				$output .= '
				<div class="d-block d-md-none">
					<div class="ph-cover-image">
						<div class="ph-background ph-cover-image-filter ph-size-'.$row_layout['size_type'].' parallax-window" data-parallax="scroll" data-image-src="'.base_url($row_image['image_mobile']).'" alt="Background Image">
							<div class="container">
								<div class="row">
									<div class="col-md-8 mx-auto text-center">
										<h2>'.$row_layout['content_title'].'</h2>
										<h4 class="font-weight-light">'.$row_layout['content_description'].'</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
		}

		return $output;
	}
}

?>