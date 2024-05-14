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

	$auto_redirect_link = $session->userdata('redirect_to') ? $session->userdata('redirect_to') : site_url('dashboard');
	$auto_notice_page = $session->userdata('redirect_to') ? '<div class="text-bg-warning rounded p-3 mb-3"><i class="far fa-exclamation-circle fa-fw"></i> You must login first to continue</div>' : '';

	section_content('
	<div class="page-header" id="ar-app-form">
		<div class="page-header-image" style="background-image: url('.base_url(get_content_page('loginpage', 'background', 'image_0')).')"></div>
		
		<div class="container">
			<div class="row d-flex align-items-center vh-100">
				<div class="col-md-5 mx-auto">
					<div class="card card-login card-plain mx-auto mt-0 mt-md-5 pt-0 pt-md-5" id="ar-form-submit">
						<form action="'.site_url('auth/login').'" method="post" @submit="submit" ref="formHTML" button-block="true" button-rounded-pill="true" font-size-large="false">
							<div class="card-header py-3 text-center">
								<div class="logo-container mb-2" style="width: 200px !important">
									<a href="'.site_url().'"><img src="'.base_url(get_content_page('loginpage', 'logo', 'image_0')).'" class="img-fluid" style="filter: brightness(0) invert(1);"></a>
								</div>
							</div>

							<div class="card-body">
								'.$auto_notice_page.'

								<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

								<div class="input-group form-group-no-border input-group-md mb-3">
									<span class="input-group-text rounded-pill"><i class="fas fa-at ms-1"></i></span>
									<input type="text" name="email" v-model="form.email" class="form-control rounded-pill ms-0" placeholder="Email Address">
								</div>

								<div class="input-group form-group-no-border input-group-md">
									<span class="input-group-text rounded-pill"><i class="fas fa-key ms-1"></i></span>
									<input type="password" name="password" v-model="form.password" class="form-control rounded-pill ms-0" placeholder="Password">
								</div>
							</div>

							<div class="card-footer text-center mt-3">
								<div class="custom-control custom-checkbox text-white text-left mb-3 d-none">
									<input type="checkbox" name="reauth_me" class="custom-control-input" id="customCheck1">
									<label class="custom-control-label" for="customCheck1">Remember me</label>
								</div>
								
								<input type="hidden" name="step" value="post">
								<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
								<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-inherit rounded-pill px-3 py-2 w-100" value="Login">
							
								<div class="d-flex justify-content-between mt-3">
									<div><a href="'.site_url('auth/signup').'" class="text-white">Create Account</a></div>
									<div><a href="'.site_url('auth/forgotpassword').'" class="text-white">Forgot Password?</a></div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="col-12">
					<div class="row no-gutters align-items-center justify-content-md-between">
						<div class="col-md-6">
							<div class="copyright text-sm text-center text-md-start">
								'.get_csite('footer_message').'
							</div>
						</div>

						<div class="col-md-6">
							<div class="d-flex justify-content-center justify-content-md-end mt-3 mt-md-0">'.get_section_page('footer', 'footer_bottom', 'content_right').'</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>');

?>