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

	<style>
	.ph-sticky-top-event-right-side
	{
		top: 97px;
		z-index: 1010 !important;
	}
	</style>

	<div class="container my-4 my-lg-5">
		<div class="row">
			<div class="col-lg-8">
				<div class="mb-4">
					<h1 class="h2">'.$row['title'].'</h1>
				</div>
			</div>

			<div class="col-lg-8">
				<div class="ph-text-article">
					<div class="d-flex justify-content-center align-items-center bg-light rounded shadow-sm mb-3">
						'.$row['thumb_l'].'
					</div>

					'.$content.'
				</div>
			</div>

			<div class="col-lg-4">
				<div class="border rounded p-4 shadow-sm ph-sticky-top-event-right-side sticky-lg-top">

					<div class="mb-4">
						<div class="d-flex align-items-center">
							<div class="flex-shrink-0">
								'.avatar_alt($row['userid'], 50, 'rounded-circle mr-3').'
							</div>
							
							<div class="flex-grow-1 ms-3">
								<span class="h6 font-weight-bold mb-2">'.get_client($row['userid'], 'fullname').'</span>
								<span class="text-muted d-block">Published: '.$row['get_date'].'</span>
							</div>
						</div>
					</div>

					<div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item border-bottom-0 px-0">
								<span class="fw-bold">Event Date:</span> <span class="float-end">'.get_date($row['event_date']).'</span>
							</li>

							<li class="list-group-item border-bottom-0 px-0">
								<span class="fw-bold">Event Location:</span> <span class="float-end">'.$row['event_location'].'</span>
							</li>

							<li class="list-group-item border-bottom-0 px-0">
								<span class="fw-bold">Event Address:</span> <span class="float-end">'.$row['event_address'].'</span>
							</li>

							<li class="list-group-item border-bottom-0 px-0">
								<span class="fw-bold">Share:</span> 

								<span class="float-end">
									'.anchor_popup('https://www.facebook.com/sharer/sharer.php?u='.site_url('event/'.$row['uri']), '<i class="fab fa-facebook-square fa-lg"></i>', ['target' => '_blank', 'width' => '600', 'height' => '500', 'screenx' => '350', 'screeny' => '100', 'class' => 'me-3']).'
									'.anchor_popup('http://www.twitter.com/intent/tweet?url='.site_url('event/'.$row['uri']).'&text=['.$row['title'].']', '<i class="fab fa-twitter fa-lg"></i>', ['target' => '_blank', 'width' => '600', 'height' => '500', 'screenx' => '350', 'screeny' => '100', 'class' => 'me-3']).'
									'.anchor_popup('whatsapp://send?text='.site_url('event/'.$row['uri']), '<i class="fab fa-whatsapp fa-lg"></i>', ['target' => '_blank', 'width' => '600', 'height' => '500', 'screenx' => '350', 'screeny' => '100']).'
								</span>
							</li>
						</ul>
					</div>

				</div>
			</div>
		</div>
	</div>');

?>