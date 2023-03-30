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
		<div class="page-header-image" style="background-image: url('.base_url(get_content_page('activationaccount', 'background', 'image_0')).')"></div>
		
		<div class="container">
			<div class="row d-flex align-items-center vh-100">
				<div class="col-md-5 mx-auto">
					<div class="card card-login card-plain mx-auto mt-0 mt-md-5 pt-0 pt-md-5">
						<div class="card-header text-center">
							<div class="logo-container mb-0" style="width: 200px !important">
								<a href="'.site_url().'"><img src="'.base_url(get_content_page('activationaccount', 'logo', 'image_0')).'" class="img-fluid" style="filter: brightness(0) invert(1);"></a>
							</div>
						</div>

						<div class="card-body">');

					if ($get_status_code == 1)
					{
						section_content('
							<div class="bg-white p-4 text-center text-danger shadow-sm rounded">
								Activation Code not found <i class="fas fa-frown fa-lg fa-fw"></i>
							</div>');
					}
					elseif ($get_status_code == 0)
					{	
						section_content('
							<div class="bg-white p-4 text-center text-success shadow-sm rounded">
								Activation account success, please login with your account now <i class="fas fa-check fa-lg fa-fw"></i>
							
								<div class="d-block mt-3"><a href="'.site_url('auth/login').'">Login to Account <i class="fad fa-chevron-double-right fa-fw"></i></a></div>
							</div>');
					}
						
	section_content('
						</div>						
					</div>
				</div>

				<div class="col-12">
					<div class="row no-gutters align-items-center justify-content-md-between">
						<div class="col-md-6">
							<div class="copyright text-sm text-center text-md-left">
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