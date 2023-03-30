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
	<div class="page-header" id="ar-app-form">
		<div class="page-header-image" style="background-image: url('.base_url(get_content_page('recoveryaccount', 'background', 'image_0')).')"></div>
		
		<div class="container">
			<div class="row d-flex align-items-center vh-100">
				<div class="col-md-5 mx-auto">
					<div class="card card-login card-plain mx-auto mt-0 mt-md-5 pt-0 pt-md-5" id="ar-form-submit">
						<form class="form" action="'.site_url('auth/recoveryaccount?code='.$input->get('code')).'" method="post" @submit="submit" ref="formHTML" button-block="true" button-rounded-pill="true" font-size-large="false">
							<div class="card-header text-center">
								<div class="logo-container mb-0" style="width: 200px !important">
									<a href="'.site_url().'"><img src="'.base_url(get_content_page('recoveryaccount', 'logo', 'image_0')).'" class="img-fluid" style="filter: brightness(0) invert(1);"></a>
								</div>
							</div>

							<div class="card-body">
								<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

								<p>Reset your password to get back your account</p>');

						if ($get_status_code == 1)
						{
							section_content('
								<div class="bg-white p-4 text-center text-danger shadow-sm rounded">
									Recovery Code is expired <i class="fas fa-frown fa-lg fa-fw"></i>
								</div>');
						}
						elseif ($get_status_code == 2)
						{
							section_content('
								<div class="bg-white p-4 text-center text-danger shadow-sm rounded">
									Recovery Code not found <i class="fas fa-heart-broken fa-lg fa-fw"></i>
								</div>');
						}
						elseif ($get_status_code == 0)
						{	
							section_content('
									<div class="input-group form-group-no-border input-group-md mb-3">
										<span class="input-group-text rounded-pill"><i class="fas fa-key ms-1"></i></span>
										<input type="password" name="password" v-model="form.password" class="form-control rounded-pill ms-0" placeholder="New Password">
									</div>

									<div class="input-group form-group-no-border input-group-md mb-3">
										<span class="input-group-text rounded-pill"><i class="fas fa-key ms-1"></i></span>
										<input type="password" name="password_conf" v-model="form.password_conf" class="form-control rounded-pill ms-0" placeholder="Re-type new password">
									</div>');
						}
						
	section_content('
							</div>');

					if ($get_status_code == 0)
					{
						section_content('
							<div class="card-footer text-center mt-0">
								<input type="hidden" name="step" value="post">
								<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
								<input type="submit" class="btn btn-malika-submit font-size-inherit rounded-pill px-3 py-2 w-100" value="Submit">
							</div>');
					}

	section_content('						
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