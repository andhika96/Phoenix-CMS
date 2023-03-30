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

	section_content('
	<div class="page-header">
		<div class="page-header-image" style="background-image: url('.base_url(get_content_page('signuppage', 'background', 'image_0')).')"></div>
		
		<div class="container my-2 my-md-5">
			<div class="row d-flex align-items-center" style="min-height: 100vh">
				<div class="col-md-5 d-none d-sm-block mx-auto mt-5 mt-md-0 mb-4 mb-md-0">
					<div class="d-flex mb-5">
						<div class="flex-shrink-0">
							'.get_content_page('signuppage', 'description_0', 'icon').'
						</div>

						<div class="flex-grow-1 ms-3">
							<h5 class="mt-0">'.get_content_page('signuppage', 'description_0', 'title').'</h5>
					
							'.get_content_page('signuppage', 'description_0', 'description').'
						</div>
					</div>

					<div class="d-flex">
						<div class="flex-shrink-0">
							'.get_content_page('signuppage', 'description_1', 'icon').'
						</div>
						
						<div class="flex-grow-1 ms-3">
							<h5 class="mt-0">'.get_content_page('signuppage', 'description_1', 'title').'</h5>
					
							'.get_content_page('signuppage', 'description_1', 'description').'
						</div>
					</div>
				</div>

				<div class="col-md-4 mr-auto" id="ar-app-form">
					<div class="sk-notice-toast position-relative mt-2" aria-live="polite" aria-atomic="true"></div>

					<div class="card card-signup mx-auto mt-4" id="ar-form-signup">
						<form class="form" action="'.site_url('auth/signup').'" method="post" @submit="submitForSignup" ref="formHTML" button-block="false" button-rounded-pill="true" font-size-large="false" class="needs-validation" novalidate>
							<div class="card-body px-4">
								<h4 class="card-title font-weight-normal text-center">Register</h4>
								<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

								<div class="mt-4 mb-3">
									<div class="input-group input-group-signup input-group-md">
										<span class="input-group-text rounded-pill bg-white border-end-0 me-0" v-bind:class="{\'is-valid\': this.initFormSignup.email == false, \'is-invalid\': this.initFormSignup.email == true}"><i class="fas fa-at ms-1"></i></span>

										<input type="text" name="email" class="form-control rounded-pill border-left-0 ms-0" placeholder="Email Address" v-bind:class="{\'is-valid\': this.initFormSignup.email == false, \'is-invalid\': this.initFormSignup.email == true}">
									
										<div class="invalid-feedback mt-1 ml-2">{{ responseMessageSignup.email }}</div>
									</div>
								</div>

								<div class="mb-3">
									<div class="input-group input-group-signup input-group-md">
										<span class="input-group-text rounded-pill bg-white border-end-0 me-0" v-bind:class="{\'is-valid\': this.initFormSignup.username == false, \'is-invalid\': this.initFormSignup.username == true}"><i class="fas fa-user ms-1"></i></span>

										<input type="text" name="username" class="form-control rounded-pill border-left-0 ms-0" placeholder="Username" v-bind:class="{\'is-valid\': this.initFormSignup.username == false, \'is-invalid\': this.initFormSignup.username == true}">
									
										<div class="invalid-feedback mt-1 ml-2">{{ responseMessageSignup.username }}</div>
									</div>
								</div>

								<div class="mb-3">
									<div class="input-group input-group-signup input-group-md">
										<span class="input-group-text rounded-pill bg-white border-end-0 me-0" v-bind:class="{\'is-valid\': this.initFormSignup.fullname == false, \'is-invalid\': this.initFormSignup.fullname == true}"><i class="fas fa-marker ms-1"></i></span>

										<input type="text" name="fullname" class="form-control rounded-pill border-left-0 ms-0" placeholder="Full Name" v-bind:class="{\'is-valid\': this.initFormSignup.fullname == false, \'is-invalid\': this.initFormSignup.fullname == true}">
									
										<div class="invalid-feedback mt-1 ml-2">{{ responseMessageSignup.fullname }}</div>
									</div>
								</div>

								<div class="input-group input-group-signup input-group-md">
									<span class="input-group-text rounded-pill bg-white border-end-0 me-0" v-bind:class="{\'is-valid\': this.initFormSignup.password == false, \'is-invalid\': this.initFormSignup.password == true}"><i class="fas fa-key ms-1"></i></span>

									<input type="password" name="password" class="form-control rounded-pill border-left-0 ms-0" placeholder="Password" v-bind:class="{\'is-valid\': this.initFormSignup.password == false, \'is-invalid\': this.initFormSignup.password == true}">
								
									<div class="invalid-feedback mt-1 ml-2">{{ responseMessageSignup.password }}</div>
								</div>

								<div class="form-check custom-checkbox text-dark text-center mt-4">
									<input type="checkbox" name="agreecheck" class="form-check-input float-none me-1" v-bind:class="{\'is-valid\': this.initFormSignup.agreecheck == false, \'is-invalid\': this.initFormSignup.agreecheck == true}" id="customCheck1" value="1" '.$checkbox.'>
									<label class="form-check-label" for="customCheck1">I agree to the terms and conditions.</label>
									
									<div class="invalid-feedback mt-1 ml-3">{{ responseMessageSignup.agreecheck }}</div>
								</div>
							</div>

							<div class="card-footer text-center px-0 bg-white border-0 mt-3">');

							if (get_csite('signup_closed') == 1)
							{
								section_content('
								<a href="javascript:void(0);" class="btn btn-danger px-3 py-2 rounded-pill">Closed</a>');
							}
							else
							{
								section_content('
								<input type="hidden" name="step" value="post">
								<input type="hidden" class="btn-token-signup" name="'.$csrf_name.'" value="'.$csrf_hash.'">
								<input type="submit" class="btn btn-malika-signup font-size-inherit px-3 py-2 rounded-pill" value="Signup">');
							}

	section_content('
								<hr class="border-top m-4">

								<span class="text-dark">Already have an acocunt?</span> <a href="'.site_url('auth/login').'">Login</a>
							</div>
						</form>
					</div>
				</div>

				<div class="col-12 mt-5">
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