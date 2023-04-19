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

	section_content(breadcrumb([t('Manage News') => site_url('manage_news'), t('Layout Settings') => '']));

	section_content('
	<div class="container-fluid px-0 mb-5">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm" id="ar-app-listdata">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center">
				<div>
					<i class="fad fa-swatchbook fa-fw me-2"></i> '.t('Layout Settings').'
				</div> 
			</div>

			<div id="ar-form-submit">
				<form action="'.site_url('manage_portofolio/layout').'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="false" with-list-slideshow-page="false" with-list-coverimage-page="false" ref="formHTML">
					<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

					<div class="row mb-4">
						<div class="col-12 mb-4">
							<h6 class="mb-0 pb-3 border-bottom">- Layout & Content Settings</h6>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Select View Layout</label>

								<select name="view_type" class="form-select font-size-inherit" aria-label="Select Slideshow to Show">
									<option value="">Select</option>
									<option value="list" '.$view_type[0].'>List</option>
									<option value="grid" '.$view_type[1].'>Grid</option>
								</select>
							</div>

							<div class="col-md-6 mb-3">
								<label class="form-label">Hide Category</label>

								<select name="is_hide_category" class="form-select font-size-inherit" aria-label="Select Adaptive Height">
									<option value="">Select</option>
									<option value="1" '.$is_hide_category[1].'>Active</option>
									<option value="0" '.$is_hide_category[0].'>Non Active</option>
								</select>
							</div>

							<div class="col-md-6 mb-3">
								<label class="form-label">Hide Sidebar</label>

								<select name="is_hide_sidebar" class="form-select font-size-inherit" aria-label="Select Adaptive Height" disabled>
									<option value="">Select</option>
									<option value="1" '.$is_hide_sidebar[1].'>Active</option>
									<option value="0" '.$is_hide_sidebar[0].'>Non Active</option>
								</select>

								<div class="badge rounded-pill text-bg-info text-small mt-2">Coming soon</div>
							</div>

							<div class="col-md-6 mb-3">
								<label class="form-label">Sidebar Position</label>

								<select name="sidebar_position" class="form-select font-size-inherit" aria-label="Select Slideshow to Show" '.$disable_sidebar_position.'>
									<option value="">Select</option>
									<option value="left" '.$sidebar_position[0].'>Left</option>
									<option value="right" '.$sidebar_position[1].'>Right</option>
								</select>

								'.$notice_disable_sidebar_position.' <div class="badge rounded-pill text-bg-info text-small mt-2">Coming soon</div>
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<div>
							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-malika-submit" value="'.t('Save').'">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>');


?>