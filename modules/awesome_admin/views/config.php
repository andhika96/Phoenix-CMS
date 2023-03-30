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

	section_content(breadcrumb(['Admin Panel' => site_url('awesome_admin'), 'Configurations' => '']));

	section_content('
	<div class="mb-5">
		<div class="arv6-box bg-white p-3 p-md-4 rounded shadow-sm" id="ar-app-form">
			<div class="h5 pb-3 pb-md-4 mb-4 mb-md-5 mb-xl-4 border-bottom"><i class="fad fa-user-secret fa-fw me-2"></i> Admin Panel</div>
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<div id="ar-form-submit">
				<form action="'.site_url('awesome_admin/config').'" method="post" enctype="multipart/form-data" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">
					<!--- Site Configuration --->
					<div class="row">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-4" style="border-left: 5px #00808c solid">Site Configuration</h5>
						</div>
					</div>

					<div class="form-group row mb-3">
						<label class="col-12 col-sm-3 col-form-label text-sm-end" for="sitename">Site Name</label>

						<div class="col-12 col-sm-8 col-lg-6">
							<input type="text" name="site_name" class="form-control font-size-inherit" id="sitename" value="'.$row['site_name'].'">
						</div>
					</div>

					<div class="form-group row mb-3">
						<label class="col-12 col-sm-3 col-form-label text-sm-end" for="siteslogan">Site Slogan</label>

						<div class="col-12 col-sm-8 col-lg-6">
							<input type="text" name="site_slogan" class="form-control font-size-inherit" id="siteslogan" value="'.$row['site_slogan'].'">
						</div>
					</div>

					<div class="form-group row mb-3">
						<label class="col-12 col-sm-3 col-form-label text-sm-end" for="sitedescription">Site Description</label>

						<div class="col-12 col-sm-8 col-lg-6">
							<input type="text" name="site_description" class="form-control font-size-inherit" id="sitedescription" value="'.$row['site_description'].'">
						</div>
					</div>

					<div class="form-group row mb-3">
						<label class="col-12 col-sm-3 col-form-label text-sm-end" for="footermessage">Footer Message</label>

						<div class="col-12 col-sm-8 col-lg-6">
							<textarea name="footer_message" rows="3" class="form-control font-size-inherit" id="footermessage">'.$row['footer_message'].'</textarea>
						</div>
					</div>

					<div class="form-group row mb-3">
						<label class="col-12 col-sm-3 col-form-label text-sm-end" for="footermessage">Site Thumbnail</label>

						<div class="col-12 col-sm-8 col-lg-6">
							<img src="'.$row['get_site_thumbnail'].'" class="img-fluid rounded mb-3">

							<div class="custom-file mb-0">
								<label for="formFile" class="form-label">Choose file</label>
								<input type="file" name="thumbnail" class="form-control font-size-inherit" id="formFile">
							</div>

							<div class="form-text text-muted">The best image size we recommend is 1200 x 630px & Max File Size 8 MB</div>
						</div>
					</div>
					<!---  / End Site Configuration --->

					<!--- Privacy and Security Section --->
					<div class="row mt-5">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-4" style="border-left: 5px #00808c solid">Privacy & Security</h5>
						</div>
					</div>

					<div class="form-group row pb-3">
						<label class="col-12 col-sm-3 col-form-label text-sm-end" for="signupclosed">Setting Registration Form</label>

						<div class="col-12 col-sm-8 col-lg-6">
							<select name="signup_closed" class="form-select font-size-inherit" id="signupclosed">
								<option value="0" '.$signup_closed_0.'>Open - Accepting new members</option>
								<option value="1" '.$signup_closed_1.'>Close - Not accepting new members</option>
							</select>
						</div>
					</div>
					<!--- / End Privacy and Security Section --->

					<!--- Site Status Settings Section --->
					<div class="row mt-5">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-4" style="border-left: 5px #00808c solid">Site Status Settings</h5>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-12 col-sm-3 col-form-label text-sm-end" for="offlinemode">Maintenance Mode</label>

						<div class="col-12 col-sm-8 col-lg-6 pt-1">
							<div class="ar-switch-button ar-switch-button-success">
								<input type="checkbox" name="offline_mode" id="offlinemode" '.$offline_mode.'>
								<span><label for="offlinemode"></label></span>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-12 col-sm-3 col-form-label text-sm-end" for="offlinereason">Offline Reason</label>

						<div class="col-12 col-sm-8 col-lg-6">
							<textarea name="offline_reason" rows="3" placeholder="Even though it\'s offline, you can still access the admin area" class="form-control font-size-inherit" id="offlinereason">'.$row['offline_reason'].'</textarea>
						</div>
					</div>
					<!--- / End Site Status Settings Section --->

					<div class="row">
						<div class="col-12 col-sm-8 col-lg-6 offset-sm-3 offset-lg-3 text-end">
							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-malika-submit font-size-inherit" value="Save">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>');

?>