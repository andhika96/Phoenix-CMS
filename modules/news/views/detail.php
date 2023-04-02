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

	// set_meta(site_url($uri->uri_string()), $row['title'], '', $row['thumb_ori']);

	section_content('
	<!--- Custom CSS --->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/styles/monokai-sublime.min.css">

	<div class="container my-4 my-lg-5">
		<div class="row">
			<div class="col-xl-10 mx-auto">
				<div class="mb-4">
					<h1 class="h2">'.$row['title'].'</h1>
				</div>

				<!--- User Info --->
				<div class="border-top border-bottom py-4 mb-4">
					<div class="row align-items-md-center">
						<div class="col-md-7 mb-3 mb-md-0">
							<div class="d-flex align-items-center">
								<div class="flex-shrink-0">
									'.avatar_alt($row['userid'], 50, 'rounded-circle mr-3').'
								</div>
								
								<div class="flex-grow-1 ms-3">
									<span class="h6 font-weight-bold mb-2">'.get_client($row['userid'], 'fullname').'</span>
									<span class="text-muted d-block">'.$row['get_date'].'</span>
								</div>
							</div>
						</div>

						<div class="col-md-5">
							<div class="d-flex justify-content-md-end align-items-center">
								<span class="text-muted fw-bold me-2">Share Post:</span>

								'.anchor_popup('https://www.facebook.com/sharer/sharer.php?u='.site_url('blog/'.$row['uri']), '<div style="font-size: 2.5em"><span class="fa-layers fa-fw"><i class="fas fa-circle" style="color: #0054b9"></i><i class="fa-inverse fab fa-facebook-f" data-fa-transform="shrink-6"></i></span></div>', ['target' => '_blank', 'width' => '600', 'height' => '500', 'screenx' => '350', 'screeny' => '100']).'
								'.anchor_popup('http://www.twitter.com/intent/tweet?url='.site_url('blog/'.$row['uri']).'&text=['.$row['title'].']', '<div style="font-size: 2.5em"><span class="fa-layers fa-fw"><i class="fas fa-circle" style="color: #0054b9"></i><i class="fa-inverse fab fa-twitter" data-fa-transform="shrink-6"></i></span></div>', ['target' => '_blank', 'width' => '600', 'height' => '500', 'screenx' => '350', 'screeny' => '100', 'class' => 'ms-2']).'
							</div>
						</div>
					</div>
				</div>
				<!--- End of User Info --->

				<div class="ph-text-article">
					<div class="d-flex justify-content-center align-items-center bg-light rounded shadow-sm mb-3">
						'.$row['thumb_l'].'
					</div>

					'.$content.'
				</div>
			</div>
		</div>
	</div>');

?>