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

	$list_limit_post_right = [1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6];
	$limit_post_right = isset($list_limit_post_right[$options['limit']]) ? $list_limit_post_right[$options['limit']] : 4;

	if ($limit_post_right == 6)
	{
		$override_css = '
		<style>
		@media screen and (min-width: 1199.98px)
		{
			.ph-grid-box-view .ph-section-2 .ph-event .thumbnail_'.$widget.' 
			{
				min-width: 160px !important;
				height: 107.1px !important;
			}

			.ph-grid-box-view .ph-section-2 .ph-event .details_'.$widget.'
			{
				padding-top: 0px !important;
				padding-right: 12px !important;
				padding-bottom: 0px !important;
				padding-left: 12px !important;
			}
		}
		</style>';

		$override_margin_bottom = 'mb-3';
	}
	else
	{
		$override_css = '';
		$override_margin_bottom = 'mb-4';
	}

	$output = '
	'.$override_css.'

	<div class="container py-3 py-md-3">
		<div class="mb-3">
			<div class="row">
				<div class="col-md-4 mb-3 mb-md-0">
					<div class="h2 fw-bold">'.get_data_global('widget')['title'][$widget].'</div> <p>'.get_data_global('widget')['caption'][$widget].'</p>
				</div>
			</div>
		</div>

		<!-- Grid View -->
		<div class="row g-3 ph-grid-box-view">
			<!-- Section 1 -->
			<div class="col-xl-7 ph-section-1">';

	$i = 0;
	foreach ($row_article as $key => $value)	
	{
		if ($i == 0)
		{
			$value['content'] = strip_tags(ellipsize($value['content'], 150));
			$value['content'] = preg_replace("/&#?[a-z0-9]+;/i", '', $value['content']).'...';

			$output .= '
				<div class="ph-event">
					<div>
						<div class="thumbnail">
							<a href="'.site_url($widget.'/'.$value['uri']).'" class="stretched-link">
								<div class="tag">'.get_category($value['cid']).'</div>
								<div class="image" style="background-image: url('.base_url($value['thumb_l']).');"></div>
							</a>
						</div> 
						
						<div class="details">
							<div class="wrapper">
								<div class="row g-2 mb-3">
									<div class="col-7 col-md-3">
										<div class="text-muted text-small"><i class="fas fa-user fa-fw"></i> '.ellipsize('Andhika Adhitia Negara', 20).'</div> 
									</div>

									<div class="col-5">
										<div class="text-muted text-small"><i class="fas fa-clock fa-fw"></i> '.get_date($value['created'], 'date').'</div> 
									</div>
								</div>

								<h3 class="title mb-3">
									<a href="'.site_url($widget.'/'.$value['uri']).'"><span>'.ellipsize($value['title'], 100).'</span></a>
								</h3> 
								
								<p class="mb-3">'.$value['content'].'</p>

								<a href="'.site_url($widget.'/'.$value['uri']).'" class="more_listing text-mg-red">Read More</a>
							</div>
						</div>
					</div>
				</div>';
		}

		$i++;
	}

	$output .= '
			</div>

			<div class="col-xl-5 ph-section-2">';

	$i2 = 0;
	foreach ($row_article as $key => $value)	
	{
		// We limit the post only 3 post from array key 1 to 4
		// And ignoring limit in query database
		if ($i2 !== 0 && $i2 < $limit_post_right)
		{
			$output .= '
				<div class="ph-event d-block d-xl-inline-flex '.$override_margin_bottom.'">
					<div class="thumbnail thumbnail_'.$widget.'">
						<a href="'.site_url($widget.'/'.$value['uri']).'" class="stretched-link">
							<div class="tag">'.get_category($value['cid']).'</div>
							<div class="image" style="background-image: url('.base_url($value['thumb_s']).');"></div>
						</a>
					</div> 
					
					<div class="details details_'.$widget.'">
						<div class="wrapper">
							<div class="row gx-3 mb-3">
								<div class="col-auto">
									<div class="text-muted text-small"><i class="fas fa-user fa-fw"></i> '.ellipsize('Andhika Adhitia Negara', 20).'</div> 
								</div>

								<div class="col-auto">
									<div class="text-muted text-small"><i class="fas fa-clock fa-fw"></i> '.get_date($value['created'], 'date').'</div> 
								</div>
							</div>

							<h3 class="title mb-3">
								<a href="'.site_url($widget.'/'.$value['uri']).'" class="stretched-link d-none d-md-block"><span>'.ellipsize($value['title'], 28).'</span></a>
								<a href="'.site_url($widget.'/'.$value['uri']).'" class="stretched-link d-block d-md-none"><span>'.ellipsize($value['title'], 50).'</span></a>
							</h3> 

							<a href="'.site_url($widget.'/'.$value['uri']).'" class="more_listing text-mg-red">Read More</a>
						</div>
					</div>
				</div>';
		}

		$i2++;
	}
	
	$output .= '
			</div>
		</div>
	</div>';

	return $output;

?>