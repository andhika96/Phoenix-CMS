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

	echo '
	<div class="container-fluid px-0 mb-5">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center">
				<div>
					<i class="fad fa-list-ul fa-fw me-2"></i> '.t('Edit Footer Content').'
				</div>
			</div>

			<div id="ar-form-submit-0">	
				<form action="'.site_url('manage_section_content/footer').'" method="post" enctype="multipart/form-data" @submit.prevent="multipleSubmit($event, \'0\')" ref="formHTML0" button-block="false" button-rounded-pill="false" font-size-large="false">						
					<div class="toast ar-notice-toast-0 position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>					

					<div class="row mb-3">
						<div class="col-12 mb-3">
							<label class="form-label">Select Footer Type</label>
							<select name="footer_left[display_type]" class="form-select font-size-inherit" aria-label="Select Footer Type" v-on:change="selectFooterType($event)">
								<option value="">Select</option>
								<option value="text">Only Text</option>
								<option value="logo">With Logo</option>
							</select>
						</div>

						<div class="col-12 mb-3">
							<div class="ar-display-footer-text" style="display: none">
								<label class="form-label">Enter Text for Heading</label>

								<input type="hidden" name="footer_left[site_name][type]" value="text">
								<input type="hidden" name="footer_left[site_name][alias]" value="empty">
								<input type="text" name="footer_left[site_name][content]" class="form-control font-size-inherit">
							</div>

							<div class="ar-display-footer-logo" style="display: none">
								<label class="form-label" for="formFile">Upload Image for Logo</label>

								<input type="hidden" name="footer_left[site_logo][type]" value="text">
								<input type="hidden" name="footer_left[site_logo][alias]" value="empty">								
								<input type="file" name="footer_left[site_logo][content]" class="form-control font-size-inherit" id="formFile">
							</div>
						</div>

						<div class="col-12">
							<label class="form-label">Description</label>

							<input type="hidden" name="footer_left[site_description][type]" value="text">
							<input type="hidden" name="footer_left[site_description][alias]" value="empty">
							<textarea name="footer_left[site_description][content]" rows="4" class="form-control font-size-inherit"></textarea>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<div>
							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit-0" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-malika-submit btn-malika-submit-0" value="'.t('Save').'">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>';


?>