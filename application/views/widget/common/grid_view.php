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

	$output = '
	<div class="container py-3 py-md-5">
		<div class="ar-fetch-listdata">
			<div class="pb-5">
				<div class="row">
					<div class="col-md-4 mb-3 mb-md-0">
						<div class="h2 fw-bold">'.get_data_global('widget')['title'][$widget].'</div> <p>'.get_data_global('widget')['caption'][$widget].'</p>
					</div>
				</div>
			</div>

			<!-- Grid View -->
			<div class="row ph-grid-view">';

		foreach ($row_article as $key => $value)	
		{
			$output .= '
				<div class="col-md-6 col-xl-4" >
					<div class="ph-news">
						<div>
							<div class="thumbnail">
								<a href="'.site_url($widget.'/'.$value['uri']).'" class="stretched-link">
									<div class="tag">'.get_category($value['cid']).'</div>
									<div class="image" style="background-image: url('.base_url($value['thumb_s']).')"></div>
								</a>
							</div> 
						
							<div class="details">
								<div class="wrapper">
									<h4 class="title text-truncate mb-3">
										<a href="'.site_url($widget.'/'.$value['uri']).'" class="stretched-link"><span>'.$value['title'].'</span></a>
									</h4> 
									
									<div class="my-3">'.get_date($value['created'], 'date').'</div> 
									<a href="'.site_url($widget.'/'.$value['uri']).'" class="more_listing text-mg-red">Read More</a>
								</div>
							</div>
						</div>
					</div>
				</div>';
		}

	$output .= '
			</div>
		</div>
	</div>';

?>